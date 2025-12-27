<?php
class View {
    protected $view_path = 'app/views/';
    protected $data = [];
    
    public function set($key, $value = null) {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }
        return $this;
    }
    
    public function render($view, $layout = 'main') {
        $view_file = $this->view_path . 'pages/' . $view . '.php';
        $layout_file = $this->view_path . 'layouts/' . $layout . '.php';
        
        if (!file_exists($view_file)) {
            throw new Exception("View file not found: " . $view_file);
        }
        
        if (!file_exists($layout_file)) {
            throw new Exception("Layout file not found: " . $layout_file);
        }
        
        extract($this->data);
        ob_start();
        include $view_file;
        $content = ob_get_clean();
        include $layout_file;
    }
    
    public function partial($partial, $data = []) {
        $partial_file = $this->view_path . 'partials/' . $partial . '.php';
        
        if (!file_exists($partial_file)) {
            throw new Exception("Partial file not found: " . $partial_file);
        }
        
        extract($data);
        include $partial_file;
    }
    
    public function e($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}
?>