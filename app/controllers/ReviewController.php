<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function add(int $productId): void
    {
        if (empty($_SESSION['user'])) {
            $_SESSION['error'] = "Login required";
            $this->redirect('/auth/login');
        }

        $rating = $_POST['rating'];
        $review = $_POST['review'];

        $reviewModel = new Review();
        $reviewModel->add($productId, $_SESSION['user']['id'], $rating, $review);

        $_SESSION['success'] = "Review added successfully";
        $this->redirect("/product/show/$productId");
    }
}
