<?php

include('config/db.php');
include('classes/DB.php');
include('classes/KategoriProduk.php');
include('classes/Template.php');

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'asc';

$kategoriProduk = new KategoriProduk($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$kategoriProduk->open();
$result = $kategoriProduk->getKategoriProduk($search, $sort);

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($kategoriProduk->addKategoriProduk($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'kategori_produk.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'kategori_produk.php';
            </script>";
        }
    }

    $btn = 'Tambah';
    $title = 'Tambah';
}

$view = new Template('templates/skintabel.html');

$mainTitle = 'Kategori Produk';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Kategori</th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'kategori_produk';

while ($row = $kategoriProduk->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $row['nama_kategori'] . '</td>
    <td style="font-size: 22px;" class="d-flex">
        <a href="form_kategori_produk.php?id=' . $row['id_kategori'] . '" class="btn" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;
        <form method="post" action="">
            <input type="hidden" name="id_hapus" value="'. $row['id_kategori'] .'">
            <button type="submit" class="btn ms-2" name="hapus"><i class="bi bi-trash-fill text-danger"></i></button>
        </form>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id'])) {
    $id = @$_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($kategoriProduk->updateKategoriProduk($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'kategori_produk.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'kategori_produk.php';
            </script>";
            }
        }

        $kategoriProduk->getKategoriProdukById($id);
        $row = $kategoriProduk->getResult();

        $namaKategori = $row['nama_kategori'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_UPDATE', $namaKategori);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($kategoriProduk->deleteKategoriProduk($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'kategori_produk.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'kategori_produk.php';
            </script>";
        }
    }
}

$kategoriProduk->close();

if (isset($_POST['hapus'])) {
    $id = $_POST['id_hapus'];
    if ($id > 0) {
        if ($kategoriProduk->deleteKategoriProduk($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'kategori_produk.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'kategori_produk.php';
            </script>";
        }
    }
}

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->replace('DATA_LINK_TAMBAH', "<a href='form_kategori_produk.php' class='btn btn-info mb-3'>Tambah ".$mainTitle."</a>");
$view->replace('DATA_FORM_SEARCH', '
    <form class="d-flex justify-content-between align-items-center mb-3">
        <input class="form-control me-2" type="text" placeholder="Cari Nama Kategori" aria-label="Cari" name="search" value="' . (isset($_GET['search']) ? $_GET['search'] : '') . '" />
        <select class="form-select me-2" name="sort">
            <option value="asc" ' . (isset($_GET['sort']) && $_GET['sort'] == "asc" ? "selected" : "") . '>Nama Ascending</option>
            <option value="desc" ' . (isset($_GET['sort']) && $_GET['sort'] == "desc" ? "selected" : "") . '>Nama Descending</option>
        </select>
        <button class="btn btn-outline-light" type="submit">Cari</button>
    </form>
');
$view->write();

?>
