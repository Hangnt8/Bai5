<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "khachhang";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $mysqli_error());
}
// Tạo bảng KHACHHANG
$sqlCreateKHACHHANG = "CREATE TABLE KHACHHANG (
    MAKH char(4) PRIMARY KEY,
    HOTEN VARCHAR(255),
    DCHI VARCHAR(255),
    SODT VARCHAR(20),
    NGSINH DATE,
    DOANHSO DECIMAL(10, 2),
    NGDK DATE
)";

if (mysqli_query($conn, $sqlCreateKHACHHANG)) {
    echo "Tạo bảng KHACHHANG thành công<br>";
} else {
    echo "Lỗi trong quá trình tạo bảng KHACHHANG: " . mysqli_error($conn) . "<br>";
}

// Tạo bảng NHANVIEN
$sqlCreateNHANVIEN = "CREATE TABLE NHANVIEN (
    MANV char(4) PRIMARY KEY,
    HOTEN VARCHAR(255),
    NGVL DATE,
    SODT VARCHAR(20)
)";

if (mysqli_query($conn, $sqlCreateNHANVIEN)) {
    echo "Tạo bảng NHANVIEN thành công<br>";
} else {
    echo "Lỗi trong quá trình tạo bảng NHANVIEN: " . mysqli_error($conn) . "<br>";
}

// Tạo bảng SANPHAM
$sqlCreateSANPHAM = "CREATE TABLE SANPHAM (
    MASP char(4) PRIMARY KEY,
    TENSP VARCHAR(255),
    DVT VARCHAR(20),
    NUOCSX VARCHAR(255),
    GIA DECIMAL(10, 2)
)";

if (mysqli_query($conn, $sqlCreateSANPHAM)) {
    echo "Tạo bảng SANPHAM thành công<br>";
} else {
    echo "Lỗi trong quá trình tạo bảng SANPHAM: " . mysqli_error($conn) . "<br>";
}

// Tạo bảng HOADON
$sqlCreateHOADON = "CREATE TABLE HOADON (
    SOHD int PRIMARY KEY,
    NGHD DATE,
    MAKH char(4),
    MANV char(4),
    TRIGIA DECIMAL(10, 2),
    FOREIGN KEY (MAKH) REFERENCES KHACHHANG(MAKH) ON DELETE CASCADE,
    FOREIGN KEY (MANV) REFERENCES NHANVIEN(MANV) ON DELETE CASCADE
)";

if (mysqli_query($conn, $sqlCreateHOADON)) {
    echo "Tạo bảng HOADON thành công<br>";
} else {
    echo "Lỗi trong quá trình tạo bảng HOADON: " . mysqli_error($conn) . "<br>";
}

// Tạo bảng CTHD
$sqlCreateCTHD = "CREATE TABLE CTHD (
    SOHD int,
    MASP char(4),
    SL int,
    PRIMARY KEY (SOHD, MASP),
    FOREIGN KEY (SOHD) REFERENCES HOADON(SOHD) ON DELETE CASCADE,
    FOREIGN KEY (MASP) REFERENCES SANPHAM(MASP) ON DELETE CASCADE
)";

if (mysqli_query($conn, $sqlCreateCTHD)) {
    echo "Tạo bảng CTHD thành công<br>";
} else {
    echo "Lỗi trong quá trình tạo bảng CTHD: " . mysqli_error($conn) . "<br>";
}

// Câu lệnh INSERT vào bảng NHANVIEN
$sqlInsertNhanVien = "INSERT INTO NHANVIEN (MANV, HOTEN, NGVL, SODT) VALUES
                            ('NV01', 'Nguyen Nhu Nhut', '2006-04-13', '0927345678'),
                            ('NV02', 'Le Thi Phi Yen', '2006-04-21', '0987567390'),
                            ('NV03', 'Nguyen Van B', '2006-04-27', '0997047382'),
                            ('NV04', 'Ngo Thanh Tuan', '2006-04-24', '0913758498'),
                            ('NV05', 'Nguyen Thi Truc Thanh', '2006-07-20', '0918590387');";

if (mysqli_query($conn, $sqlInsertNhanVien)) {
    echo "Thêm dữ liệu vào bảng NHANVIEN thành công<br>";
} else {
    echo "Lỗi khi thêm dữ liệu vào bảng NHANVIEN: " . mysqli_error($conn) . "<br>";
}

// Câu lệnh INSERT vào bảng KHACHHANG
$sqlInsertKhachHang = "INSERT INTO `KHACHHANG`(`MAKH`, `HOTEN`, `DCHI`, `SODT`, `NGSINH`, `DOANHSO`, `NGDK`) VALUES
                            ('KH01','Nguyen Van A','731 Tran Hung Dao, Q5, TpHCM','08823451','1960-10-22','13,060,000','2006-07-22'),
                            ('KH02','Tran Ngoc Han','23/5 Nguyen Trai, Q5, TpHCM','0908256478','1974-04-03','280,000','2006-07-30'),
                            ('KH03','Tran Ngoc Linh','45 Nguyen Canh Chan, Q1, TpHCM','0938776266','1980-06-12','3,860,000','2006-08-05'),
                            ('KH04','Tran Minh Long','50/34 Le Dai Thanh, Q10, TpHCM','0917325476','1965-03-09','250,000','2006-10-20'),
                            ('KH05','Le Nhat Minh','30 Truong Dinh, Q3, TpHCM','08246108','1950-03-10','21,000','2006-10-28'),
                            ('KH06','Le Hoai Thuong','227 Nguyen Van Cu, Q5, TpHCM','08631738','1981-12-31','915,000','2006-11-24'),
                            ('KH07','Nguyen Van Tam','32/3 Tran Binh Trong, Q5, TpHCM','0916783565','1971-06-04','12,500','2006-06-01'),
                            ('KH08','Nguyen Van Ba','123 Nguyen Hue, Q1, TpHCM','0938435756','1972-01-10','450,000','2006-12-01'),
                            ('KH09','Tran Van Hai','456 Nguyen Trai, Q5, TpHCM','0938435757','1973-02-11','650,000','2007-01-01'),
                            ('KH10','Le Van Hung','789 Nguyen Canh Chan, Q1, TpHCM','0938435758','1974-03-12','850,000','2007-01-02');";

if (mysqli_query($conn, $sqlInsertKhachHang)) {
    echo "Thêm dữ liệu vào bảng KHACHHANG thành công<br>";
} else {
    echo "Lỗi khi thêm dữ liệu vào bảng KHACHHANG: " . mysqli_error($conn) . "<br>";
}

// Câu lệnh INSERT vào bảng SANPHAM
$sqlInsertSanPham = "INSERT INTO SANPHAM (MASP,TENSP, DVT, NUOCSX, GIA) VALUES
                        ('SP01','But chi', 'cay', 'Viet Nam', '5,000'),
                        ('SP02','But chi', 'hop', 'Viet Nam', '30,000'),
                        ('SP03','But bi', 'cay', 'Viet Nam', '5,000'),
                        ('SP04','But bi', 'hop', 'Trung Quoc', '7,000'),
                        ('SP05','Tap 100 giay mong', 'quyen', 'Trung Quoc', '2,500'),
                        ('SP06','Tap 200 giay mong', 'quyen', 'Trung Quoc', '4,500'),
                        ('SP07','Tap 100 giay mong', 'quyen', 'Viet Nam', '3,000'),
                        ('SP08','Tap 200 giay mong', 'quyen', 'Viet Nam', '5,500'),
                        ('SP09','Tap 100 giay mong', 'chuc', 'Viet Nam', '23,000'),
                        ('SP10','Tap 200 giay mong', 'chuc', 'Viet Nam', '53,000');";

if (mysqli_query($conn, $sqlInsertSanPham)) {
    echo "Thêm dữ liệu vào bảng SANPHAM thành công<br>";
} else {
    echo "Lỗi khi thêm dữ liệu vào bảng SANPHAM: " . mysqli_error($conn) . "<br>";
}

// Câu lệnh INSERT vào bảng HOADON
$sqlInsertHoaDon = "INSERT INTO HOADON (SOHD, NGHD, MAKH, MANV, TRIGIA) VALUES
                        (1, '2023-06-15', 'KH01', 'NV01', 100000),
                        (2, '2023-06-16', 'KH02', 'NV02', 200000),
                        (3, '2023-06-17', 'KH03', 'NV03', 300000),
                        (4, '2023-06-18', 'KH04', 'NV04', 400000),
                        (5, '2023-06-19', 'KH05', 'NV04', 500000),
                        (6, '2023-06-20', 'KH06', 'NV03', 600000),
                        (7, '2023-06-21', 'KH07', 'NV02', 700000),
                        (8, '2023-06-22', 'KH08', 'NV01', 800000);";

if (mysqli_query($conn, $sqlInsertHoaDon)) {
    echo "Thêm dữ liệu vào bảng HOADON thành công<br>";
} else {
    echo "Lỗi khi thêm dữ liệu vào bảng HOADON: " . mysqli_error($conn) . "<br>";
}

// Câu lệnh INSERT vào bảng CTHD
$sqlInsertCTHD = "INSERT INTO CTHD (SOHD, MASP, SL) VALUES
                    (1,'SP01', 1),
                    (1,'SP02', 2),
                    (2,'SP03', 3),
                    (2,'SP04', 4),
                    (3,'SP01', 5),
                    (3,'SP03', 6),
                    (4,'SP03', 7),
                    (4,'SP01', 8),
                    (5,'SP02', 9),
                    (5,'SP04', 10),
                    (6,'SP010', 11),
                    (6,'SP08', 12),
                    (7,'SP09', 13),
                    (7,'SP07', 14),
                    (8,'SP06', 15),
                    (8,'SP05', 16);";

if (mysqli_query($conn, $sqlInsertCTHD)) {
    echo "Thêm dữ liệu vào bảng CTHD thành công<br>";
} else {
    echo "Lỗi khi thêm dữ liệu vào bảng CTHD: " . mysqli_error($conn) . "<br>";
}

// Thêm thuộc tính GHICHU vào quan hệ SANPHAM
$sqlAddColumnGHICHU = "ALTER TABLE SANPHAM ADD COLUMN GHICHU VARCHAR(20)";

if (mysqli_query($conn, $sqlAddColumnGHICHU)) {
    echo "Thêm thuộc tính GHICHU cho quan hệ SANPHAM thành công<br>";
} else {
    echo "Lỗi trong quá trình thêm thuộc tính GHICHU cho quan hệ SANPHAM: " . mysqli_error($conn) . "<br>";
}

// Thêm thuộc tính LOAIKH vào quan hệ KHACHHANG
$sqlAddColumnLOAIKH = "ALTER TABLE KHACHHANG ADD COLUMN LOAIKH TINYINT";

if (mysqli_query($conn, $sqlAddColumnLOAIKH)) {
    echo "Thêm thuộc tính LOAIKH cho quan hệ KHACHHANG thành công<br>";
} else {
    echo "Lỗi trong quá trình thêm thuộc tính LOAIKH cho quan hệ KHACHHANG: " . mysqli_error($conn) . "<br>";
}

// Cập nhật tên "Nguyễn Văn B" cho dữ liệu Khách Hàng có mã là KH01
$sqlUpdateKH01 = "UPDATE KHACHHANG SET HOTEN = 'Nguyễn Văn B' WHERE MAKH = 'KH01'";

if (mysqli_query($conn, $sqlUpdateKH01)) {
    echo "Cập nhật tên 'Nguyễn Văn B' cho dữ liệu Khách Hàng có mã là KH01 thành công<br>";
} else {
    echo "Lỗi trong quá trình cập nhật tên 'Nguyễn Văn B' cho dữ liệu Khách Hàng có mã là KH01: " . mysqli_error($conn) . "<br>";
}

// Cập nhật tên "Nguyễn Văn Hoan" cho dữ liệu Khách Hàng có mã là KH09 và năm đăng ký là 2007
$sqlUpdateKH09 = "UPDATE KHACHHANG SET HOTEN = 'Nguyễn Văn Hoan' WHERE MAKH = 'KH09' AND YEAR(NGDK) = 2007";

if (mysqli_query($conn, $sqlUpdateKH09)) {
    echo "Cập nhật tên 'Nguyễn Văn Hoan' cho dữ liệu Khách Hàng có mã là KH09 và năm đăng ký là 2007 thành công<br>";
} else {
    echo "Lỗi trong quá trình cập nhật tên 'Nguyễn Văn Hoan' cho dữ liệu Khách Hàng có mã là KH09 và năm đăng ký là 2007: " . mysqli_error($conn) . "<br>";
}

// Sửa kiểu dữ liệu của thuộc tính GHICHU trong quan hệ SANPHAM thành varchar(100)
$sqlModifyColumnGHICHU = "ALTER TABLE SANPHAM MODIFY COLUMN GHICHU VARCHAR(100)";

if (mysqli_query($conn, $sqlModifyColumnGHICHU)) {
    echo "Sửa kiểu dữ liệu của thuộc tính GHICHU trong quan hệ SANPHAM thành varchar(100) thành công<br>";
} else {
    echo "Lỗi trong quá trình sửa kiểu dữ liệu của thuộc tính GHICHU trong quan hệ SANPHAM: " . mysqli_error($conn) . "<br>";
}

// Xóa thuộc tính GHICHU trong quan hệ SANPHAM
$sqlDropColumnGHICHU = "ALTER TABLE SANPHAM DROP COLUMN GHICHU";

if (mysqli_query($conn, $sqlDropColumnGHICHU)) {
    echo "Xóa thuộc tính GHICHU trong quan hệ SANPHAM thành công<br>";
} else {
    echo "Lỗi trong quá trình xóa thuộc tính GHICHU trong quan hệ SANPHAM: " . mysqli_error($conn) . "<br>";
}

// Xóa tất cả dữ liệu khách hàng có năm sinh 1971
$sqlDelete1971 = "DELETE FROM KHACHHANG WHERE YEAR(NGSINH) = 1971";

if (mysqli_query($conn, $sqlDelete1971)) {
    echo "Xóa tất cả dữ liệu khách hàng có năm sinh 1971 thành công<br>";
} else {
    echo "Lỗi trong quá trình xóa tất cả dữ liệu khách hàng có năm sinh 1971: " . mysqli_error($conn) . "<br>";
}

// Xóa tất cả dữ liệu khách hàng có năm sinh 1971 và năm đăng ký 2006
$sqlDelete1971_2006 = "DELETE FROM KHACHHANG WHERE YEAR(NGSINH) = 1971 AND YEAR(NGDK) = 2006";

if (mysqli_query($conn, $sqlDelete1971_2006)) {
    echo "Xóa tất cả dữ liệu khách hàng có năm sinh 1971 và năm đăng ký 2006 thành công<br>";
} else {
    echo "Lỗi trong quá trình xóa tất cả dữ liệu khách hàng có năm sinh 1971 và năm đăng ký 2006: " . mysqli_error($conn) . "<br>";
}

// Xóa tất hoá đơn có mã KH = KH01
$sqlDeleteHoaDonKH01 = "DELETE FROM HOADON WHERE MAKH = 'KH01'";

if (mysqli_query($conn, $sqlDeleteHoaDonKH01)) {
    echo "Xóa tất hoá đơn có mã KH = KH01 thành công<br>";
} else {
    echo "Lỗi trong quá trình xóa tất hoá đơn có mã KH = KH01: " . mysqli_error($conn) . "<br>";
}

// Đóng kết nối
mysqli_close($conn);
?>