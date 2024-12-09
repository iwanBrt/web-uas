<?php
// Informasi database
$host = "localhost";
$dbname = "uas";
$dbuser = "root"; // Ganti dengan username database Anda
$dbpass = ""; // Ganti dengan password database Anda

// Membuat koneksi ke database
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Jika formulir telah dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi bahwa password cocok
    if ($password !== $confirm_password) {
        $error_message = "Password dan konfirmasi password tidak cocok.";
    } else {
        // Mengenkripsi password sebelum menyimpan ke database
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Menyimpan data ke tabel register
        $stmt = $conn->prepare("INSERT INTO register (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashed_password);

        if ($stmt->execute()) {
            $success_message = "Akun berhasil dibuat. Silakan login.";
        } else {
            $error_message = "Terjadi kesalahan: " . $conn->error;
        }

        $stmt->close();
    }
}

// Menutup koneksi database
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <style>
        body {
            background-color: #f8f8f8;
            font-family: sans-serif;
        }

        .container {
            width: 350px;
            margin: 100px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #967bb6;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #7a5e90;
        }

        /* Tambahan style untuk tombol Login */
        .btn-login {
            margin-top: 10px;
            background-color: #4CAF50;
        }

        .btn-login:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Register</h2>

        <!-- Tampilkan pesan error atau sukses jika ada -->
        <?php if (isset($error_message)) : ?>
            <div style="color: red; text-align: center;"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if (isset($success_message)) : ?>
            <div style="color: green; text-align: center;"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <!-- Formulir -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter a password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password"
                    required>
            </div>
            <button type="submit" class="btn">Register</button>
        </form>

        <!-- Tombol Login -->
        <form action="login.php" method="GET">
            <button type="submit" class="btn btn-login">Login</button>
        </form>
    </div>
</body>

</html>
