<?php

include('config/db.php');
include('classes/DB.php');
include('classes/PenugasanTugas.php');
include('classes/Orang.php');
include('classes/Tugas.php');
include('classes/Template.php');

$penugasan = new PenugasanTugas($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$orang = new Orang($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$tugas = new Tugas($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

$penugasan->open();
$orang->open();
$tugas->open();

// Ambil data untuk dropdown
$orang->getOrang();
$tugas->getTugas();

// Membuat dropdown options untuk Orang
$optionsOrang = "";
while ($row = $orang->getResult()) {
    $optionsOrang .= '<option value="' . $row['id_orang'] . '">' . $row['nama'] . '</option>';
}

// Membuat dropdown options untuk Tugas
$optionsTugas = "";
while ($row = $tugas->getResult()) {
    $optionsTugas .= '<option value="' . $row['id_tugas'] . '">' . $row['judul'] . '</option>';
}

$id_penugasan = @$_GET['id_penugasan'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_orang = $_POST['id_orang'];
    $id_tugas = $_POST['id_tugas'];
    $tanggal_penugasan = $_POST['tanggal_penugasan'];

    if ($id_penugasan > 0) {
        $penugasan->updatePenugasanTugas($id_penugasan, [
            'id_orang' => $id_orang,
            'id_tugas' => $id_tugas,
            'tanggal_penugasan' => $tanggal_penugasan
        ]);
    } else {
        $penugasan->addPenugasanTugas([
            'id_orang' => $id_orang,
            'id_tugas' => $id_tugas,
            'tanggal_penugasan' => $tanggal_penugasan
        ]);
    }

    header("Location: index.php");
}

$penugasan->close();
$orang->close();
$tugas->close();

$id_penugasan = @$_GET['id_penugasan'];
$action = $id_penugasan > 0 ? 'Update' : 'Tambah';
$data = '
<form method="post" action="">
    <div class="form-group mb-3">
        <label for="id_orang">Orang:</label>
        <select class="form-control" id="id_orang" name="id_orang">' . $optionsOrang . '</select>
    </div>
    <div class="form-group mb-3">
        <label for="id_tugas">Tugas:</label>
        <select class="form-control" id="id_tugas" name="id_tugas">' . $optionsTugas . '</select>
    </div>
    <div class="form-group mb-3">
        <label for="tanggal_penugasan">Tanggal Penugasan:</label>
        <input type="date" class="form-control" id="tanggal_penugasan" name="tanggal_penugasan">
    </div>
    <button type="submit" class="btn btn-primary">' . $action . '</button>
</form>';

$detail = new Template('templates/skinform.html');
$detail->replace('DATA_FORM', $data);
$detail->write();
?>
