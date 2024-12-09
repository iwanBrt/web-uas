<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "uas");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $bio = $_POST['bio'];
    
    // Update bio ke database
    $query = "UPDATE users SET bio = '$bio' WHERE id = $user_id";
    
    if (mysqli_query($conn, $query)) {
        // Jika berhasil, kembali ke halaman profile
        header("Location: profile.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
