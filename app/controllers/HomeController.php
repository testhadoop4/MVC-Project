<?php
class HomeController extends Controller {
    
    public function index() {
        $this->view->set([
            'title' => 'Dashboard - MVC Bootstrap App',
            'page_title' => 'Dashboard'
        ]);
        $this->view->render('home/index', 'main');
    }
}
?>