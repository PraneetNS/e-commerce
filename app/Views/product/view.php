<div class="row">
    <div class="col-md-5">
        <img src="/ecommerce-mvc/public<?= $product['image'] ?>" class="img-fluid">
    </div>

    <div class="col-md-7">
        <h2><?= $product['name'] ?></h2>
        <h4 class="text-success">₹<?= $product['price'] ?></h4>
        <p><?= $product['description'] ?></p>

        <form action="/ecommerce-mvc/public/cart/add/<?= $product['id'] ?>" method="post">
            <label>Qty:</label>
            <input type="number" name="qty" value="1" min="1" class="form-control w-25">
            <button class="btn btn-success mt-2">Add to Cart</button>
        </form>

        <br>
        <a href="/ecommerce-mvc/public/home/index" class="btn btn-secondary">Back</a>
    </div>
</div>
<hr>
<h3>Reviews</h3>

<?php foreach ($reviews as $r): ?>
    <p><strong><?= $r['name'] ?>:</strong> ⭐<?= $r['rating'] ?>/5</p>
    <p><?= $r['review'] ?></p>
    <hr>
<?php endforeach; ?>

<?php if (!empty($_SESSION['user'])): ?>
<form action="/ecommerce-mvc/public/review/add/<?= $product['id'] ?>" method="post">
    <label>Rating</label>
    <select name="rating" class="form-control w-25">
        <option>1</option><option>2</option><option>3</option>
        <option>4</option><option>5</option>
    </select>
    <br>

    <label>Review</label>
    <textarea name="review" class="form-control"></textarea>
    <br>
    <button class="btn btn-primary">Submit</button>
</form>
<?php else: ?>
    <p><a href="/ecommerce-mvc/public/auth/login">Login</a> to write a review</p>
<?php endif; ?>
<?php if (!empty($_SESSION['recently_viewed'])): ?>
<hr>
<h3>Recently Viewed</h3>
<div class="row">
<?php foreach ($_SESSION['recently_viewed'] as $rv): ?>
    <?php if ($rv['id'] != $product['id']): ?>
        <div class="col-md-3">
            <div class="card mb-3">
                <img src="/ecommerce-mvc/public<?= $rv['image'] ?>" class="card-img-top" style="height:150px; object-fit:cover;">
                <div class="card-body">
                    <p><?= $rv['name'] ?></p>
                    <a href="/ecommerce-mvc/public/product/show/<?= $rv['id'] ?>" class="btn btn-primary btn-sm">View</a>
                    $related = $productModel->related($product['category_id'], $id);

                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
</div>
<?php endif; ?>
<?php if (!empty($related)): ?>
<hr>
<h3>Recommended Products</h3>
<div class="row">
<?php foreach ($related as $rp): ?>
    <div class="col-md-3">
        <div class="card mb-3">
            <img src="/ecommerce-mvc/public<?= $rp['image'] ?>" class="card-img-top" style="height:150px; object-fit:cover;">
            <div class="card-body">
                <p><?= $rp['name'] ?></p>
                <a href="/ecommerce-mvc/public/product/show/<?= $rp['id'] ?>" class="btn btn-outline-primary btn-sm">View</a>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>
<?php endif; ?>

