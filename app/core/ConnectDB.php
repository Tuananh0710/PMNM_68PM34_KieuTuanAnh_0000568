<?php
class ConnectDB
{
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        try {
            // 1. Connect to MySQL server (without specifying DB name yet)
            $dsn = "mysql:host=" . DB_HOST . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, DB_USER, DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // 2. Create database if it doesn't exist
            $this->conn->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            
            // 3. Connect to the created database
            $this->conn->exec("USE `" . DB_NAME . "`");
            
            // 4. Initialize structure and seed initial records
            $this->initDatabase();
        } catch (PDOException $e) {
            die("Database Connection Error: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ConnectDB();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }

    private function initDatabase()
    {
        // 1. Users Table for Authentication
        $queryUsers = "CREATE TABLE IF NOT EXISTS `users` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `username` VARCHAR(50) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `fullname` VARCHAR(100) NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        $this->conn->exec($queryUsers);

        // 2. Classes (Lớp học) Table
        $queryLophoc = "CREATE TABLE IF NOT EXISTS `lophoc` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `malop` VARCHAR(50) NOT NULL UNIQUE,
            `tenlop` VARCHAR(100) NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        $this->conn->exec($queryLophoc);

        // 3. Students (Sinh viên) Table
        $querySinhvien = "CREATE TABLE IF NOT EXISTS `sinhvien` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `mssv` VARCHAR(50) NOT NULL UNIQUE,
            `hoten` VARCHAR(100) NOT NULL,
            `malop` VARCHAR(50) NOT NULL,
            `ngaysinh` DATE NULL,
            `gioitinh` VARCHAR(10) NULL,
            `quequan` VARCHAR(255) NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (`malop`) REFERENCES `lophoc`(`malop`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        $this->conn->exec($querySinhvien);

        // Seed default administrator if users table is empty
        $stmtUsersCount = $this->conn->query("SELECT COUNT(*) FROM `users`");
        if ($stmtUsersCount->fetchColumn() == 0) {
            $username = 'admin';
            $password = password_hash('admin', PASSWORD_BCRYPT);
            $fullname = 'Administrator';
            
            $stmtInsertUser = $this->conn->prepare("INSERT INTO `users` (`username`, `password`, `fullname`) VALUES (?, ?, ?)");
            $stmtInsertUser->execute([$username, $password, $fullname]);
        }

        // Seed default classes if lophoc table is empty
        $stmtLophocCount = $this->conn->query("SELECT COUNT(*) FROM `lophoc`");
        if ($stmtLophocCount->fetchColumn() == 0) {
            $classes = [
                ['68PM34', 'Phần mềm K68 Lớp 34'],
                ['68PM35', 'Phần mềm K68 Lớp 35'],
                ['67PM31', 'Phần mềm K67 Lớp 31']
            ];
            $stmtInsertLophoc = $this->conn->prepare("INSERT INTO `lophoc` (`malop`, `tenlop`) VALUES (?, ?)");
            foreach ($classes as $class) {
                $stmtInsertLophoc->execute($class);
            }
        }

        // Seed default students if sinhvien table is empty
        $stmtSinhvienCount = $this->conn->query("SELECT COUNT(*) FROM `sinhvien`");
        if ($stmtSinhvienCount->fetchColumn() == 0) {
            $students = [
                ['0000568', 'Kiều Tuấn Anh', '68PM34', '2004-10-07', 'Nam', 'Hà Nội'],
                ['0000569', 'Nguyễn Văn A', '68PM34', '2004-01-15', 'Nam', 'Hải Phòng'],
                ['0000570', 'Trần Thị B', '68PM35', '2004-05-20', 'Nữ', 'Đà Nẵng'],
                ['0000571', 'Phạm Minh C', '67PM31', '2003-12-30', 'Nam', 'Hồ Chí Minh']
            ];
            $stmtInsertSinhvien = $this->conn->prepare("INSERT INTO `sinhvien` (`mssv`, `hoten`, `malop`, `ngaysinh`, `gioitinh`, `quequan`) VALUES (?, ?, ?, ?, ?, ?)");
            foreach ($students as $student) {
                $stmtInsertSinhvien->execute($student);
            }
        }
    }
}
?>
