<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['objectid'];
    $nama = $_POST['nama'];
    $npsn = $_POST['npsn'];
    $bentuk_pendidikan = $_POST['bentuk_pendidikan'];
    $status = $_POST['status'];
    $alamat = $_POST['alamat'];
    $kelurahan = $_POST['kelurahan'];
    $kecamatan = $_POST['kecamatan'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Sesuaikan dengan setting MySQL dan database baru
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

    // Query Update untuk tabel pendidikan_kota_bandung
    $sql = "UPDATE pendidikan_kota_bandung SET 
            NAMA='$nama', 
            NPSN='$npsn', 
            `BENTUK PENDIDIKAN`='$bentuk_pendidikan', 
            STATUS='$status', 
            ALAMAT='$alamat', 
            KELURAHAN='$kelurahan', 
            KECAMATAN='$kecamatan', 
            LATITUDE=$latitude, 
            LONGITUDE=$longitude 
            WHERE OBJECID=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record edited successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    // Redirect kembali ke halaman utama index.php
    header("Location: ../index.php");
    exit();
}
?>