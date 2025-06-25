
use App\Http\Controllers\PaymentController;
Route::view('/admin/pay', 'admin/payment_form');
Route::post('/payment/create-order', [PaymentController::class, 'createOrder']);
Route::post('/payment/verify', [PaymentController::class, 'verifyPayment']);
