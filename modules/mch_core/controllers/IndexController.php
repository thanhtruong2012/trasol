<?php
class IndexController extends Controller{
    
    public function __construct(){
        parent::__construct();
        $this->template = new View("home");
    }
    
    public function index(){
        
    }
     
}
?>