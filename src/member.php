<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Buku.class.php");
include("includes/Author.class.php");
include("includes/Member.class.php");

$member = new Member($db_host, $db_user, $db_pass, $db_name);
$member->open();

// $status = false;

if (isset($_POST['submit'])) {
    if (isset($_GET['id_edit'])) {
        // memanggil method update
        $member->update($_GET['id_edit']);

        // direct to default link to delete GET data
        header("location:member.php");
        exit;
    } else {
        // check exist nim
        $member->getDetailMember($_POST['nim']);
        if ($member->getResult() != NULL) {
            echo "<script>
                    alert('NIM already exists!');
                </script>";
        } else {
            // memanggil method add
            $member->add();
        }
    }
} else if (isset($_GET['id_edit'])) {
    $nimEdit     = "";
    $nameEdit    = "";
    $jurusanEdit = "";

    $member->getDetailMember($_GET['id_edit']);
    while (list($nim, $name, $jurusan) = $member->getResult()) {
        $nimEdit = $nim;
        $nameEdit = $name;
        $jurusanEdit = $jurusan;
    }
}

if (isset($_GET['id_hapus'])) {
    // memanggil method delete
    $member->delete($_GET['id_hapus']);

    // direct to default link to delete GET data
    header("location:member.php");
    exit;
}

$member->getMember();
$data = null;

while (list($nim, $name, $jurusan) = $member->getResult()) {
    $data .= "<tr>
                <td>" . $nim . "</td>
                <td>" . $name . "</td>
                <td>" . $jurusan . "</td>
                <td>
                    <a href='member.php?id_edit=" . $nim .  "' class='btn btn-warning' '>Edit</a>
                    <a href='member.php?id_hapus=" . $nim . "' class='btn btn-danger' '>Hapus</a>
                    <a href='peminjaman.php?id_peminjam=" . $nim . "' class='btn btn-info' '>Peminjaman</a>
                </td>
            </tr>";
}

$member->close();
$tpl = new Template("templates/member.html");
$tpl->replace("DATA_TABEL", $data);

if (isset($_GET['id_edit'])) {
    $tpl->replace("DATA_TITLE", "Update");
    $tpl->replace("DATA_NIM", "value='" . $nimEdit . "' readonly");
    $tpl->replace("DATA_NAMA", "value='" . $nameEdit . "'");
    $tpl->replace("DATA_JURUSAN", "value='" . $jurusanEdit . "'");
} else {
    $tpl->replace("DATA_TITLE", "Add");
    $tpl->replace("DATA_NIM", "");
    $tpl->replace("DATA_NAMA", "");
    $tpl->replace("DATA_JURUSAN", "");
}

$tpl->write();
