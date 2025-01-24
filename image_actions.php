<?php
include 'db.php';

$action = $_POST['action'] ?? null;

if ($action === 'add') {
    // Menambah data
    $name = $_POST['name'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = "uploads/";
        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            $stmt = $db->prepare("INSERT INTO images (name, file_name) VALUES (:name, :file_name)");
            $stmt->execute([':name' => $name, ':file_name' => $fileName]);

            echo json_encode(['status' => 'success', 'message' => 'Image added successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload image']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No image uploaded']);
    }
} elseif ($action === 'edit') {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $updateFile = false;
    $fileName = '';


    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = "uploads/";
        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            $updateFile = true;
        }
    }


    if ($updateFile) {
        // Ambil nama file gambar lama
        $stmt = $db->prepare("SELECT file_name FROM images WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && file_exists("uploads/" . $row['file_name'])) {
            unlink("uploads/" . $row['file_name']); // Hapus gambar lama
        }


        $stmt = $db->prepare("UPDATE images SET name = :name, file_name = :file_name WHERE id = :id");
        $stmt->execute([':name' => $name, ':file_name' => $fileName, ':id' => $id]);
    } else {
        // Hanya update nama jika tidak ada gambar baru
        $stmt = $db->prepare("UPDATE images SET name = :name WHERE id = :id");
        $stmt->execute([':name' => $name, ':id' => $id]);
    }

    echo json_encode(['status' => 'success', 'message' => 'Berhasil Update']);
} elseif ($action === 'delete') {
    // Menghapus data
    $id = $_POST['id'];

    $stmt = $db->prepare("SELECT file_name FROM images WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && file_exists("uploads/" . $row['file_name'])) {
        unlink("uploads/" . $row['file_name']); // Hapus gambar
    }

    $stmt = $db->prepare("DELETE FROM images WHERE id = :id");
    $stmt->execute([':id' => $id]);

    echo json_encode(['status' => 'success', 'message' => 'Berhasil Hapus']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal']);
}
