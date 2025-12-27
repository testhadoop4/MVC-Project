<?php
class Product extends Model {
    protected $table = 'products';
    
    public function __construct($db) {
        parent::__construct($db);
    }
    
    public function create($data) {
        $query = "INSERT INTO products (name, description, price, category, stock_quantity) 
                 VALUES (:name, :description, :price, :category, :stock_quantity)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':category', $data['category']);
        $stmt->bindParam(':stock_quantity', $data['stock_quantity']);
        
        return $stmt->execute();
    }
    
    public function update($id, $data) {
        $query = "UPDATE products SET name = :name, description = :description, price = :price, 
                 category = :category, stock_quantity = :stock_quantity WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':category', $data['category']);
        $stmt->bindParam(':stock_quantity', $data['stock_quantity']);
        
        return $stmt->execute();
    }
}
?>