<h1>Product Management</h1>

<a href="/ecommerce-mvc/public/admin/products/create">Add Product</a>
<hr>

<?php if (!empty($_SESSION['success'])): ?>
    <p style="color:green"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php endif; ?>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Name</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Featured</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($products as $item): ?>
    <tr>
        <td><?= $item['id'] ?></td>
        <td>
            <?php if (!empty($item['image'])): ?>
                <img src="/ecommerce-mvc/public<?= $item['image'] ?>" width="60">
            <?php endif; ?>
        </td>
        <td><?= $item['name'] ?></td>
        <td><?= $item['price'] ?></td>
        <td><?= $item['stock'] ?></td>
        <td><?= $item['is_featured'] ?></td>
        <td>
            <a href="/ecommerce-mvc/public/product/edit/<?= $item['id'] ?>">Edit</a> |
            <a href="/ecommerce-mvc/public/product/delete/<?= $item['id'] ?>" onclick="return confirm('Delete product?');">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

