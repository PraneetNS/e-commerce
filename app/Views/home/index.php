<h3>Categories</h3>
<div class="mb-3">
<?php foreach ($categories as $c): ?>
    <a href="/ecommerce-mvc/public/home/category/<?= $c['id'] ?>" class="btn btn-outline-primary btn-sm">
        <?= $c['name'] ?>
    </a>
<?php endforeach; ?>
</div>

<form action="/ecommerce-mvc/public/home/filter" method="get" class="row mb-4">

    <div class="col-md-3">
        <input type="number" name="min" class="form-control" placeholder="Min Price">
    </div>

    <div class="col-md-3">
        <input type="number" name="max" class="form-control" placeholder="Max Price">
    </div>

    <div class="col-md-3">
        <select name="sort" class="form-control">
            <option value="">Sort By</option>
            <option value="low-high">Price: Low to High</option>
            <option value="high-low">Price: High to Low</option>
            <option value="newest">Newest</option>
        </select>
    </div>

    <div class="col-md-3">
        <button class="btn btn-primary w-100">Apply</button>
    </div>

</form>


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
            <a href="/ecommerce-mvc/public/wishlist/add/<?= $p['id'] ?>" class="btn btn-outline-danger btn-sm">❤️ Wishlist</a>

        </div>
    </div>
</div>
<?php endforeach; ?>
</div>
