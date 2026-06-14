<?php
include 'setup.php';
$error = '';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin'] = 'Zaskia Qanita Najiyah'; // Sesuai identitas [cite: 1]
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Petal Registry - Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f6f6f6; display: flex; align-items: center; justify-content: center; height: 100vh; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .login-card { width: 100%; max-width: 420px; padding: 40px 30px; border-radius: 20px; background: #fff; box-shadow: 0 10px 30px rgb(255, 255, 255); border: 1px solid #eaeaea; }
        .btn-magenta { background-color: #e91e63; color: white; border-radius: 8px; padding: 10px; font-weight: 500; }
        .btn-magenta:hover { background-color: #d81b60; color: white; }
        .form-control { border-radius: 8px; padding: 10px; background-color: #f9f9f9; border: 1px solid #e2e2e2; }
    </style>
</head>
<body>
<div class="login-card text-center">
    <div class="mb-2 text-start d-flex align-items-center gap-2">
       <span style="font-size:24px;">🌸</span>
       <div>
          <h4 class="m-0 fw-bold text-dark" style="letter-spacing: -0,10px;">Petal Registry</h4>
          <p class="m-0 text-muted small" style="font-size: 13px;">Florist Admin System</p>
       </div>
    </div>
    <p class="text-start text-muted my-3" style="font-size: 13px;">Silakan login untuk mengelola data bunga</p>
    <?php if($error): ?>
        <div class="alert alert-danger py-2 small"><?= $error; ?></div>
    <?php endif; ?>
    <form action="" method="POST">
        <div class="mb-3 text-start">
            <label class="form-label small fw-semibold text-secondary">Username</label>
            <input type="text" name="username" class="form-control" value="admin" required>
        </div>
        <div class="mb-4 text-start">
            <label class="form-label small fw-semibold text-secondary">Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <button type="submit" name="login" class="btn btn-magenta w-100">Masuk</button>
    </form>
</div>
</body>
</html>