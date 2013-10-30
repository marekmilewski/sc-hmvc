<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Draw extends MX_Controller {

    public function __construct() {
        parent::__construct();
    }
  
    
    
    
    public function index(){
        $header=$this->header(true);
        $footer=$this->footer();
        
        $this->load->view('admin/welcome',array('header'=>$header, 'footer'=>$footer) );
        
    }
    
    
    
    public function header(){
       return $this->load->view('admin/header',array('menu'=>$menu),true);
    }
    
    public function footer(){
       return $this->load->view('admin/footer',true);
    }    
    
    public function table($columns,$data,$pagination=false,$description=''){
        return $this->load->view('admin/table',array('columns'=>$columns, 'data'=>$data,'pagination'=>$pagination, 'description'=>$description),true);
    }
    
    public function form($fields,$data,$errors){
        return $this->load->view('admin/form',array('fields'=>$fields,  'data'=>$data, 'errors'=>$errors),true);
    }
    
    
    
}

?>
