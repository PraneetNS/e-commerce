<h1>Admin Dashboard</h1>
<hr>

<div class="row text-center mb-4">
    <div class="col-md-3">
        <div class="card p-3 bg-primary text-white">
            <h4>Orders</h4>
            <h2><?= $stats['orders'] ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 bg-success text-white">
            <h4>Revenue</h4>
            <h2>₹<?= number_format($stats['revenue']) ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 bg-warning text-white">
            <h4>Products</h4>
            <h2><?= $stats['products'] ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 bg-dark text-white">
            <h4>Users</h4>
            <h2><?= $stats['users'] ?></h2>
        </div>
    </div>
</div>

<h3>Monthly Sales</h3>
<canvas id="salesChart"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('salesChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode(array_column($stats['chartData'], 'month')) ?>,
        datasets: [{
            label: 'Revenue',
            data: <?= json_encode(array_column($stats['chartData'], 'revenue')) ?>,
            borderWidth: 2
        }]
    }
});
</script>
