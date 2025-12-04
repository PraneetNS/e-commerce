<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Order;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    public function success(): void
    {
        if (!isset($_POST['razorpay_payment_id'])) {
            $_SESSION['error'] = "Payment failed or cancelled";
            $this->redirect('/checkout/index');
        }

        require dirname(__DIR__, 2) . '/vendor/autoload.php';

        $api = new Api("YOUR_KEY_ID", "YOUR_KEY_SECRET");

        $attributes = [
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_order_id' => $_POST['razorpay_order_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        ];

        try {
            $api->utility->verifyPaymentSignature($attributes);

            // payment verified → mark order paid
            $orderModel = new Order();
            $orderModel->markPaid($_SESSION['last_order_id'], $_POST['razorpay_payment_id']);

            unset($_SESSION['cart']);

            $_SESSION['success'] = "Payment successful!";
            $this->redirect("/checkout/success");

        } catch (\Exception $e) {
            $_SESSION['error'] = "Payment verification failed";
            $this->redirect('/checkout/index');
        }
    }
}
