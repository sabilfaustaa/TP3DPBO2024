<?php

include('config/db.php');
include('classes/DB.php');
include('classes/KategoriProduk.php');
include('classes/Template.php');

$kategoriProduk = new KategoriProduk($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

$kategoriProduk->open();

$data = null;

$actionButtons = '';

$id = @$_GET['id'];
if ($id > 0) {
    $kategoriProduk->getKategoriProdukById($id);
    $row = $kategoriProduk->getResult();
}
$data .= '
    <div class="card-body text-end">
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group row mb-4">
                <label for="nama_kategori" class="col-sm-3 col-form-label">Nama Kategori</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="' . @$row['nama_kategori'] . '">
                </div>
            </div>
            <div class="form-group row mb-4">
                <div class="col-sm-9 offset-sm-3">
                    <button type="submit" class="btn btn-primary" name="' . ($id ? 'update' : 'tambah') . '">' . ($id ? 'Update' : 'Tambah') . '</button>
                </div>
            </div>
        </form>
    </div>';

if (isset($_POST['tambah'])) {
    $nama_kategori = $_POST['nama_kategori'];

    $kategoriProduk->addKategoriProduk([
        'nama_kategori' => $nama_kategori,
    ]);
    header("Location: kategori_produk.php");
}

if (isset($_POST['update'])) {
    $nama_kategori = $_POST['nama_kategori'];

    $kategoriProduk->updateKategoriProduk($id, [
        'nama_kategori' => $nama_kategori,
    ]);
    header("Location: kategori_produk.php");
}

$kategoriProduk->close();
$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL', $data);
$detail->write();
?>
