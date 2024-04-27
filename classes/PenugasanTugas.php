<?php

class PenugasanTugas extends DB
{
    function getPenugasanTugasJoin($search = "")
    {
        $where = "";
        if (!empty($search)) {
            $where = " WHERE Tugas.judul LIKE '%" . $search . "%' OR orang.nama LIKE '%" . $search . "%'";
        }

        $query = "SELECT penugasan_tugas.id_tugas, tugas.judul, orang.nama, orang.foto, penugasan_tugas.tanggal_penugasan FROM penugasan_tugas
                  JOIN Tugas ON penugasan_tugas.id_tugas = Tugas.id_tugas
                  JOIN Orang ON penugasan_tugas.id_orang = orang.id_orang" . $where;

        return $this->execute($query);
    }

    function getPenugasanTugas($search = "", $sortColumn = 'tanggal_penugasan', $sortOrder = 'asc')
    {
        $where = "";
        if (!empty($search)) {
            $where = " WHERE tanggal_penugasan LIKE '%" . $search . "%' OR 
                           id_tugas IN (SELECT id_tugas FROM Tugas WHERE judul LIKE '%" . $search . "%') OR 
                           id_orang IN (SELECT id_orang FROM Orang WHERE nama LIKE '%" . $search . "%')";
        }

        $allowedSortColumns = ['tanggal_penugasan', 'id_tugas', 'id_orang'];
        $sortColumn = in_array($sortColumn, $allowedSortColumns) ? $sortColumn : 'tanggal_penugasan';
        $sortOrder = $sortOrder === 'desc' ? 'DESC' : 'ASC';

        $query = "SELECT * FROM penugasan_tugas" . $where . " ORDER BY " . $sortColumn . " " . $sortOrder;

        return $this->execute($query);
    }

    function getPenugasanTugasById($id)
    {
        $query = "SELECT * FROM penugasan_tugas WHERE id_tugas=$id";
        return $this->execute($query);
    }

    function addPenugasanTugas($data)
    {
        $id_tugas = $data['id_tugas'];
        $id_orang = $data['id_orang'];
        $tanggal_penugasan = $data['tanggal_penugasan'];
        $query = "INSERT INTO penugasan_tugas (id_tugas, id_orang, tanggal_penugasan) VALUES ('$id_tugas', '$id_orang', '$tanggal_penugasan')";
        return $this->executeAffected($query);
    }

    function updatePenugasanTugas($id, $data)
    {
        $id_tugas = $data['id_tugas'];
        $id_orang = $data['id_orang'];
        $tanggal_penugasan = $data['tanggal_penugasan'];
        $query = "UPDATE penugasan_tugas SET id_tugas='$id_tugas', id_orang='$id_orang', tanggal_penugasan='$tanggal_penugasan' WHERE id_tugas=$id";
        return $this->executeAffected($query);
    }

    function deletePenugasanTugas($id)
    {
        $query = "DELETE FROM penugasan_tugas WHERE id_tugas=$id";
        return $this->executeAffected($query);
    }
}
?>
