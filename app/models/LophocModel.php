<?php
class LophocModel
{
    private $db;

    public function __construct()
    {
        $this->db = ConnectDB::getInstance()->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM `lophoc` ORDER BY `malop` ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM `lophoc` WHERE `id` = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByMalop($malop)
    {
        $stmt = $this->db->prepare("SELECT * FROM `lophoc` WHERE `malop` = ?");
        $stmt->execute([$malop]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($malop, $tenlop)
    {
        $stmt = $this->db->prepare("INSERT INTO `lophoc` (`malop`, `tenlop`) VALUES (?, ?)");
        return $stmt->execute([$malop, $tenlop]);
    }

    public function update($id, $malop, $tenlop)
    {
        $stmt = $this->db->prepare("UPDATE `lophoc` SET `malop` = ?, `tenlop` = ? WHERE `id` = ?");
        return $stmt->execute([$malop, $tenlop, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM `lophoc` WHERE `id` = ?");
        return $stmt->execute([$id]);
    }
}
?>
