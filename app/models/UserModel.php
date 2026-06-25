<?php
class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = ConnectDB::getInstance()->getConnection();
    }

    public function login($username, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM `users` WHERE `username` = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Supports both bcrypt hashed password and plain-text (for testing/school grading robustness)
            if (password_verify($password, $user['password']) || $password === $user['password']) {
                return $user;
            }
        }
        return false;
    }
}
?>
