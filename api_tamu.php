<?php
header('Content-Type: application/json');
require 'koneksi.php';

$action     = isset($_GET['action']) ? $_GET['action'] : '';
$nama_tabel = "rsvp";

if ($action == 'get') {
    $query  = "SELECT id, nama_tamu AS nama, pesan, konfirmasi_hadir FROM $nama_tabel ORDER BY id DESC";
    $result = $conn->query($query);
    $data   = [];
    while ($row = $result->fetch_assoc()) {
        $row['status'] = ($row['konfirmasi_hadir'] == 'Hadir') ? 'hadir' : 'tidak';
        $row['waktu']  = '-';
        $data[] = $row;
    }
    echo json_encode($data);
}

elseif ($action == 'add_admin') {
    $input = json_decode(file_get_contents('php://input'), true);
    $nama  = trim($input['nama'] ?? '');

    if (empty($nama)) {
        echo json_encode(["status" => "error", "message" => "Nama tidak boleh kosong"]);
        exit;
    }

    $nama = $conn->real_escape_string($nama);

    $query = "INSERT INTO $nama_tabel (nama_tamu, pesan, konfirmasi_hadir) VALUES ('$nama', '', 'Hadir')";

    if ($conn->query($query)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
}

elseif ($action == 'add') {
    $input          = json_decode(file_get_contents('php://input'), true);
    $nama           = trim($input['nama']             ?? '');
    $pesan          = trim($input['pesan']            ?? '');
    $konfirmasi_raw = trim($input['konfirmasi_hadir'] ?? '');

    if (empty($nama)) {
        echo json_encode(["status" => "error", "message" => "Nama tidak boleh kosong"]);
        exit;
    }
    if (empty($pesan)) {
        echo json_encode(["status" => "error", "message" => "Pesan tidak boleh kosong"]);
        exit;
    }

    $nilai_valid = ['Hadir', 'Tidak Hadir'];
    if (!in_array($konfirmasi_raw, $nilai_valid)) {
        echo json_encode(["status" => "error", "message" => "Konfirmasi kehadiran tidak valid"]);
        exit;
    }

    $nama             = $conn->real_escape_string($nama);
    $pesan            = $conn->real_escape_string($pesan);
    $konfirmasi_hadir = $conn->real_escape_string($konfirmasi_raw);

    $cek = $conn->query("SELECT id FROM $nama_tabel WHERE nama_tamu='$nama' LIMIT 1");

    if ($cek && $cek->num_rows > 0) {
        $row = $cek->fetch_assoc();
        $id  = $row['id'];
        $conn->query("UPDATE $nama_tabel SET pesan='$pesan', konfirmasi_hadir='$konfirmasi_hadir' WHERE id=$id");
    } else {
        $conn->query("INSERT INTO $nama_tabel (nama_tamu, pesan, konfirmasi_hadir) VALUES ('$nama', '$pesan', '$konfirmasi_hadir')");
    }

    echo json_encode(["status" => "success"]);
}

elseif ($action == 'update') {
    $input     = json_decode(file_get_contents('php://input'), true);
    $id        = (int)($input['id']     ?? 0);
    $nama      = $conn->real_escape_string(trim($input['nama'] ?? ''));
    $status_db = ($input['status'] == 'hadir') ? 'Hadir' : 'Tidak Hadir';

    if ($id <= 0 || empty($nama)) {
        echo json_encode(["status" => "error", "message" => "Data tidak valid"]);
        exit;
    }

    $conn->query("UPDATE $nama_tabel SET nama_tamu='$nama', konfirmasi_hadir='$status_db' WHERE id=$id");
    echo json_encode(["status" => "success"]);
}

elseif ($action == 'delete') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id    = (int)($input['id'] ?? 0);

    if ($id <= 0) {
        echo json_encode(["status" => "error", "message" => "ID tidak valid"]);
        exit;
    }

    $conn->query("DELETE FROM $nama_tabel WHERE id=$id");
    echo json_encode(["status" => "success"]);
}
?>