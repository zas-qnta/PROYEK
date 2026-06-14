<?php
include 'setup.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $res = $conn->query("SELECT gambar_files FROM flowers WHERE id = $id");
    if($row = $res->fetch_assoc()) {
        $gambar_raw = isset($row['gambar_files']) ? $row['gambar_files'] : '';
        $images = !empty($gambar_raw) ? json_decode($gambar_raw, true) : [];
        if(!empty($images)) {
            foreach($images as $img) {
                if(file_exists('uploads/'.$img)) unlink('uploads/'.$img);
            }
        }
    }
    $conn->query("DELETE FROM flowers WHERE id = $id");
}

header("Location: index.php");
exit;
?>