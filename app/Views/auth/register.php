<div class="d-flex justify-content-center">
  <form action="/ecommerce-mvc/public/auth/registerSubmit" method="post" class="card shadow p-4 mt-4" style="width: 400px;">
    <h3 class="text-center mb-3">Create Account</h3>

    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">


    <div class="mb-3">
      <label class="form-label">Full Name</label>
      <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <button class="btn btn-primary w-100">Register</button>

    <p class="text-center mt-2">
        Already have an account? <a href="/ecommerce-mvc/public/auth/login">Login</a>
    </p>
  </form>
</div>
