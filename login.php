<?php
session_start();

// Data login (bisa diganti dengan query ke database nantinya)
$users = [
  "admin" => ["password" => "admin123", "role" => "admin"],
  "karyawan" => ["password" => "karyawan123", "role" => "karyawan"]
];

// Proses login saat form dikirim
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  if (isset($users[$username]) && $users[$username]['password'] === $password) {
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $users[$username]['role'];

    // Redirect berdasarkan role
    if ($_SESSION['role'] === 'admin') {
      header("Location: home.php");
    } else {
      header("Location: home_karyawan.php");
    }
    exit();
  } else {
    $error = "Username atau password salah!";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Dinas Pertanian</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      min-height: 100vh;
      background: linear-gradient(135deg, rgb(2, 2, 2), #2193b0);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-container {
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 40px 35px;
      width: 100%;
      max-width: 450px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.2);
      text-align: center;
    }

    .logo-container {
      display: flex;
      justify-content: center;
      gap: 1px;
      margin-bottom: 25px;
    }

    .logo-container img {
      height: 60px;
      width: 125px;
      object-fit: contain;
    }

    h2 {
      font-size: 24px;
      font-weight: 700;
      color: #222;
      margin-bottom: 10px;
    }

    p {
      font-size: 14px;
      color: #333;
      margin-bottom: 30px;
      line-height: 1.6;
    }

    form {
      text-align: left;
    }

    label {
      display: block;
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 5px;
      color: #222;
      margin-top: 15px;
    }

    .input-group {
      display: flex;
      align-items: center;
      background: rgba(255, 255, 255, 0.6);
      border-radius: 10px;
      padding: 10px 15px;
      box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
    }

    .input-group i {
      margin-right: 10px;
      color: #666;
    }

    .input-group input {
      border: none;
      background: transparent;
      outline: none;
      width: 100%;
      font-size: 14px;
      color: #333;
    }

    .login-button {
      width: 100%;
      margin-top: 25px;
      padding: 14px;
      background: linear-gradient(to right, #4e54c8, #8f94fb);
      border: none;
      border-radius: 12px;
      font-size: 16px;
      font-weight: 600;
      color: white;
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .login-button:hover {
      transform: scale(1.03);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .error-message {
      color: red;
      font-size: 14px;
      margin-top: 10px;
    }

    @media (max-width: 480px) {
      .login-container {
        padding: 30px 25px;
      }

      .logo-container img {
        height: 50px;
        width: 50px;
      }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="logo-container">
      <img src="Logo_Palembang.png" alt="Logo Kiri" />
      <img src="logo dinas.png" alt="Logo Kanan" />
    </div>
    <h2>SELAMAT DATANG</h2>
    <p>
      Di Website Pengolahan Data Divisi Keuangan<br />
      Pada Dinas Pertanian Tanaman dan Hortikultura<br />
      Provinsi Sumatera Selatan
    </p>

    <form action="login.php" method="POST">
      <label for="username">Username</label>
      <div class="input-group">
        <i class="fas fa-user"></i>
        <input type="text" id="username" name="username" placeholder="Masukkan Username" required />
      </div>

      <label for="password">Password</label>
      <div class="input-group">
        <i class="fas fa-lock"></i>
        <input type="password" id="password" name="password" placeholder="Masukkan Password" required />
      </div>

      <button type="submit" class="login-button">Login</button>
    </form>

    <?php if (!empty($error)) : ?>
      <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
  </div>
</body>
</html>

