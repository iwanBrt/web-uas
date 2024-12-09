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
$login_error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Mengambil data dari database
    $stmt = $conn->prepare("SELECT password FROM register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Memeriksa password dengan password hash
        if (password_verify($password, $user['password'])) {
            // Jika berhasil login, simpan ke tabel login
            $insert_stmt = $conn->prepare("INSERT INTO login (email) VALUES (?)");
            $insert_stmt->bind_param("s", $email);
            $insert_stmt->execute();
            $insert_stmt->close();

            // Arahkan ke halaman utama
            header("Location: utama.php");
            exit();
        } else {
            $login_error = "Password yang Anda masukkan salah.";
        }
    } else {
        $login_error = "Email tidak ditemukan.";
    }

    $stmt->close();
}

// Menutup koneksi database
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            background-color: #f8f8f8;
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 350px;
            margin: 100px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .container img {
            display: block;
            margin: 0 auto 15px;
            width: 100px;
            height: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #967bb6;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 10px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #7a5e90;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        .register-container {
            margin-top: 15px;
        }

        .register-container a {
            color: #555;
            text-decoration: none;
            font-size: 14px;
        }

        .register-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="./Notebook-amico.png" alt="Login Icon">
        <h2>Login</h2>

        <!-- Tampilkan pesan error jika ada -->
        <?php if (isset($login_error) && $login_error !== ""): ?>
            <div class="error-message"><?php echo $login_error; ?></div>
        <?php endif; ?>

        <form id="login-form" method="POST" action="login.php">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>

        <div class="register-container">
            <p>Belum memiliki akun? <a href="register.php">Daftar di sini</a></p>
        </div>
    </div>
</body>

</html>
