<?php

namespace App\Services;

use Razorpay\Api\Api;
use Exception;

class RazorpayService
{
    protected $api;

    public function __construct()
    {
        $this->api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );
    }

    /**
     * Create an order in Razorpay
     *
     * @param int $amount in INR paisa (e.g. 50000 for ₹500)
     * @param string $receipt_id
     * @return array
     */
    public function createOrder($amount, $receipt_id)
    {
        try {
            $order = $this->api->order->create([
                'receipt' => $receipt_id,
                'amount' => $amount,
                'currency' => 'INR',
                'payment_capture' => 1
            ]);

            return $order->toArray();
        } catch (Exception $e) {
            throw new Exception("Razorpay Order Creation Failed: " . $e->getMessage());
        }
    }

    /**
     * Verify payment signature
     */
    public function verifySignature($attributes)
    {
        try {
            $this->api->utility->verifyPaymentSignature($attributes);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
