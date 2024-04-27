<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Penjual.php');
include('classes/Template.php');

$penjual = new Penjual($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

$penjual->open();

$data = null;

$actionButtons = '';

$id = @$_GET['id'];
if ($id > 0) {
    $penjual->getPenjualById($id);
    $row = $penjual->getResult();
}
$data .= '
    <div class="card-body text-end">
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group row mb-4">
                <label for="nama_penjual" class="col-sm-3 col-form-label">Nama Penjual</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nama_penjual" name="nama_penjual" value="' . @$row['nama_penjual'] . '">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label for="alamat_penjual" class="col-sm-3 col-form-label">Alamat Penjual</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="alamat_penjual" name="alamat_penjual" value="' . @$row['alamat_penjual'] . '">
                </div>
            </div>
            <div class="form-group row mb-4">
                <label for="telepon" class="col-sm-3 col-form-label">Telepon</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="telepon" name="telepon">' . @$row['telepon'] . '</textarea>
                </div>
            </div>
            <div class="form-group row mb-4">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email" value="' . @$row['email'] . '">
                </div>
            </div>
            <div class="form-group row mb-4">
                <div class="col-sm-9 offset-sm-3">
                    <button type="submit" class="btn btn-primary" name="' . ($id ? 'update' : 'tambah') . '">Update</button>
                </div>
            </div>
        </form>
    </div>';

if (isset($_POST['tambah'])) {
    $nama_penjual = $_POST['nama_penjual'];
    $alamat_penjual = $_POST['alamat_penjual'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];

    $penjual->addPenjual([
        'nama_penjual' => $nama_penjual,
        'alamat_penjual' => $alamat_penjual,
        'telepon' => $telepon,
        'email' => $email,
    ]);
    header("Location: penjual.php");
}

if (isset($_POST['update'])) {
    $nama_penjual = $_POST['nama_penjual'];
    $alamat_penjual = $_POST['alamat_penjual'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $id_kategori = $_POST['id_kategori'];

    $penjual->updatePenjual($id, [
        'nama_penjual' => $nama_penjual,
        'alamat_penjual' => $alamat_penjual,
        'telepon' => $telepon,
        'email' => $email,
    ]);
    header("Location: penjual.php");
}

$penjual->close();
$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL', $data);
$detail->write();
?>
