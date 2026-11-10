<?php
// Cek apakah parameter id ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Sesuaikan dengan setting MySQL dan database pgw9
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pgw9";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query DELETE dengan nama tabel dan kolom OBJECID yang benar
    $sql = "DELETE FROM pendidikan_kota_bandung WHERE OBJECID = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
} else {
    echo "ID tidak ditemukan!";
}
?>