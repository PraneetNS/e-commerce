<h1 class="mb-4">Featured Products</h1>

<div class="row">
<?php foreach ($products as $p): ?>
<div class="col-md-3 mb-4">
    <div class="card h-100">
        <?php if (!empty($p['image'])): ?>
            <img src="/ecommerce-mvc/public<?= $p['image'] ?>" class="card-img-top" style="height:200px; object-fit:cover;">
        <?php endif; ?>
        <div class="card-body">
            <h5 class="card-title"><?= $p['name'] ?></h5>
            <p class="card-text">₹<?= $p['price'] ?></p>
            <a href="/ecommerce-mvc/public/product/show/<?= $p['id'] ?>" class="btn btn-primary">View Details</a>
        </div>
    </div>
</div>
<?php endforeach; ?>
</div>
