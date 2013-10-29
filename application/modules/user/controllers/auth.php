<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Auth extends MX_Controller{
    
    
    public function __construct() {
        parent::__construct();

        //$this->load->library('user_library');
        
        if(!$this->IsLogin())
            redirect('user/auth');
        
            
            
        

        /*
        if(!Modules::run('users/auth/logged_in'))
            redirect('users/auth/index');
        */
        
        //redirect('user/profile');
    }
    
    public function index(){
        die('aaaa');
        echo 'form...';
    }
    
    
    private function IsLogin(){
        return true;
    }
    
    
    
}


?>
