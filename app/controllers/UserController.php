<?php
class UserController extends Controller {
    
    public function index() {
        $this->view->set([
            'title' => 'Users Management',
            'page_title' => 'Users Management'
        ]);
        $this->view->render('users/index', 'main');
    }
    
    public function create() {
        $this->view->set([
            'title' => 'Create New User',
            'page_title' => 'Create New User'
        ]);
        $this->view->render('users/create', 'main');
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_model = $this->model('User');
            
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'status' => $_POST['status']
            ];
            
            if ($user_model->create($data)) {
                $_SESSION['success'] = 'User created successfully!';
                $this->redirect('/users');
            } else {
                $_SESSION['error'] = 'Error creating user!';
                $this->redirect('/users/create');
            }
        }
    }
    
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $user_model = $this->model('User');
        $user = $user_model->getById($id);
        
        if (!$user) {
            $_SESSION['error'] = 'User not found!';
            $this->redirect('/users');
        }
        
        $this->view->set([
            'title' => 'Edit User',
            'page_title' => 'Edit User',
            'user' => $user
        ]);
        $this->view->render('users/edit', 'main');
    }
    
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $user_model = $this->model('User');
            
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'status' => $_POST['status']
            ];
            
            if ($user_model->update($id, $data)) {
                $_SESSION['success'] = 'User updated successfully!';
                $this->redirect('/users');
            } else {
                $_SESSION['error'] = 'Error updating user!';
                $this->redirect('/users/edit?id=' . $id);
            }
        }
    }
    
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $user_model = $this->model('User');
            
            if ($user_model->delete($id)) {
                $this->jsonResponse(['success' => true, 'message' => 'User deleted successfully!']);
            } else {
                $this->jsonResponse(['success' => false, 'message' => 'Error deleting user!']);
            }
        }
    }
    
    // AJAX endpoint for DataTables
    public function datatable() {
        $user_model = $this->model('User');
        $result = $user_model->getUsersForDataTable($_GET);
        $this->jsonResponse($result);
    }
}
?>