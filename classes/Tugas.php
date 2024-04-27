<?php

class Tugas extends DB
{
    function getTugas($search = "", $sortColumn = 'judul', $sortOrder = 'asc')
    {
        $where = "";
        if (!empty($search)) {
            $where = " WHERE judul LIKE '%" . $search . "%' OR 
                           deskripsi LIKE '%" . $search . "%' OR 
                           tanggal_berakhir LIKE '%" . $search . "%' OR 
                           status LIKE '%" . $search . "%'";
        }

        $allowedSortColumns = ['judul', 'tanggal_berakhir', 'status'];
        $sortColumn = in_array($sortColumn, $allowedSortColumns) ? $sortColumn : 'judul';
        $sortOrder = $sortOrder === 'desc' ? 'DESC' : 'ASC';

        $query = "SELECT * FROM Tugas" . $where . " ORDER BY " . $sortColumn . " " . $sortOrder;

        return $this->execute($query);
    }

    function getTugasById($id)
    {
        $query = "SELECT * FROM Tugas WHERE id_tugas=$id";
        return $this->execute($query);
    }

    function addTugas($data)
    {
        $judul = $data['judul'];
        $deskripsi = $data['deskripsi'];
        $tanggal_berakhir = $data['tanggal_berakhir'];
        $status = $data['status'];
        $query = "INSERT INTO Tugas (judul, deskripsi, tanggal_berakhir, status) VALUES ('$judul', '$deskripsi', '$tanggal_berakhir', '$status')";
        return $this->executeAffected($query);
    }

    function updateTugas($id, $data)
    {
        $judul = $data['judul'];
        $deskripsi = $data['deskripsi'];
        $tanggal_berakhir = $data['tanggal_berakhir'];
        $status = $data['status'];
        $query = "UPDATE Tugas SET judul='$judul', deskripsi='$deskripsi', tanggal_berakhir='$tanggal_berakhir', status='$status' WHERE id_tugas=$id";
        return $this->executeAffected($query);
    }

    function deleteTugas($id)
    {
        $query = "DELETE FROM Tugas WHERE id_tugas=$id";
        return $this->executeAffected($query);
    }
}
?>
