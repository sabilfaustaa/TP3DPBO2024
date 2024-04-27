<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Produk.php');
include('classes/Template.php');

$produk = new Produk($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$produk->open();

$data = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $produk->getProdukById($id);
        $row = $produk->getResult();

        $data .= '<div class="card-header text-center">
        <h3 class="my-0">Detail ' . $row['nama_produk'] . '</h3>
        </div>
        <div class="card-body text-end">
            <div class="row mb-5">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <img src="assets/images/' . $row['gambar_produk'] . '" class="img-thumbnail" alt="' . $row['gambar_produk'] . '" width="60">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card px-3">
                            <table border="0" class="text-start">
                                <tr>
                                    <td>Nama Produk</td>
                                    <td>:</td>
                                    <td>' . $row['nama_produk'] . '</td>
                                </tr>
                                <tr>
                                    <td>Harga</td>
                                    <td>:</td>
                                    <td>' . $row['harga'] . '</td>
                                </tr>
                                <tr>
                                    <td>Deskripsi</td>
                                    <td>:</td>
                                    <td>' . $row['deskripsi'] . '</td>
                                </tr>
                                <tr>
                                    <td>ID Penjual</td>
                                    <td>:</td>
                                    <td>' . $row['id_penjual'] . '</td>
                                </tr>
                                <tr>
                                    <td>ID Kategori</td>
                                    <td>:</td>
                                    <td>' . $row['id_kategori'] . '</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end d-flex justify-content-end">
                <a href="form_penugasan.php?id='. $row['id_produk'] .'"><button type="button" class="btn btn-success text-white">Ubah Data</button></a>
                <form method="post" action="">
                    <button type="submit" class="btn btn-danger ms-2" name="delete">Hapus Data</button>
                </form>
            </div>';
    }
}

if (isset($_POST['delete'])) {
    $produk->deleteProduk($id);
    header("Location: index.php");
}


$produk->close();
$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL', $data);
$detail->write();
?>
