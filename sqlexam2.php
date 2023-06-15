<?php
$servername = "localhost";  
$username = "root";    
$password = "";    
$dbname = "khachhang";     

try {
    // Kết nối đến MySQL thông qua PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Tạo bảng "customers" nếu chưa tồn tại
    $sql = "CREATE TABLE IF NOT EXISTS customers (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL,
        phone VARCHAR(15) NOT NULL
    )";
    $conn->exec($sql);
    echo "Bảng 'customers' đã được tạo thành công";
/* Dữ liệu mới để chèn vào bảng
    $name = "John Doe";
    $email = "john.doe@example.com";
    $phone = "123456789";

    // Sử dụng Prepared Statements để chèn dữ liệu vào bảng
    $stmt = $conn->prepare("INSERT INTO customers (name, email, phone) VALUES (:name, :email, :phone)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->execute();

    echo "Dữ liệu đã được thêm thành công vào bảng 'customers'"; */
 }catch(PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
// Đóng kết nối
$conn = null;
?>