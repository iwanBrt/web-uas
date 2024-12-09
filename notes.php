<?php
// Koneksi database
$conn = mysqli_connect("localhost", "root", "", "uas");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil semua catatan dari database
$query = "SELECT * FROM note ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes</title>
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

.main-content .content-container {
    width: 100%;
    max-width: 800px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

.main-content .title {
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
    text-align: center;
}

.notes-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding: 20px;
    max-width: 800px;
    margin: 0 auto;
}

.note-wrapper {
    display: flex;
    align-items: flex-start;
    gap: 15px;
}

.note-item {
    flex: 1;
    background-color: #ffe8f1;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.note-text {
    font-size: 16px;
    color: #333;
    margin-bottom: 10px;
}

.note-date {
    font-size: 12px;
    color: #666;
    text-align: right;
    margin: 0;
}

.note-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.action-button {
    background: none;
    border: none;
    padding: 8px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.action-button img {
    width: 20px;
    height: 20px;
}

.edit-button {
    background-color: #e6e6e6;
}

.delete-button {
    background-color: #ffcdd2;
}

.edit-button:hover {
    background-color: #d4d4d4;
}

.delete-button:hover {
    background-color: #ffb6b9;
}

.note-item.empty {
    background-color: #fff;
    border: 2px dashed #ccc;
    color: #999;
    font-style: italic;
    text-align: center;
    padding: 40px;
}

@media (max-width: 768px) {
    .note-wrapper {
        flex-direction: column;
    }
    
    .note-actions {
        flex-direction: row;
        justify-content: flex-end;
        padding: 0 10px;
    }
}

/* Tambahkan CSS untuk modal */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    width: 80%;
    max-width: 500px;
}

#editContent {
    width: 100%;
    min-height: 100px;
    margin: 10px 0;
    padding: 10px;
}

    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <img src="Notebook-amico.png" alt="Logo" class="logo-img">
                <h1>MoodWrite</h1>
            </div>
            <p class="description">
                Setiap hari adalah cerita, setiap cerita pantas diabadikan. Simpan momen-momen berhargamu bersama kami, karena kenangan tak pernah lekang oleh waktu.
            </p>
            <button class="toggle-navbar">☰ ini untuk buka tutup navbar</button>
            <nav class="nav">
                <ul>
                    <li class="nav-item">
                        <img src="./img/home.png" alt="Home Icon"><a href="utama.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <img src="./img/plus.png" alt="Add Notes Icon"><a href="addnote.php" class="nav-link">Add Notes</a>
                    </li>
                    <li class="nav-item active">
                        <img src="./img/notes.png" alt="Notes Icon"><a href="notes.php" class="nav-link">Notes</a>
                    </li>
                    <li class="nav-item">
                        <img src="./img/account.png" alt="Profile Icon"><a href="profile.php" class="nav-link">Profile</a>
                    </li>
                    <li class="nav-item">
                        <img src="./img/log-out.png" alt="Logout Icon"><a href="logout.php" class="nav-link">Log Out</a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="content-container">
                <h2 class="title">Kumpulan catatan Ku</h2>
                <div class="notes-container">
                    <?php
                    if ($result->num_rows > 0) {
                        while($note = $result->fetch_assoc()) {
                    ?>
                        <div class="note-wrapper">
                            <div class="note-item">
                                <div class="note-text"><?php echo htmlspecialchars($note['content']); ?></div>
                                <p class="note-date"><?php echo date('d M Y', strtotime($note['created_at'])); ?></p>
                            </div>
                            <div class="note-actions">
                                <button class="action-button edit-button" onclick="editNote(<?php echo $note['id']; ?>, '<?php echo addslashes($note['content']); ?>')">
                                    <img src="./img/pencil.png" alt="Edit Icon">
                                </button>
                                <button class="action-button delete-button" onclick="deleteNote(<?php echo $note['id']; ?>)">
                                    <img src="./img/delete.png" alt="Delete Icon">
                                </button>
                            </div>
                        </div>
                    <?php
                        }
                    } else {
                        echo '<div class="note-item empty">Tidak ada catatan.</div>';
                    }
                    ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Tambahkan modal untuk edit -->
    <div id="editModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h3>Edit Catatan</h3>
            <form id="editForm">
                <input type="hidden" id="noteId">
                <textarea id="editContent"></textarea>
                <button type="submit">Simpan</button>
                <button type="button" onclick="closeModal()">Batal</button>
            </form>
        </div>
    </div>

    <script>
    function editNote(id, content) {
        document.getElementById('editModal').style.display = 'flex';
        document.getElementById('noteId').value = id;
        document.getElementById('editContent').value = content;
    }

    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    function deleteNote(id) {
        if(confirm('Apakah Anda yakin ingin menghapus catatan ini?')) {
            fetch('delete_note.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + id
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    location.reload();
                } else {
                    alert('Gagal menghapus catatan');
                }
            });
        }
    }

    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('noteId').value;
        const content = document.getElementById('editContent').value;

        fetch('update_note.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id + '&content=' + encodeURIComponent(content)
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert('Gagal mengupdate catatan');
            }
        });
    });
    </script>
</body>
</html>