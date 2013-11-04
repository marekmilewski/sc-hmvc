<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class main extends MX_Controller{
    
    public function __construct() {
        parent::__construct();
        
        $auth=$this->load->module('users/auth');
        if(!$auth->ion_auth->logged_in())
            redirect('users/auth', 'refresh');

        $this->load->library('crud/crud_library');
    }
  
    
    public function index(){
    }
    
    public function view(){
        $data=$this->crud_library->getView();
        $module=$this->router->fetch_module();
        
        $header=modules::run('html/draw/header');
        $footer=modules::run('html/draw/footer');
        $table=modules::run('html/draw/table',$data['columns'],$data['data'],$data['pagination'],$data['description']);
        $add_link=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/add/'.$this->crud_library->getScrudID();
        
        $this->load->view('crud/main',array('header'=>$header,'footer'=>$footer,'table'=>$table,'add_link'=>$add_link) );
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
            $this->crud_library->updateRecord($data);
            redirect($this->session->userdata('referer'));
        }
            
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
            $this->crud_library->addRecord($data);
            redirect($this->session->userdata('referer'));
        }
            
            
            
    }
    

    public function delete(){
        $this->crud_library->deleteRecord();
        redirect($this->session->userdata('referer'));
    }
    
    
}

?>
