<!DOCTYPE html>
<html>
<head>
    <title>Form Edit Data Pendidikan</title>
</head>
<body>
<h2>Form Edit Data Pendidikan</h2>

<?php
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

// Menangkap ID dari URL (menggunakan OBJECID sesuai kolom primary key tabel baru)
$id = $_GET['id'];
$sql = "SELECT * FROM pendidikan_kota_bandung WHERE OBJECID = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<form action='edit.php' onsubmit='return validateForm(event)' method='post'>";
        // Mengirim OBJECTID sebagai identifier data yang diedit
        echo "<input type='hidden' name='objectid' value='" . $row['OBJECID'] . "'><br>";
        
        echo "<label for='nama'>Nama Sekolah: </label><br>";
        echo "<input type='text' id='nama' name='nama' value='" . $row['NAMA'] . "'><br>";
        
        echo "<label for='npsn'>NPSN: </label><br>";
        echo "<input type='text' id='npsn' name='npsn' value='" . $row['NPSN'] . "'><br>";
        
        echo "<label for='bentuk_pendidikan'>Bentuk Pendidikan: </label><br>";
        echo "<input type='text' id='bentuk_pendidikan' name='bentuk_pendidikan' value='" . $row['BENTUK PENDIDIKAN'] . "'><br>";
        
        echo "<label for='status'>Status: </label><br>";
        echo "<input type='text' id='status' name='status' value='" . $row['STATUS'] . "'><br>";

        echo "<label for='alamat'>Alamat: </label><br>";
        echo "<input type='text' id='alamat' name='alamat' value='" . $row['ALAMAT'] . "'><br>";

        echo "<label for='kelurahan'>Kelurahan: </label><br>";
        echo "<input type='text' id='kelurahan' name='kelurahan' value='" . $row['KELURAHAN'] . "'><br>";

        echo "<label for='kecamatan'>Kecamatan: </label><br>";
        echo "<input type='text' id='kecamatan' name='kecamatan' value='" . $row['KECAMATAN'] . "'><br>";

        echo "<label for='latitude'>Latitude: </label><br>";
        echo "<input type='text' id='lat' name='latitude' value='" . $row['LATITUDE'] . "'><br>";
        
        echo "<label for='longitude'>Longitude: </label><br>";
        echo "<input type='text' id='long' name='longitude' value='" . $row['LONGITUDE'] . "'><br><br>";
        
        echo "<input type='submit' value='Submit'>";
        echo "</form>";
    }
} else {
    echo "Data tidak ditemukan!";
}

$conn->close();
?>

<p id="informasi" style="color:red;"></p>

<script>
function validateForm(event) {
    let npsn = document.getElementById("npsn").value;
    let text = "";

    // Contoh validasi sederhana untuk NPSN
    if (npsn.trim() === "" || isNaN(npsn)) {
        text = "NPSN harus diisi dan berupa angka!";
        event.preventDefault(); // Menghentikan pengiriman form
        document.getElementById("informasi").innerHTML = text;
        return false;
    }
    return true;
}
</script>
</body>
</html>