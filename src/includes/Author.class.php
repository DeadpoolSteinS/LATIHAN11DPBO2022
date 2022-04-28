<?php

class Author extends DB
{
    function __construct($db_host = '', $db_user = '', $db_password = '', $db_name = '')
    {
        $this->DB($db_host, $db_user, $db_password, $db_name);
    }

    function getAuthor()
    {
        $query = "SELECT * FROM author";
        return $this->execute($query);
    }

    function add($data)
    {
        $name = $data['tname'];

        $query = "insert into author values ('', '$name', 'Pendatang Baru')";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {

        $query = "delete FROM author WHERE id_author = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function statusAuthor($id)
    {

        $status = "Senior";
        $query = "update author set status = '$status' where id_author = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }
}
