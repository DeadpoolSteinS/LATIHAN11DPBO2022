<?php

class Member extends DB
{
    function __construct($db_host = '', $db_user = '', $db_password = '', $db_name = '')
    {
        $this->DB($db_host, $db_user, $db_password, $db_name);
    }

    function getMember()
    {
        $query = "SELECT * FROM member";
        return $this->execute($query);
    }

    function getDetailMember($id)
    {
        $query = "SELECT * FROM member WHERE nim = '$id'";
        return $this->execute($query);
    }

    function add()
    {
        $nim = $_POST['nim'];
        $name = $_POST['name'];
        $jurusan = $_POST['jurusan'];

        $query = "INSERT INTO member VALUES ('$nim', '$name', '$jurusan')";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function update($id)
    {
        $name = $_POST['name'];
        $jurusan = $_POST['jurusan'];

        $query = "UPDATE member SET nama = '$name', jurusan = '$jurusan' WHERE nim = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {

        $query = "DELETE FROM member WHERE nim = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }
}
