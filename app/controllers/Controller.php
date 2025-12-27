<?php
class Controller {
    protected $view;
    protected $db;
    
    public function __construct() {
        $this->view = new View();
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    protected function model($model) {
        require_once 'app/models/' . $model . '.php';
        return new $model($this->db);
    }
    
    protected function redirect($url) {
        header('Location: ' . $url);
        exit;
    }
    
    protected function jsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
?>