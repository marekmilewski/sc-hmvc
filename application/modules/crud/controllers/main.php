<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class main extends MX_Controller{
    
    public function __construct() {
        parent::__construct();
        
        $this->load->module('auth');
        if(!$this->auth->ion_auth->logged_in())
            redirect('auth/login', 'refresh');

        $this->load->library('crud/crud_library');
    }
  
    
    public function index(){
    }
    
    public function view(){
        $data=$this->crud_library->getView();
        
        $header=modules::run('html/admin/header');
        //$menu=modules::run('menu/admin/draw');

        $footer=modules::run('html/admin/footer');
        $table=modules::run('html/admin/table',$data['columns'],$data['data'],$data['pagination'],$data['description']);
        
        $this->load->view('crud/main',array('header'=>$header,'footer'=>$footer,'table'=>$table) );
    }
    
    public function edit(){
        if( !$this->crud_library->isValidForm() ){
            $data=$this->crud_library->getForm();

            $header=modules::run('html/admin/header');
            $footer=modules::run('html/admin/footer');            
            $form=modules::run('html/admin/form',$data['fields'],$data['data'],$data['errors']);
            
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
            $header=modules::run('html/admin/header');
            $footer=modules::run('html/admin/footer');            
            $form=modules::run('html/admin/form',$data['fields'],$data['data'],$data['errors']);
            
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
