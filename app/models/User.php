<?php
class User extends Model {
    protected $table = 'users';
    
    public function __construct($db) {
        parent::__construct($db);
    }
    
    public function create($data) {
        $query = "INSERT INTO users (name, email, phone, status) VALUES (:name, :email, :phone, :status)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':status', $data['status']);
        
        return $stmt->execute();
    }
    
    public function update($id, $data) {
        $query = "UPDATE users SET name = :name, email = :email, phone = :phone, status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':status', $data['status']);
        
        return $stmt->execute();
    }
    
    public function getUsersForDataTable($request) {
        // Get total records
        $query = "SELECT COUNT(*) as total FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $totalRecords = $stmt->fetch()['total'];
        
        // Build query with search and pagination
        $search = $request['search']['value'] ?? '';
        $start = $request['start'] ?? 0;
        $length = $request['length'] ?? 10;
        $orderColumn = $request['order'][0]['column'] ?? 0;
        $orderDir = $request['order'][0]['dir'] ?? 'asc';
        
        $columns = ['id', 'name', 'email', 'phone', 'status', 'created_at'];
        $orderBy = $columns[$orderColumn] . ' ' . $orderDir;
        
        $query = "SELECT * FROM users 
                 WHERE name LIKE :search OR email LIKE :search OR phone LIKE :search
                 ORDER BY $orderBy LIMIT :start, :length";
        
        $stmt = $this->db->prepare($query);
        $searchTerm = '%' . $search . '%';
        $stmt->bindParam(':search', $searchTerm);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':length', $length, PDO::PARAM_INT);
        $stmt->execute();
        
        $data = $stmt->fetchAll();
        
        // Get filtered count
        $query = "SELECT COUNT(*) as filtered FROM users 
                 WHERE name LIKE :search OR email LIKE :search OR phone LIKE :search";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':search', $searchTerm);
        $stmt->execute();
        $filteredRecords = $stmt->fetch()['filtered'];
        
        return [
            'data' => $data,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords
        ];
    }
}
?>