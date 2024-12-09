<?php
// Koneksi ke database
session_start();
$conn = mysqli_connect("localhost", "root", "", "uas");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data bio dari database
$user_id = 1; // Untuk sementara kita set manual ke user_id 1
$query = "SELECT bio FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <style>
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

        /* Sidebar Styles */
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

        .sidebar .toggle-navbar {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }

        .sidebar .toggle-navbar:hover {
            background-color: #555;
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

        .sidebar .nav ul li a:hover {
            color: #000;
            font-weight: bold;
        }

        .content {
            flex: 1;
            padding: 20px;
        }

        .profile {
            text-align: center;
        }

        .profile img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .profile h2 {
            font-size: 24px;
            color: #333;
        }

        .profile p {
            font-size: 16px;
            color: #666;
        }

        .settings {
            margin-top: 30px;
        }

        .settings label {
            display: block;
            margin: 10px 0 5px;
            color: #333;
            font-weight: bold;
        }

        .settings input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        .settings button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .settings button:hover {
            background-color: #555;
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
        <button class="toggle-navbar">☰ ini untuk buka tutup navbar</button>
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

    <div class="content">
        <div class="profile">
            <img src="profile-picture.jpg" alt="Profile Picture">
            <h2>John William</h2>
            <p><?php echo isset($user['bio']) ? $user['bio'] : ''; ?></p>
        </div>

        <div class="settings">
            <h3>Pengaturan Profil</h3>
            <form action="update_profile.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <label for="bio">Bio</label>
                <input type="text" id="bio" name="bio" value="<?php echo isset($user['bio']) ? $user['bio'] : ''; ?>">
                <button type="submit">Simpan Perubahan</button>
            </form>
        </div>

    </div>
</div>
</body>
</html>
