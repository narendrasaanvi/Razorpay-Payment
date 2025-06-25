Step 1.

composer require razorpay/razorpay


Step 2.
.env
RAZORPAY_KEY=rzp_test_oVnks7LPwzl0s1
RAZORPAY_SECRET='hq90vSRxjbHd3u2AnrmWlugA'

Step 3.
 Create Razorpay Service Class
app/Services/RazorpayService.php

Step 4: 
Add Razorpay to config/services.php

    'razorpay' => [
        'key' => env('RAZORPAY_KEY'),
        'secret' => env('RAZORPAY_SECRET'),
    ],

