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
