<?php
echo '<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: cyan;
    }
</style>';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ql_nhansu";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination parameters
$records_per_page = 5; // Number of records per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Current page

$start_from = ($page - 1) * $records_per_page; // Calculate the starting point for the query

$sql = "SELECT * FROM nhanvien LIMIT $start_from, $records_per_page";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    echo "<table><tr><th style='color: red;'>Mã nhân viên</th><th style='color: red;'>Tên nhân viên</th><th style='color: red;'>Phái</th><th style='color: red;'>Nơi Sinh</th><th style='color: red;'>Mã Phòng</th><th style='color: red;'>Lương</th><th style='color: red;'>Hình ảnh</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["MANV"]. "</td><td>" . $row["TENNV"]. "</td><td>" . $row["PHAI"]. "</td><td>" . $row["NOISINH"]. "</td><td>" . $row["MAPHONG"]. "</td><td>" . $row["LUONG"]. "</td>";
        
        // Check gender and insert image accordingly
        if($row["PHAI"] == "Nam") {
            echo "<td><img src='IMG\images.jfif' width='50px' height='50px'></td>";
        } else {
            echo "<td><img src='IMG\ConGai.jpg' width='50px' height='50px'></td>";
        }

        echo "</tr>";
    }
    echo "</table>";

    // Pagination links
    $sql = "SELECT COUNT(*) AS total FROM nhanvien";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $total_pages = ceil($row["total"] / $records_per_page);

    echo "<br><div style='text-align:center'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='?page=$i'>$i</a> ";
    }
    echo "</div>";
} else {
    echo "0 results";
}
$conn->close();
?>
