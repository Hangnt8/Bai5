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
    // Thêm 5 khách hàng mới vào bảng "customers"
    $stmt = $dbh->prepare("INSERT INTO customers (name, email, phone) VALUES (?, ?, ?)");
    $customers = array(
        array('nguyen van a', 'nguyenvana@example.com', '0912345671'),
        array('nguyen van b', 'nguyenvanb@gmail.com', '0912345672'),
        array('nguyen van c', 'nguyenvanc@example.com', '0912345673'),
        array('nguyen van d', 'nguyenvand@gmail.com', '0912345674'),
        array('nguyen van e', 'nguyenvane@example.com', '0912345675')
        );
    foreach ($customers as $customer) {
        $stmt->execute($customer);
    }
    echo "<br>Đã thêm 5 khách hàng thành công<br>";

    // Sửa thông tin của một khách hàng có id là 1
    $customerId = 1;
    $newEmail = 'newemail@example.com';
    
    $stmt = $dbh->prepare("UPDATE customers SET email = :email WHERE id = :id");
    $stmt->bindParam(':email', $newEmail);
    $stmt->bindParam(':id', $customerId);
    
    $stmt->execute();
    
    echo "<br>Đã cập nhật thông tin khách hàng có ID là 1 thành công<br>";

    // Xoá một khách hàng có id là 5
    $customerId = 5;

    $stmt = $dbh->prepare("DELETE FROM customers WHERE id = :id");
    $stmt->bindParam(':id', $customerId);

    if ($stmt->execute()) {
        $rowCount = $stmt->rowCount();
        if ($rowCount > 0) {
            echo "<br>Đã xoá khách hàng có ID là 5 thành công<br>";
        } else {
            echo "<br>Không tìm thấy khách hàng có ID là 5<br>";
        }
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "<br>Lỗi khi xoá khách hàng: " . $errorInfo[2];
    }

    // Lấy tất cả các khách hàng có email là "example@gmail.com"
    $email = 'example@gmail.com';

    $stmt = $dbh->prepare("SELECT * FROM customers WHERE email = :email");
    $stmt->bindParam(':email', $email);

    if ($stmt->execute()) {
        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($customers) > 0) {
            foreach ($customers as $customer) {
                echo "<br>Khách hàng ID: " . $customer['id'] . ", Tên: " . $customer['name'] . ", Email: " . $customer['email'] . ", Số điện thoại: " . $customer['phone'] . "<br>";
            }
        } else {
            echo "<br>Không tìm thấy khách hàng có email là example@gmail.com<br>";
        }
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "<br>Lỗi khi truy vấn cơ sở dữ liệu: " . $errorInfo[2];
    }

    // Tạo bảng "orders"
    $createOrdersTableQuery = "CREATE TABLE IF NOT EXISTS orders (
        id INT(11) PRIMARY KEY AUTO_INCREMENT,
        customer_id INT(11),
        total_amount DECIMAL(10, 2),
        order_date DATE,
        FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
    )";
    $dbh->exec($createOrdersTableQuery);
    echo "<br>Đã tạo bảng orders thành công<br>";

    // Thêm một đơn hàng mới vào bảng "orders" cho khách hàng có id là 3
    $customerId = 3;
    $totalAmount = 100.50;
    $orderDate = date('Y-m-d');

    $stmt = $dbh->prepare("INSERT INTO orders (customer_id, total_amount, order_date) VALUES (:customer_id, :total_amount, :order_date)");
    $stmt->bindParam(':customer_id', $customerId);
    $stmt->bindParam(':total_amount', $totalAmount);
    $stmt->bindParam(':order_date', $orderDate);

    if ($stmt->execute()) {
        echo "<br>Thêm đơn hàng thành công<br>";
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "Lỗi khi thêm đơn hàng: " . $errorInfo[2];
    }
    // Lấy tất cả các đơn hàng của khách hàng có id là 3
    $customerId = 3;

    $stmt = $dbh->prepare("SELECT * FROM orders WHERE customer_id = :customer_id");
    $stmt->bindParam(':customer_id', $customerId);
    
    if ($stmt->execute()) {
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($orders as $order) {
            echo "<br>Đơn hàng ID: " . $order['id'] . ", Khách hàng ID: " . $order['customer_id'] . ", Tổng số tiền: " . $order['total_amount'] . ", Ngày đặt hàng: " . $order['order_date'] . "<br>";
        }
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "<br>Lỗi khi truy vấn cơ sở dữ liệu: " . $errorInfo[2];
    }
    // Lấy danh sách khách hàng và đơn hàng của họ, sử dụng câu lệnh JOIN
    $stmt = $dbh->prepare("SELECT customers.id, customers.name, orders.id AS order_id, orders.total_amount, orders.order_date
    FROM customers
    LEFT JOIN orders ON customers.id = orders.customer_id");

    if ($stmt->execute()) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $row) {
            echo "<br>Khách hàng ID: " . $row['id'] . ", Tên: " . $row['name'] . ", Đơn hàng ID: " . $row['order_id'] . ", Tổng số tiền: " . $row['total_amount'] . ", Ngày đặt hàng: " . $row['order_date'] . "<br>";
        }
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "<br>Lỗi khi truy vấn cơ sở dữ liệu: " . $errorInfo[2];
    }

    // Lấy danh sách email của khách hàng, sử dụng hàm DISTINCT
    $stmt = $dbh->prepare("SELECT DISTINCT email FROM customers");

    if ($stmt->execute()) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $row) {
            echo "<br>Email: " . $row['email'] . "<br>";
        }
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "<br>Lỗi khi truy vấn cơ sở dữ liệu: " . $errorInfo[2];
    }
 }catch(PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
// Đóng kết nối
$conn = null;
?>
