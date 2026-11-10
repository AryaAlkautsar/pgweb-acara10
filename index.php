<?php
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

$sql = "SELECT * FROM pendidikan_kota_bandung";
$result = $conn->query($sql);

$locations = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Metadata -->
    <meta charset="utf-8">
    <title>Web GIS Pendidikan Kota Bandung</title>
    
    <!-- Leaflet CSS Library -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css">
    
    <style>
        /* Layout Utama: Split Screen */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            overflow: hidden; /* Mencegah scroll global */
        }

        .main-container {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        /* Bagian Kiri: Tabel Data (Lebar 42%) */
        .left-panel {
            width: 42%;
            height: 100%;
            display: flex;
            flex-direction: column;
            padding: 15px;
            box-sizing: border-box;
            background: #ffffff;
            border-right: 1px solid #ddd;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            flex-shrink: 0;
        }

        .table-header h3 {
            margin: 0;
            color: #333;
            font-size: 16px;
        }

        /* Area Scroll Khusus untuk Tabel di Panel Kiri */
        .table-container {
            flex-grow: 1;
            overflow-y: auto; /* Scroll hanya aktif di sini */
            border: 1px solid #e0e0e0;
            border-radius: 4px;
        }

        /* Styling Tabel Sederhana */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }

        th, td {
            padding: 8px 10px;
            border-bottom: 1px solid #e0e0e0;
            border-right: 1px solid #f0f0f0;
            text-align: left;
            font-size: 12px;
            color: #333;
        }

        th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
            border-bottom: 2px solid #ccc;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        /* Khusus Header & Kolom Aksi agar ketengah */
        th.th-aksi, td.td-aksi {
            text-align: center;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .btn-input {
            padding: 6px 12px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            font-size: 12px;
            white-space: nowrap;
        }

        .btn-input:hover {
            background: #218838;
        }

        /* Bagian Kanan: Panel Peta (Lebar 58%) */
        .right-panel {
            width: 58%;
            height: 100%;
            display: flex;
            flex-direction: column;
            background: #fff;
        }

        /* Judul di atas Peta */
        .map-title {
            padding: 12px 20px;
            background-color: #ffffff;
            border-bottom: 1px solid #ddd;
            flex-shrink: 0;
        }

        .map-title h2 {
            margin: 0;
            color: #333;
            font-size: 20px;
        }

        #map {
            width: 100%;
            flex-grow: 1; /* Peta mengisi sisa ruang bawah */
        }
    </style>
</head>
<body>

    <div class="main-container">
        <!-- PANEL KIRI: Tabel Data -->
        <div class="left-panel">
            <div class="table-header">
                <h3>Tabel Data Sekolah</h3>
                <a href='input/index.html' class='btn-input'>+ Input Data</a>
            </div>

            <div class="table-container">
                <?php
                if (count($locations) > 0) {
                    echo "<table><tr>
                    <th>NO</th>
                    <th>NAMA</th>
                    <th>NPSN</th>
                    <th>BENTUK PENDIDIKAN</th>
                    <th>STATUS</th>
                    <th>ALAMAT</th>
                    <th>KELURAHAN</th>
                    <th>KECAMATAN</th>
                    <th>LATITUDE</th>
                    <th>LONGITUDE</th>
                    <th class='th-aksi'>Aksi</th></tr>";
                    
                    $no = 1; 
                    foreach($locations as $row) {
                        echo "<tr>
                        <td>".$no."</td>
                        <td>".$row["NAMA"]."</td>
                        <td>".$row["NPSN"]."</td>
                        <td>".$row["BENTUK PENDIDIKAN"]."</td>
                        <td>".$row["STATUS"]."</td>
                        <td>".$row["ALAMAT"]."</td>
                        <td>".$row["KELURAHAN"]."</td>
                        <td>".$row["KECAMATAN"]."</td>
                        <td>".$row["LATITUDE"]."</td>
                        <td>".$row["LONGITUDE"]."</td>
                        <td class='td-aksi' style='white-space: nowrap;'>
                            <a href='edit/index.php?id=".$row["OBJECID"]."'>edit</a> | 
                            <a href='delete.php?id=".$row["OBJECID"]."' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>hapus</a>
                        </td>
                        </tr>";
                        $no++;
                    }
                    echo "</table>";
                } else {
                    echo "<p style='padding: 15px; text-align: center;'>0 results</p>";
                }
                ?>
            </div>
        </div>

        <!-- PANEL KANAN: Peta LeafletJS -->
        <div class="right-panel">
            <div class="map-title">
                <h2>Web GIS & Peta Sebaran Pendidikan Kota Bandung</h2>
            </div>
            <div id="map"></div>
        </div>
    </div>

    <!-- Leaflet JavaScript Library -->
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>
    
    <script>
        /* Initial Map (Pusat Koordinat Kota Bandung) */
        var map = L.map('map').setView([-6.9175, 107.6191], 12); // lat, long, zoom[cite: 3, 4]

        /* Tile Basemap (Esri World Imagery & Google Street) */
        var basemap1 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri'
        });

        var basemap2 = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: 'Map data &copy; Google'
        });

        // Set Default Basemap
        basemap2.addTo(map);

        /* Layer Marker dari Database PHP */
        var markerGroup = L.layerGroup().addTo(map);

        // Ambil data dari PHP menggunakan json_encode
        var dataSekolah = <?php echo json_encode($locations); ?>;

        dataSekolah.forEach(function(item) {
            var lat = parseFloat(item.LATITUDE);
            var lng = parseFloat(item.LONGITUDE);

            if (!isNaN(lat) && !isNaN(lng)) {
                var marker = L.marker([lat, lng])
                    .bindPopup("<b>" + item.NAMA + "</b><br>Alamat: " + item.ALAMAT + "<br>Bentuk: " + item.BENTUK_PENDIDIKAN);
                marker.addTo(markerGroup);
            }
        });

        /* Control Layer */
        var baseMaps = {
            "Google Street": basemap2,
            "Esri Imagery": basemap1
        };

        var overlayMaps = {
            "Titik Sekolah": markerGroup
        };

        L.control.layers(baseMaps, overlayMaps, {collapsed: false}).addTo(map);

        /* Scale Bar */
        L.control.scale({
            maxWidth: 150, 
            position: 'bottomright'
        }).addTo(map);
    </script>
</body>
</html>