<?php
// Informasi database
$host = "localhost";
$dbname = "uas";
$dbuser = "root";
$dbpass = "";

// Koneksi database
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

// Periksa koneksi database
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Ambil catatan terbaru dari database
$query = "SELECT * FROM note ORDER BY created_at DESC LIMIT 3"; // Mengambil 3 catatan terbaru
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoodWrite</title>
    <link rel="stylesheet" href="styles/style.css">
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

/* Main Content Styles */
.main-content {
    flex: 1;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
}

.main-content h2 {
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}

.notes {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    padding: 20px;
}

.note-card {
    width: 250px;
    padding: 20px;
    background-color: #ffe8f1;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    transition: transform 0.3s ease;
}

.note-card:hover {
    transform: translateY(-5px);
}

.note-content {
    font-size: 16px;
    color: #333;
    margin-bottom: 10px;
    /* Batasi teks yang terlalu panjang */
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.note-date {
    font-size: 12px;
    color: #666;
    text-align: right;
    margin: 0;
}

.note-card.empty {
    background-color: #fff;
    border: 2px dashed #ccc;
    color: #999;
    font-style: italic;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 150px;
}

@media (max-width: 768px) {
    .note-card {
        width: 100%;
        max-width: 300px;
    }
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
                    <li><img src="./img/plus.png" alt="Add Notes Icon"><a href="addnote.php">Add Notes</a></li>
                    <li><img src="./img/notes.png" alt="Notes Icon"><a href="notes.php">Notes</a></li>
                    <li><img src="./img/account.png" alt="Profile Icon"><a href="profile.php">Profile</a></li>
                    <li><img src="./img/log-out.png" alt="Logout Icon"><a href="logout.php">Log Out</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <h2>Catatan Terbaru</h2>
            <div class="notes">
                <?php
                if ($result->num_rows > 0) {
                    while($note = $result->fetch_assoc()) {
                        ?>
                        <div class="note-card">
                            <p class="note-content"><?php echo htmlspecialchars($note['content']); ?></p>
                            <p class="note-date"><?php echo date('d M Y', strtotime($note['created_at'])); ?></p>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="note-card empty">Tidak ada catatan.</div>
                    <?php
                }
                ?>
            </div>
        </main>
    </div>
</body>
</html>
