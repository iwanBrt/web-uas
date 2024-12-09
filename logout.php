<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "uas");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if(isset($_POST['confirm_logout'])) {
    // Catat waktu logout ke database
    $user_id = 1; // Ganti dengan ID user yang sedang login
    $query = "INSERT INTO logout (user_id) VALUES (?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);

    // Hapus session dan redirect ke login
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Confirmation</title>
    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 90%;
            max-width: 400px;
            animation: slideIn 0.3s ease;
        }

        .modal-title {
            font-size: 20px;
            color: #333;
            margin-bottom: 15px;
        }

        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .modal-button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .confirm-button {
            background-color: #ff69b4;
            color: white;
        }

        .confirm-button:hover {
            background-color: #ff1493;
        }

        .cancel-button {
            background-color: #f0f0f0;
            color: #333;
        }

        .cancel-button:hover {
            background-color: #ddd;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from {
                transform: translate(-50%, -60%);
                opacity: 0;
            }
            to {
                transform: translate(-50%, -50%);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <!-- Modal Konfirmasi Logout -->
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <h2 class="modal-title">Konfirmasi Logout</h2>
            <p>Apakah Anda yakin ingin keluar?</p>
            <div class="modal-buttons">
                <form method="POST">
                    <button type="submit" name="confirm_logout" class="modal-button confirm-button">Konfirmasi</button>
                    <button type="button" onclick="window.history.back()" class="modal-button cancel-button">Batalkan</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Tampilkan modal saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('logoutModal').style.display = 'block';
        });

        // Tutup modal jika user klik di luar modal
        window.onclick = function(event) {
            if (event.target == document.getElementById('logoutModal')) {
                window.history.back();
            }
        }
    </script>
</body>
</html>
