<?php defined('BASEPATH') OR exit('No direct script access allowed');

require (APPPATH.'modules/crud/controllers/main.php');

class Admin extends Main {
    
public function __construct(){
    parent::__construct();
}    
    
    
public function index(){
    parent::view();
}



public function add(){

    if( !$this->crud_library->isValidForm() ){
        $data=$this->crud_library->getForm();   
        $header=modules::run('html/draw/header');
        $footer=modules::run('html/draw/footer');
        $form=modules::run('html/draw/form',$data['title'],$data['fields'],$data['data'],$data['errors']);
        
        $this->load->view('crud/main',array('header'=>$header,'footer'=>$footer,'form'=>$form) );
    }
    else{
        $data=$this->crud_library->getFormData();
        
        $additional_data = array(
              'first_name' => $data['first_name'],
              'last_name' => $date['last_name'],
              'company' => $data['company'],
              'phone' => $data['phone']);
		
        $this->load->library('ion_auth');
        $this->ion_auth->register($data['username'], $data['password'], $data['email'], $additional_data);
         
        redirect($this->session->userdata('referer'));
     }
            
            
            
   }


public function edit(){
    if( !$this->crud_library->isValidForm() ){
        $data=$this->crud_library->getForm();
        
        $header=modules::run('html/draw/header');
        $footer=modules::run('html/draw/footer');
        $form=modules::run('html/draw/form',$data['title'],$data['fields'],$data['data'],$data['errors']);
        
        $this->load->view('crud/main',array('header'=>$header,'footer'=>$footer,'form'=>$form) );
        }
     else{
         $data=$this->crud_library->getFormData();
         
        $keys=$this->crud_library->getKeysFromURL();
        $this->load->library('ion_auth');
        $this->ion_auth->update($keys['id'], $data);

         redirect($this->session->userdata('referer'));
        }
            
    }
    
    
public function delete(){
    $keys=$this->crud_library->getKeysFromURL();
    
    $this->load->library('ion_auth');    
    $this->ion_auth->delete_user($keys['id']);
    redirect($this->session->userdata('referer'));
}
    
    
}

