<?php
header('Content-Type: application/json');
require 'koneksi.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
$nama_tabel = "rsvp"; 

// 1. MENGAMBIL DATA (READ)
if ($action == 'get') {
    $query = "SELECT id, nama_tamu AS nama, pesan, konfirmasi_hadir FROM $nama_tabel ORDER BY id DESC";
    $result = $conn->query($query);
    $data = [];
    while($row = $result->fetch_assoc()) {
        $row['status'] = ($row['konfirmasi_hadir'] == 'Hadir') ? 'hadir' : 'tidak';
        $row['waktu'] = '-'; 
        $data[] = $row;
    }
    echo json_encode($data);
} 

// 2. MENAMBAH DATA (CREATE)
elseif ($action == 'add') {
    $input = json_decode(file_get_contents('php://input'), true);
    $nama = $conn->real_escape_string($input['nama']);
    $pesan = isset($input['pesan']) ? $conn->real_escape_string($input['pesan']) : 'Ditambahkan oleh admin';
    $status_db = 'Hadir'; // Default saat admin menambah manual

    $query = "INSERT INTO $nama_tabel (nama_tamu, pesan, konfirmasi_hadir) VALUES ('$nama', '$pesan', '$status_db')";
    if ($conn->query($query)) {
        echo json_encode(["status" => "success"]);
    }
}

// 3. MENGEDIT DATA (UPDATE)
elseif ($action == 'update') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = (int)$input['id'];
    $nama = $conn->real_escape_string($input['nama']);
    $status_db = ($input['status'] == 'hadir') ? 'Hadir' : 'Tidak Hadir';
    
    $conn->query("UPDATE $nama_tabel SET nama_tamu='$nama', konfirmasi_hadir='$status_db' WHERE id=$id");
    echo json_encode(["status" => "success"]);
}

// 4. MENGHAPUS DATA (DELETE)
elseif ($action == 'delete') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = (int)$input['id'];
    $conn->query("DELETE FROM $nama_tabel WHERE id=$id");
    echo json_encode(["status" => "success"]);
}
?>