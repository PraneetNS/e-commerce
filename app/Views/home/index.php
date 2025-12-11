<h3>Categories</h3>
<div class="mb-3">
<?php foreach ($categories as $c): ?>
    <a href="/ecommerce-mvc/public/home/category/<?= $c['id'] ?>" class="btn btn-outline-primary btn-sm">
        <?= $c['name'] ?>
    </a>
<?php endforeach; ?>
</div>
<form action="/ecommerce-mvc/public/home/filter" method="get" class="row mb-4">

    <div class="col-md-3 mb-2">
        <input type="text" name="search" value="<?= $search ?? '' ?>" class="form-control" placeholder="Search product...">
    </div>

    <div class="col-md-2 mb-2">
        <input type="number" name="min" class="form-control" placeholder="Min Price">
    </div>

    <div class="col-md-2 mb-2">
        <input type="number" name="max" class="form-control" placeholder="Max Price">
    </div>

    <div class="col-md-2 mb-2">
        <select name="category" class="form-control">
            <option value="">All Categories</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-2 mb-2">
        <select name="sort" class="form-control">
            <option value="latest">Latest</option>
            <option value="low-high">Price: Low to High</option>
            <option value="high-low">Price: High to Low</option>
            <option value="newest">Newest</option>
        </select>
    </div>

    <div class="col-md-1 mb-2">
        <button class="btn btn-primary w-100">Apply</button>
    </div>

</form>
