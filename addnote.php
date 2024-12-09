<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "uas");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Note - MoodWrite</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        /* Sidebar Styles - sama dengan halaman lain */
        .sidebar {
            width: 300px;
            background-color: #ffe8f1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar .logo img {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }

        .sidebar .logo h1 {
            font-size: 24px;
            color: #333;
            margin: 0;
        }

        .sidebar .description {
            font-size: 14px;
            color: #666;
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar .nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            width: 100%;
        }

        .sidebar .nav ul li {
            display: flex;
            align-items: center;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar .nav ul li img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        .sidebar .nav ul li a {
            text-decoration: none;
            color: #666;
            font-size: 16px;
            flex: 1;
        }

        .sidebar .nav ul li:hover {
            background-color: #ddd;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            padding: 20px;
        }

        .note-form {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-title {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group textarea {
            width: 100%;
            min-height: 200px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            resize: vertical;
            font-size: 16px;
        }

        .form-group button {
            width: 100%;
            padding: 12px;
            background-color: #555;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-group button:hover {
            background-color: #ff1493;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <img src="Notebook-amico.png" alt="Logo">
                <h1>MoodWrite</h1>
            </div>
            <p class="description">
                Setiap hari adalah cerita, setiap cerita pantas diabadikan. Simpan momen-momen berhargamu bersama kami, karena kenangan tak pernah lekang oleh waktu.
            </p>
            <nav class="nav">
                <ul>
                    <li><img src="./img/home.png" alt="Home Icon"><a href="utama.php">Home</a></li>
                    <li><img src="./img/plus.png" alt="Add Notes Icon"><a href="addnote.php">Add Notes</a></li>
                    <li><img src="./img/notes.png" alt="Notes Icon"><a href="notes.php">Notes</a></li>
                    <li><img src="./img/account.png" alt="Profile Icon"><a href="profile.php">Profile</a></li>
                    <li><img src="./img/log-out.png" alt="Logout Icon"><a href="logout.php">Log Out</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="note-form">
                <h2 class="form-title">Tambah Catatan Baru</h2>
                
                <?php
                if (isset($_SESSION['message'])) {
                    $class = ($_SESSION['message_type'] == 'success') ? 'alert-success' : 'alert-error';
                    echo "<div class='alert {$class}'>{$_SESSION['message']}</div>";
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                }
                ?>

                <form action="save_note.php" method="POST">
                    <div class="form-group">
                        <label for="content">Isi Catatan:</label>
                        <textarea 
                            id="content" 
                            name="content" 
                            placeholder="Tulis catatan Anda di sini..."
                            required
                        ></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit">Simpan Catatan</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>