<!-- filepath: /opt/lampp/htdocs/payKaryawan/app/views/pages/Login.php -->
<div class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="card shadow p-5" style="min-width: 450px;">
        <div class="card-body">
            <h1 class="card-title text-center mb-4 fw-bold">PayKaryawan</h1>
            <h3 class="card-title text-center mb-4">Login</h3>
            <form id="loginForm" action="/payKaryawan/app/controllers/auth/Auth.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <span class="bi bi-eye" id="toggleIcon"></span>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</div>

<script src="/payKaryawan/public/js/TogglePassword.js"></script>