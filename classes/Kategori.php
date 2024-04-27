<?php

class Kategori extends DB
{
    function getKategori($search = "", $sortColumn = 'nama_kategori', $sortOrder = 'asc')
    {
        $where = "";
        if (!empty($search)) {
            $where = " WHERE nama_kategori LIKE '%" . $search . "%' OR 
                           deskripsi_kategori LIKE '%" . $search . "%'";
        }

        $allowedSortColumns = ['nama_kategori', 'deskripsi_kategori'];
        $sortColumn = in_array($sortColumn, $allowedSortColumns) ? $sortColumn : 'nama_kategori';
        $sortOrder = $sortOrder === 'desc' ? 'DESC' : 'ASC';

        $query = "SELECT * FROM Kategori" . $where . " ORDER BY " . $sortColumn . " " . $sortOrder;

        return $this->execute($query);
    }

    function getKategoriById($id)
    {
        $query = "SELECT * FROM Kategori WHERE id_kategori=$id";
        return $this->execute($query);
    }

    function addKategori($data)
    {
        $nama_kategori = $data['nama_kategori'];
        $deskripsi_kategori = $data['deskripsi_kategori'];
        $query = "INSERT INTO Kategori (nama_kategori, deskripsi_kategori) VALUES ('$nama_kategori', '$deskripsi_kategori')";
        return $this->executeAffected($query);
    }

    function updateKategori($id, $data)
    {
        $nama_kategori = $data['nama_kategori'];
        $deskripsi_kategori = $data['deskripsi_kategori'];
        $query = "UPDATE Kategori SET nama_kategori='$nama_kategori', deskripsi_kategori='$deskripsi_kategori' WHERE id_kategori=$id";
        return $this->executeAffected($query);
    }

    function deleteKategori($id)
    {
        $query = "DELETE FROM Kategori WHERE id_kategori=$id";
        return $this->executeAffected($query);
    }
}
?>
