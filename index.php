<?php

include('config/db.php');
include('classes/DB.php');
include('classes/PenugasanTugas.php');
include('classes/Template.php');

$search = $_GET['search'] ?? '';

// buat instance PenugasanTugas
$penugasan = new PenugasanTugas($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// buka koneksi
$penugasan->open();

// tampilkan data penugasan
$penugasan->getPenugasanTugasJoin($search);

$data = null;

// gabungkan dengan tag HTML
while ($row = $penugasan->getResult()) {
    $data .= '<div class="card mb-3">
                <img src="assets/images/' . $row['foto'] . '" class="card-img-top" alt="' . $row['nama'] . '">
                <div class="card-body">
                    <h5 class="card-title">' . $row['judul'] . '</h5>
                    <p class="card-text">' . $row['nama'] . '</p>
                    <p class="card-text"><small class="text-muted">' . $row['tanggal_penugasan'] . '</small></p>
                </div>
              </div>';
}

// tutup koneksi
$penugasan->close();

// buat instance template
$home = new Template('templates/skin.html');

// simpan data ke template
$home->replace('DATA_PENUGASAN', $data);
$home->write();
