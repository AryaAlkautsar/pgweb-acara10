<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Edit Data Pendidikan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .form-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
        }
        h2 {
            margin-top: 0;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #555;
            font-size: 14px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        input[type="text"]:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }
        input[type="submit"] {
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        #informasi {
            margin-top: 10px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="form-container">
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
            echo "<form action='../edit.php' onsubmit='return validateForm(event)' method='post'>";
            // Mengirim OBJECTID sebagai identifier data yang diedit
            echo "<input type='hidden' name='objectid' value='" . $row['OBJECID'] . "'>";
            
            echo "<label for='nama'>Nama Sekolah: </label>";
            echo "<input type='text' id='nama' name='nama' value='" . $row['NAMA'] . "'>";
            
            echo "<label for='npsn'>NPSN: </label>";
            echo "<input type='text' id='npsn' name='npsn' value='" . $row['NPSN'] . "'>";
            
            echo "<label for='bentuk_pendidikan'>Bentuk Pendidikan: </label>";
            echo "<input type='text' id='bentuk_pendidikan' name='bentuk_pendidikan' value='" . $row['BENTUK PENDIDIKAN'] . "'>";
            
            echo "<label for='status'>Status: </label>";
            echo "<input type='text' id='status' name='status' value='" . $row['STATUS'] . "'>";

            echo "<label for='alamat'>Alamat: </label>";
            echo "<input type='text' id='alamat' name='alamat' value='" . $row['ALAMAT'] . "'>";

            echo "<label for='kelurahan'>Kelurahan: </label>";
            echo "<input type='text' id='kelurahan' name='kelurahan' value='" . $row['KELURAHAN'] . "'>";

            echo "<label for='kecamatan'>Kecamatan: </label>";
            echo "<input type='text' id='kecamatan' name='kecamatan' value='" . $row['KECAMATAN'] . "'>";

            echo "<label for='latitude'>Latitude: </label>";
            echo "<input type='text' id='lat' name='latitude' value='" . $row['LATITUDE'] . "'>";
            
            echo "<label for='longitude'>Longitude: </label>";
            echo "<input type='text' id='long' name='longitude' value='" . $row['LONGITUDE'] . "'><br>";
            
            echo "<input type='submit' value='Simpan Perubahan'>";
            echo "</form>";
        }
    } else {
        echo "Data tidak ditemukan!";
    }

    $conn->close();
    ?>

    <p id="informasi" style="color:red;"></p>
</div>

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