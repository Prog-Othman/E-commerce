<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->cart()->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        return view('checkout.index', compact('cart'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return back()->with('error', 'Invalid coupon code.');
        }

        if (!$coupon->isValid()) {
            return back()->with('error', 'This coupon is no longer valid.');
        }

        $cart = auth()->user()->cart()->with('items.product')->first();
        $discount = $coupon->calculateDiscount($cart->total);

        if ($discount === 0) {
            return back()->with('error', 'This coupon cannot be applied to your cart.');
        }

        session(['coupon' => $coupon]);

        return back()->with('success', 'Coupon applied successfully.');
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Coupon removed successfully.');
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'stripe_token' => 'required_if:payment_method,stripe',
            'payment_method' => 'required|in:stripe,paypal',
        ]);

        $cart = auth()->user()->cart()->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        try {
            $total = $cart->total;
            $coupon = session('coupon');

            if ($coupon) {
                $discount = $coupon->calculateDiscount($total);
                $total -= $discount;
            }

            if ($request->payment_method === 'stripe') {
                Stripe::setApiKey(config('services.stripe.secret'));

                $paymentIntent = PaymentIntent::create([
                    'amount' => $total * 100, // Convert to cents
                    'currency' => 'usd',
                    'payment_method' => $request->stripe_token,
                    'confirmation_method' => 'manual',
                    'confirm' => true,
                ]);

                if ($paymentIntent->status === 'requires_action') {
                    return response()->json([
                        'requires_action' => true,
                        'payment_intent_client_secret' => $paymentIntent->client_secret,
                    ]);
                }

                if ($paymentIntent->status === 'succeeded') {
                    return $this->createOrder($request, $cart, $coupon);
                }
            } else {
                // Handle PayPal payment
                return $this->createOrder($request, $cart, $coupon);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    protected function createOrder(Request $request, Cart $cart, ?Coupon $coupon = null)
    {
        $total = $cart->total;
        $discount = 0;

        if ($coupon) {
            $discount = $coupon->calculateDiscount($total);
            $total -= $discount;
            $coupon->markAsUsed(auth()->user());
        }

        $order = auth()->user()->orders()->create([
            'total_amount' => $total,
            'discount_amount' => $discount,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $request->payment_method,
            'shipping_address' => $request->shipping_address,
            'shipping_city' => $request->shipping_city,
            'shipping_state' => $request->shipping_state,
            'shipping_country' => $request->shipping_country,
            'shipping_zipcode' => $request->shipping_zipcode,
            'shipping_phone' => $request->shipping_phone,
            'notes' => $request->notes,
        ]);

        if ($coupon) {
            $order->coupon()->associate($coupon);
            $order->save();
        }

        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'subtotal' => $item->subtotal,
            ]);

            // Update product stock
            $item->product->decrement('stock', $item->quantity);
        }

        // Clear the cart and coupon
        $cart->items()->delete();
        session()->forget('coupon');

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order placed successfully!');
    }
} 