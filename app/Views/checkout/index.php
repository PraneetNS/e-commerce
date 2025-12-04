<h1>Checkout</h1>

<?php if (!empty($_SESSION['error'])): ?>
    <p style="color:red"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<table border="1" cellpadding="5">
    <tr>
        <th>Name</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Total</th>
    </tr>

<?php $grand = 0; foreach ($cart as $item): 
    $total = $item['qty'] * $item['price'];
    $grand += $total;
?>
    <tr>
        <td><?= $item['name'] ?></td>
        <td><?= $item['qty'] ?></td>
        <td>₹<?= $item['price'] ?></td>
        <td>₹<?= $total ?></td>
    </tr>
<?php endforeach; ?>
</table>

<h3>Grand Total: ₹<?= $grand ?></h3>

<form action="/ecommerce-mvc/public/checkout/placeOrder" method="post">
    <label>Shipping Address:</label><br>
    <textarea name="address" required></textarea><br><br>
    <button type="submit">Place Order</button>
</form>
<form action="/ecommerce-mvc/public/checkout/placeOrder" method="post">
    <label>Shipping Address:</label><br>
    <textarea name="address" class="form-control mb-3" required></textarea>
<button id="payBtn" class="btn btn-primary">Pay Now</button>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "rzp_test_YOURKEYHERE",
    "amount": "<?= $grand * 100 ?>",
    "currency": "INR",
    "name": "Ecommerce MVC",
    "description": "Order Payment",
    "handler": function (response){
        var form = document.createElement('form');
        form.method = 'post';
        form.action = "/ecommerce-mvc/public/payment/success";

        form.innerHTML = `
            <input type="hidden" name="razorpay_payment_id" value="${response.razorpay_payment_id}">
            <input type="hidden" name="razorpay_order_id" value="${response.razorpay_order_id}">
            <input type="hidden" name="razorpay_signature" value="${response.razorpay_signature}">
        `;

        document.body.appendChild(form);
        form.submit();
    }
};
var rzp1 = new Razorpay(options);

document.getElementById("payBtn").onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>

