<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(): void
    {
        if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = "Unauthorized";
            $this->redirect('/home/index');
        }

        $productModel = new Product();
        $products = $productModel->getAll();

        $this->view('admin/products/index', [
            'title' => 'Manage Products',
            'products' => $products
        ]);
    }
    public function create(): void
{
    if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        $_SESSION['error'] = "Unauthorized access";
        $this->redirect('/home/index');
    }

    $this->view('admin/products/create', [
        'title' => 'Add Product'
    ]);
}

public function store(): void
{
    if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        $_SESSION['error'] = "Unauthorized action";
        $this->redirect('/home/index');
    }

    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $description = $_POST['description'] ?? '';
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    if (empty($name) || empty($price)) {
        $_SESSION['error'] = "Name and Price are required.";
        $this->redirect('/admin/products/create');
    }

    // Handle Image upload
    $imagePath = null;

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetPath = dirname(__DIR__, 2) . "/public/uploads/" . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $imagePath = "/uploads/" . $imageName;
        }
    }

    $productModel = new Product();
    $productModel->createProduct([
        'name' => $name,
        'price' => $price,
        'stock' => $stock,
        'description' => $description,
        'is_featured' => $is_featured,
        'image' => $imagePath
    ]);

    $_SESSION['success'] = "Product created successfully!";
    $this->redirect('/admin/products');
}
public function edit(int $id): void
{
    if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        $_SESSION['error'] = "Unauthorized";
        $this->redirect('/home/index');
    }

    $productModel = new Product();
    $product = $productModel->find($id);

    if (!$product) {
        $_SESSION['error'] = "Product not found";
        $this->redirect('/product/index');
    }

    $this->view('admin/products/edit', [
        'title' => 'Edit Product',
        'product' => $product
    ]);
}
public function update(int $id): void
{
    $productModel = new Product();
    $product = $productModel->find($id);

    if (!$product) {
        $_SESSION['error'] = "Product not found";
        $this->redirect('/product/index');
    }

    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $imagePath = $product['image'] ?? null;


    if (!empty($_FILES['image']['name'])) {
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetPath = dirname(__DIR__, 2) . "/public/uploads/" . $fileName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $imagePath = "/uploads/" . $fileName;
        }
    }

    $productModel->updateProduct($id, [
        'name' => $name,
        'price' => $price,
        'stock' => $stock,
        'description' => $description,
        'is_featured' => $is_featured,
        'image' => $imagePath
    ]);

    $_SESSION['success'] = "Product updated successfully";
    $this->redirect('/product/index');
}
public function delete(int $id): void
{
    $productModel = new Product();
    $productModel->deleteProduct($id);

    $_SESSION['success'] = "Product deleted successfully";
    $this->redirect('/product/index');
}

}
