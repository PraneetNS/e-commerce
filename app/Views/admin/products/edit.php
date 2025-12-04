<h1>Edit Product</h1>

<?php if (!empty($_SESSION['error'])): ?>
    <p style="color:red"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<form action="/ecommerce-mvc/public/product/update/<?= $product['id'] ?>" method="post" enctype="multipart/form-data">

    <label>Name</label><br>
    <input type="text" name="name" value="<?= $product['name'] ?>" required><br><br>

    <label>Price</label><br>
    <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required><br><br>

    <label>Stock</label><br>
    <input type="number" name="stock" value="<?= $product['stock'] ?>" required><br><br>

    <label>Description</label><br>
    <textarea name="description"><?= $product['description'] ?></textarea><br><br>

    <label>Featured</label>
    <input type="checkbox" name="is_featured" <?= $product['is_featured'] ? 'checked' : '' ?>><br><br>

    <label>Image</label><br>
    <?php if (!empty($product['image'])): ?>
        <img src="/ecommerce-mvc/public<?= $product['image'] ?>" width="90"><br>
    <?php endif; ?>
    <input type="file" name="image"><br><br>

    <button type="submit">Update Product</button>
</form>

<br>
<a href="/ecommerce-mvc/public/product/index">Back</a>
