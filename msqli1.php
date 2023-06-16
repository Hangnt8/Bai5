<?php
// Thực hiện kết nối tới cơ sở dữ liệu
$servername = "localhost"; // Tên máy chủ MySQL
$username = "your_username"; // Tên người dùng MySQL
$password = "your_password"; // Mật khẩu người dùng MySQL
$dbname = "khachhang"; // Tên cơ sở dữ liệu

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối tới cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

// Tạo bảng "customers"
$sql = "CREATE TABLE customers (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    phone VARCHAR(15) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Bảng 'customers' đã được tạo thành công.<br>";
} else {
    echo "Lỗi khi tạo bảng 'customers': " . $conn->error;
}

// Thêm 5 khách hàng mới vào bảng "customers"
$sql = "INSERT INTO customers (name, email, phone)
        VALUES
        ('Khách hàng 1', 'customer1@example.com', '1234567890'),
        ('Khách hàng 2', 'customer2@example.com', '9876543210'),
        ('Khách hàng 3', 'customer3@example.com', '5555555555'),
        ('Khách hàng 4', 'customer4@example.com', '1111111111'),
        ('Khách hàng 5', 'customer5@example.com', '9999999999')";

if ($conn->query($sql) === TRUE) {
    echo "Thêm khách hàng mới thành công.<br>";
} else {
    echo "Lỗi khi thêm khách hàng mới: " . $conn->error;
}

// Sửa thông tin của một khách hàng có id là 1
$sql = "UPDATE customers SET name = 'Khách hàng 1 (sửa)', email = 'newemail@example.com' WHERE id = 1";

if ($conn->query($sql) === TRUE) {
    echo "Thông tin khách hàng đã được cập nhật.<br>";
} else {
    echo "Lỗi khi cập nhật thông tin khách hàng: " . $conn->error;
}

// Xoá một khách hàng có id là 5
$sql = "DELETE FROM customers WHERE id = 5";

if ($conn->query($sql) === TRUE) {
    echo "Khách hàng đã được xoá khỏi bảng.<br>";
} else {
    echo "Lỗi khi xoá khách hàng: " . $conn->error;
}

// Lấy tất cả các khách hàng có email là "example@gmail.com"
$sql = "SELECT * FROM customers WHERE email = 'example@gmail.com'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Danh sách khách hàng có email 'example@gmail.com':<br>";
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . ", Name: " . $row["name"] . ", Email: " . $row["email"] . ", Phone: " . $row["phone"] . "<br>";
    }
} else {
    echo "Không tìm thấy khách hàng có email 'example@gmail.com'.<br>";
}

// Tạo bảng "orders"
$sql = "CREATE TABLE orders (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    customer_id INT(6) UNSIGNED,
    total_amount DECIMAL(10, 2) NOT NULL,
    order_date DATE,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
)";

if ($conn->query($sql) === TRUE) {
    echo "Bảng 'orders' đã được tạo thành công.<br>";
} else {
    echo "Lỗi khi tạo bảng 'orders': " . $conn->error;
}

// Thêm một đơn hàng mới vào bảng "orders" cho khách hàng có id là 3
$sql = "INSERT INTO orders (customer_id, total_amount, order_date)
        VALUES (3, 100.50, CURDATE())";

if ($conn->query($sql) === TRUE) {
    echo "Thêm đơn hàng mới thành công.<br>";
} else {
    echo "Lỗi khi thêm đơn hàng mới: " . $conn->error;
}

// Lấy tất cả các đơn hàng của khách hàng có id là 3
$sql = "SELECT * FROM orders WHERE customer_id = 3";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Danh sách đơn hàng của khách hàng có id là 3:<br>";
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . ", Customer ID: " . $row["customer_id"] . ", Total Amount: " . $row["total_amount"] . ", Order Date: " . $row["order_date"] . "<br>";
    }
} else {
    echo "Không tìm thấy đơn hàng cho khách hàng có id là 3.<br>";
}
// Lấy danh sách khách hàng và đơn hàng của họ, sử dụng câu lệnh JOIN
$sql = "SELECT customers.id, customers.name, orders.id AS order_id, orders.total_amount, orders.order_date
        FROM customers
        LEFT JOIN orders ON customers.id = orders.customer_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Danh sách khách hàng và đơn hàng của họ:<br>";
    while ($row = $result->fetch_assoc()) {
        echo "Customer ID: " . $row["id"] . ", Name: " . $row["name"] . ", Order ID: " . $row["order_id"] . ", Total Amount: " . $row["total_amount"] . ", Order Date: " . $row["order_date"] . "<br>";
    }
} else {
    echo "Không tìm thấy khách hàng và đơn hàng tương ứng.<br>";
}

// Lấy danh sách email của khách hàng, sử dụng hàm DISTINCT
$sql = "SELECT DISTINCT email FROM customers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Danh sách email của khách hàng:<br>";
    while ($row = $result->fetch_assoc()) {
        echo "Email: " . $row["email"] . "<br>";
    }
} else {
    echo "Không tìm thấy email của khách hàng.<br>";
}

// Đóng kết nối tới cơ sở dữ liệu
$conn->close();
?>