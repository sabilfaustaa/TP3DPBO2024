<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Penjual.php');
include('classes/Template.php');

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sortColumn = isset($_GET['sortColumn']) ? $_GET['sortColumn'] : 'nama_penjual';
$sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'asc';

$penjual = new Penjual($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$penjual->open();
$penjual->getPenjual($search, $sortColumn, $sortOrder);

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($penjual->addPenjual($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'penjual.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'penjual.php';
            </script>";
        }
    }

    $btn = 'Tambah';
    $title = 'Tambah';
}

$view = new Template('templates/skintabel.html');

$mainTitle = 'Penjual';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Penjual</th>
<th scope="row">Alamat Penjual</th>
<th scope="row">Email</th>
<th scope="row">Telepon</th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'penjual';

while ($row = $penjual->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $row['nama_penjual'] . '</td>
    <td>' . $row['alamat_penjual'] . '</td>
    <td>' . $row['email'] . '</td>
    <td>' . $row['telepon'] . '</td>
    <td style="font-size: 22px;" class="d-flex">
        <a href="form_penjual.php?id=' . $row['id_penjual'] . '" class="btn" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;
        <form method="post" action="">
            <input type="hidden" name="id_hapus" value="'. $row['id_penjual'] .'">
            <button type="submit" class="btn ms-2" name="hapus"><i class="bi bi-trash-fill text-danger"></i></button>
        </form>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($penjual->updatePenjual($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'penjual.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'penjual.php';
            </script>";
            }
        }

        $penjual->getPenjualById($id);
        $row = $penjual->getResult();

        $namaPenjual = $row['nama_penjual'];
        $alamatPenjual = $row['alamat_penjual'];
        $email = $row['email'];
        $telepon = $row['telepon'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_UPDATE', $namaPenjual);
        $view->replace('DATA_VAL_UPDATE_ALAMAT', $alamatPenjual);
        $view->replace('DATA_VAL_UPDATE_EMAIL', $email);
        $view->replace('DATA_VAL_UPDATE_TELEPON', $telepon);
    }
}

if (isset($_POST['hapus'])) {
    $id = $_POST['id_hapus'];
    if ($id > 0) {
        if ($penjual->deletePenjual($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'penjual.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'penjual.php';
            </script>";
        }
    }
}

$penjual->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->replace('DATA_LINK_TAMBAH', "<a href='form_penjual.php' class='btn btn-info mb-3'>Tambah ".$mainTitle."</a>");
$view->replace('DATA_FORM_SEARCH', '
    <form class="d-flex justify-content-between align-items-center mb-3">
        <input class="form-control me-2" type="text" placeholder="Cari Penjual" aria-label="Cari" name="search" value="' . (isset($_GET['search']) ? $_GET['search'] : '') . '" />
        <select class="form-select me-2" name="sortColumn">
            <option value="nama_penjual" ' . (isset($_GET['sortColumn']) && $_GET['sortColumn'] == "nama_penjual" ? "selected" : "") . '>Nama</option>
            <option value="alamat_penjual" ' . (isset($_GET['sortColumn']) && $_GET['sortColumn'] == "alamat_penjual" ? "selected" : "") . '>Alamat</option>
            <option value="email" ' . (isset($_GET['sortColumn']) && $_GET['sortColumn'] == "email" ? "selected" : "") . '>Email</option>
            <option value="telepon" ' . (isset($_GET['sortColumn']) && $_GET['sortColumn'] == "telepon" ? "selected" : "") . '>Telepon</option>
        </select>
        <select class="form-select me-2" name="sortOrder">
            <option value="asc" ' . (isset($_GET['sortOrder']) && $_GET['sortOrder'] == "asc" ? "selected" : "") . '>Ascending</option>
            <option value="desc" ' . (isset($_GET['sortOrder']) && $_GET['sortOrder'] == "desc" ? "selected" : "") . '>Descending</option>
        </select>
        <button class="btn btn-outline-light" type="submit">Cari</button>
    </form>
');
$view->write();

?>
