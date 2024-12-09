<?php
$conn = mysqli_connect("localhost", "root", "", "uas");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if(isset($_POST['id']) && isset($_POST['content'])) {
    $id = $_POST['id'];
    $content = $_POST['content'];
    
    $query = "UPDATE note SET content = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $content, $id);
    
    $response = array();
    if(mysqli_stmt_execute($stmt)) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
    }
    
    echo json_encode($response);
}

mysqli_close($conn);
?>
