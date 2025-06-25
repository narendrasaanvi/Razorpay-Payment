<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RazorpayService;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected $razorpay;

    public function __construct(RazorpayService $razorpay)
    {
        $this->razorpay = $razorpay;
    }

    public function createOrder(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $amountInPaisa = $validated['amount'] * 100;
        $receiptId = Str::uuid()->toString();

        $order = $this->razorpay->createOrder($amountInPaisa, $receiptId);

        return response()->json([
            'order_id' => $order['id'],
            'amount' => $order['amount'],
            'currency' => $order['currency'],
            'key' => config('services.razorpay.key'),
        ]);
    }

public function verifyPayment(Request $request)
{
    $attributes = $request->only([
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature'
    ]);

    $isValid = $this->razorpay->verifySignature($attributes);

    if ($isValid) {
        return response()->json([
            'status' => 'success',
            'transaction_id' => $attributes['razorpay_payment_id'],
            'order_id' => $attributes['razorpay_order_id'],
            'message' => 'Payment verified successfully.'
        ]);
    } else {
        return response()->json([
            'status' => 'failed',
            'transaction_id' => $attributes['razorpay_payment_id'] ?? null,
            'order_id' => $attributes['razorpay_order_id'] ?? null,
            'message' => 'Invalid payment signature. Payment verification failed.'
        ], 400);
    }
}

}
