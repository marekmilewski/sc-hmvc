<?php defined('BASEPATH') OR exit('No direct script access allowed');

require (APPPATH.'modules/crud/controllers/main.php');

class Admin extends Main {
    
public function __construct(){
    parent::__construct();
}    
    
    
public function index(){
    parent::view();
}    
    




}

