<?php
// Menangkap data dari form input (pastikan nama input di HTML/form sesuai)
$nama = $_POST['nama'];
$npsn = $_POST['npsn'];
$bentuk_pendidikan = $_POST['bentuk_pendidikan'];
$status = $_POST['status'];
$alamat = $_POST['alamat'];
$kelurahan = $_POST['kelurahan'];
$kecamatan = $_POST['kecamatan'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

// Sesuaikan dengan setting MySQL
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

// Query INSERT 
$sql = "INSERT INTO pendidikan_kota_bandung (nama, npsn, `BENTUK PENDIDIKAN`, status, alamat, kelurahan, kecamatan, latitude, longitude)
        VALUES ('$nama', '$npsn', '$bentuk_pendidikan', '$status', '$alamat', '$kelurahan', '$kecamatan', $latitude, $longitude)";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Redirect kembali ke halaman utama index.php
header("Location: ../index.php");
exit();
?>