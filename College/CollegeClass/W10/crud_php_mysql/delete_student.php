<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit(); // Pastikan untuk menghentikan eksekusi script setelah mengarahkan pengguna
}

if (!isset($_GET["nim"])) {
    header("Location: student_view.php");
    exit(); // Pastikan untuk menghentikan eksekusi script setelah mengarahkan pengguna
}

include("connection.php");

$nim_to_delete = $_GET["nim"];

$query = "DELETE FROM student WHERE nim='$nim_to_delete'";
$result = mysqli_query($connection, $query);

if ($result) {
    $message = "Data mahasiswa dengan NIM <b>$nim_to_delete</b> berhasil dihapus";
    $message = urlencode($message);
    header("Location: student_view.php?message={$message}");
    exit(); // Pastikan untuk menghentikan eksekusi script setelah mengarahkan pengguna
} else {
    die("Query gagal dijalankan: ".mysqli_errno($connection). " - ".mysqli_error($connection));
}

mysqli_close($connection);
?>
