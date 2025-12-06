<h1>Add Product</h1>

<?php if (!empty($_SESSION['error'])): ?>
    <p style="color:red"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<form action="/ecommerce-mvc/public/product/store" method="post" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

    <label>Name</label><br>
    <input type="text" name="name" required><br><br>

    <label>Price</label><br>
    <input type="number" step="0.01" name="price" required><br><br>

    <label>Stock</label><br>
    <input type="number" name="stock" required><br><br>

    <label>Description</label><br>
    <textarea name="description"></textarea><br><br>

    <label>Featured</label>
    <input type="checkbox" name="is_featured"><br><br>

    <label>Image</label><br>
    <input type="file" name="image" accept="image/*"><br><br>

    <button type="submit">Create</button>
</form>

<br>
<a href="/ecommerce-mvc/public/admin/products">Back to Products</a>
