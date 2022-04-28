<?php

class Peminjaman extends DB
{
    function __construct($db_host = '', $db_user = '', $db_password = '', $db_name = '')
    {
        $this->DB($db_host, $db_user, $db_password, $db_name);
    }

    function getPeminjaman()
    {
        $query = "SELECT * FROM peminjaman";
        return $this->execute($query);
    }

    function getDetailPeminjaman($id)
    {
        $query = "SELECT * FROM peminjaman WHERE id_member = '$id'";
        return $this->execute($query);
    }

    function add()
    {
        $nim = $_POST['nim'];
        $name = $_POST['name'];
        $jurusan = $_POST['jurusan'];

        $query = "INSERT INTO peminjaman VALUES ('$nim', '$name', '$jurusan')";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function update($id)
    {
        $query = "UPDATE peminjaman SET status='Sudah' WHERE id = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {

        $query = "DELETE FROM peminjaman WHERE id = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }
}
