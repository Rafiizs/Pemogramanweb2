<?php
session_start();

// Redirect jika sudah login
if(isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit();
}

// Proses login
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Autentikasi sederhana
    if($username === 'admin' && $password === 'password123') {
        $_SESSION['username'] = $username;
        $_SESSION['login_time'] = date('Y-m-d H:i:s');
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Manga Store</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .error {
            color: red;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #ffe6e6;
            border: 1px solid #ffcccc;
            border-radius: 4px;
        }
        .demo-account {
            margin-top: 20px;
            padding: 15px;
            background-color: #e7f3ff;
            border-radius: 4px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <header>
        <h1>Login - Manga Store</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="login-container">
            <h2>Login ke Akun Anda</h2>
            
            <?php if(isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
            </form>
            
            <div class="demo-account">
                <strong>Demo Account:</strong><br>
                Username: admin<br>
                Password: password123
            </div>
        </div>
    </main>
</body>
</html>