<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Buku.class.php");
include("includes/Author.class.php");
include("includes/Member.class.php");
include("includes/Peminjaman.class.php");

$peminjaman = new Peminjaman($db_host, $db_user, $db_pass, $db_name);
$buku = new Buku($db_host, $db_user, $db_pass, $db_name);
$member = new Member($db_host, $db_user, $db_pass, $db_name);
$peminjaman->open();
$buku->open();
$member->open();

// delete and update status peminjaman
if (isset($_GET['id_hapus'])) {
    $peminjaman->delete($_GET['id_hapus']);
} else if (isset($_GET['id_update']))
    $peminjaman->update($_GET['id_update']);

if (isset($_GET['id_peminjam'])) {
    // take all log peminjaman from id peminjam
    $peminjaman->getDetailPeminjaman($_GET['id_peminjam']);

    // take name of peminjam
    $member->getDetailMember($_GET['id_peminjam']);
    $namaPeminjam = $member->getResult()["nama"];
} else {
    // get all log peminjaman on table peminjaman
    $peminjaman->getPeminjaman();
}

$data = null;
$no = 1;

while (list($id, $id_buku, $status, $id_peminjaman) = $peminjaman->getResult()) {
    $buku->getDetailBuku($id_buku);
    $namaBuku = $buku->getResult()["judul_buku"];

    if ($status == "Belum") {
        $data .= "<tr>
                    <td>" . $no++ . "</td>
                    <td>" . $namaBuku . "</td>
                    <td>" . $status . "</td>
                    <td>
                        <a href='peminjaman.php?";

        // add GET id peminjam for detail tabel peminjam
        if (isset($_GET['id_peminjam']))
            $data .= "id_peminjam=" . $_GET['id_peminjam'] . "&";

        $data .=        "id_update=" . $id . "' class='btn btn-info' '>Update</a>
                    </td>
                </tr>";
    } else {
        $data .= "<tr>
                    <td>" . $no++ . "</td>
                    <td>" . $namaBuku . "</td>
                    <td>" . $status . "</td>
                    <td>
                        <a href='peminjaman.php?";

        // add GET id peminjam for detail tabel peminjam
        if (isset($_GET['id_peminjam']))
            $data .= "id_peminjam=" . $_GET['id_peminjam'] . "&";

        $data .=        "id_hapus=" . $id . "' class='btn btn-danger' '>Hapus</a>
                    </td>
                </tr>";
    }
}

$peminjaman->close();
$buku->close();
$member->close();

$tpl = new Template("templates/peminjaman.html");
$tpl->replace("DATA_TABEL", $data);

if (isset($_GET['id_peminjam'])) {
    $tpl->replace("TITLE", $namaPeminjam);
} else {
    $tpl->replace("TITLE", "Peminjaman");
}

$tpl->write();
