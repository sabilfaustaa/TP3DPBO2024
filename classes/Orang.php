<?php

class Orang extends DB
{
    function uploadFoto($file) {
        $targetDir = "assets/images/";
        $targetFile = $targetDir . basename($file["foto"]['name']);

        if (move_uploaded_file($file["foto"]["tmp_name"], $targetFile)) {
            return basename($file["foto"]['name']);
        } else {
            return "";
        }
    }

    function getOrang($search = "", $sortColumn = 'nama', $sortOrder = 'asc')
    {
        $where = "";
        if (!empty($search)) {
            $where = " WHERE nama LIKE '%" . $search . "%' OR
                           alamat LIKE '%" . $search . "%' OR
                           nomor_telepon LIKE '%" . $search . "%' OR
                           email LIKE '%" . $search . "%'";
        }

        $allowedSortColumns = ['nama', 'alamat', 'nomor_telepon', 'email'];
        $sortColumn = in_array($sortColumn, $allowedSortColumns) ? $sortColumn : 'nama';
        $sortOrder = $sortOrder === 'desc' ? 'DESC' : 'ASC';

        $query = "SELECT * FROM Orang" . $where . " ORDER BY " . $sortColumn . " " . $sortOrder;
        return $this->execute($query);
    }

    function getOrangById($id)
    {
        $query = "SELECT * FROM Orang WHERE id_orang=$id";
        return $this->execute($query);
    }

    function addOrang($data)
    {
        $nama = $data['nama'];
        $alamat = $data['alamat'];
        $nomor_telepon = $data['nomor_telepon'];
        $email = $data['email'];
        
        if (!empty($data["foto"]['name'])) {
            $foto = $this->uploadFoto($data);
            $query = "INSERT INTO Orang (nama, alamat, nomor_telepon, email, foto) VALUES ('$nama', '$alamat', '$nomor_telepon', '$email', '$foto')";
        } else {
            $query = "INSERT INTO Orang (nama, alamat, nomor_telepon, email) VALUES ('$nama', '$alamat', '$nomor_telepon', '$email')";
        }
        return $this->executeAffected($query);
    }

    function updateOrang($id, $data)
    {
        $nama = $data['nama'];
        $alamat = $data['alamat'];
        $nomor_telepon = $data['nomor_telepon'];
        $email = $data['email'];

        if (!empty($data["foto"]['name'])) {
            $foto = $this->uploadFoto($data);
            $query = "UPDATE Orang SET nama='$nama', alamat='$alamat', nomor_telepon='$nomor_telepon', email='$email', foto='$foto' WHERE id_orang=$id";
        } else {
            $query = "UPDATE Orang SET nama='$nama', alamat='$alamat', nomor_telepon='$nomor_telepon', email='$email' WHERE id_orang=$id";
        }

        return $this->executeAffected($query);
    }

    function deleteOrang($id)
    {
        $query = "DELETE FROM Orang WHERE id_orang=$id";
        return $this->executeAffected($query);
    }
}
?>
