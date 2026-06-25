<?php
class SinhvienModel
{
    private $db;

    public function __construct()
    {
        $this->db = ConnectDB::getInstance()->getConnection();
    }

    public function getAll($search = '', $sortField = 'mssv', $sortOrder = 'asc', $offset = 0, $limit = 10)
    {
        // Sanitize sorting inputs to prevent SQL Injection
        $allowedFields = ['mssv', 'hoten', 'malop'];
        $sortField = in_array($sortField, $allowedFields) ? $sortField : 'mssv';
        $sortOrder = strtolower($sortOrder) === 'desc' ? 'DESC' : 'ASC';

        $sql = "SELECT sv.*, lh.tenlop 
                FROM `sinhvien` sv 
                LEFT JOIN `lophoc` lh ON sv.malop = lh.malop 
                WHERE sv.mssv LIKE :search 
                   OR sv.hoten LIKE :search 
                   OR sv.malop LIKE :search 
                   OR lh.tenlop LIKE :search 
                ORDER BY sv.`$sortField` $sortOrder 
                LIMIT :offset, :limit";

        $stmt = $this->db->prepare($sql);
        
        $searchTerm = '%' . $search . '%';
        $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll($search = '')
    {
        $sql = "SELECT COUNT(*) 
                FROM `sinhvien` sv 
                LEFT JOIN `lophoc` lh ON sv.malop = lh.malop 
                WHERE sv.mssv LIKE :search 
                   OR sv.hoten LIKE :search 
                   OR sv.malop LIKE :search 
                   OR lh.tenlop LIKE :search";

        $stmt = $this->db->prepare($sql);
        $searchTerm = '%' . $search . '%';
        $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM `sinhvien` WHERE `id` = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByMssv($mssv)
    {
        $stmt = $this->db->prepare("SELECT * FROM `sinhvien` WHERE `mssv` = ?");
        $stmt->execute([$mssv]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($mssv, $hoten, $malop, $ngaysinh, $gioitinh, $quequan)
    {
        $stmt = $this->db->prepare("INSERT INTO `sinhvien` (`mssv`, `hoten`, `malop`, `ngaysinh`, `gioitinh`, `quequan`) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$mssv, $hoten, $malop, $ngaysinh, $gioitinh, $quequan]);
    }

    public function update($id, $mssv, $hoten, $malop, $ngaysinh, $gioitinh, $quequan)
    {
        $stmt = $this->db->prepare("UPDATE `sinhvien` SET `mssv` = ?, `hoten` = ?, `malop` = ?, `ngaysinh` = ?, `gioitinh` = ?, `quequan` = ? WHERE `id` = ?");
        return $stmt->execute([$mssv, $hoten, $malop, $ngaysinh, $gioitinh, $quequan, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM `sinhvien` WHERE `id` = ?");
        return $stmt->execute([$id]);
    }
}
?>
