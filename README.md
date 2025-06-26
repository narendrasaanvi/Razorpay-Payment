Step 1.

composer require razorpay/razorpay


Step 2.
.env
RAZORPAY_KEY=
RAZORPAY_SECRET=''

Step 3.
 Create Razorpay Service Class
app/Services/RazorpayService.php

Step 4: 
Add Razorpay to config/services.php

    'razorpay' => [
        'key' => env('RAZORPAY_KEY'),
        'secret' => env('RAZORPAY_SECRET'),
    ],

