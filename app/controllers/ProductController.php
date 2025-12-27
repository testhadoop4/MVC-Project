<?php
class ProductController extends Controller {
    
    public function index() {
        $product_model = $this->model('Product');
        $products = $product_model->getAll();
        
        $this->view->set([
            'title' => 'Products Management',
            'page_title' => 'Products Management',
            'products' => $products
        ]);
        $this->view->render('products/index', 'main');
    }
    
    public function create() {
        $this->view->set([
            'title' => 'Create New Product',
            'page_title' => 'Create New Product'
        ]);
        $this->view->render('products/create', 'main');
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_model = $this->model('Product');
            
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'category' => $_POST['category'],
                'stock_quantity' => $_POST['stock_quantity']
            ];
            
            if ($product_model->create($data)) {
                $_SESSION['success'] = 'Product created successfully!';
                $this->redirect('/products');
            } else {
                $_SESSION['error'] = 'Error creating product!';
                $this->redirect('/products/create');
            }
        }
    }
    
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $product_model = $this->model('Product');
        $product = $product_model->getById($id);
        
        if (!$product) {
            $_SESSION['error'] = 'Product not found!';
            $this->redirect('/products');
        }
        
        $this->view->set([
            'title' => 'Edit Product',
            'page_title' => 'Edit Product',
            'product' => $product
        ]);
        $this->view->render('products/edit', 'main');
    }
    
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $product_model = $this->model('Product');
            
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'category' => $_POST['category'],
                'stock_quantity' => $_POST['stock_quantity']
            ];
            
            if ($product_model->update($id, $data)) {
                $_SESSION['success'] = 'Product updated successfully!';
                $this->redirect('/products');
            } else {
                $_SESSION['error'] = 'Error updating product!';
                $this->redirect('/products/edit?id=' . $id);
            }
        }
    }
    
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $product_model = $this->model('Product');
            
            if ($product_model->delete($id)) {
                $this->jsonResponse(['success' => true, 'message' => 'Product deleted successfully!']);
            } else {
                $this->jsonResponse(['success' => false, 'message' => 'Error deleting product!']);
            }
        }
    }
}
?>