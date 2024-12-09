<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "uas");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    
    $query = "INSERT INTO note (content) VALUES (?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $content);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Catatan berhasil disimpan!";
        $_SESSION['message_type'] = "success";
        header("Location: notes.php"); // Redirect ke halaman notes
    } else {
        $_SESSION['message'] = "Gagal menyimpan catatan!";
        $_SESSION['message_type'] = "error";
        header("Location: addnote.php"); // Kembali ke form dengan pesan error
    }
} else {
    header("Location: addnote.php");
}

mysqli_close($conn);
?>