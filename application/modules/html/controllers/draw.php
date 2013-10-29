<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Draw extends MX_Controller {

    public function __construct() {
        parent::__construct();
    }
  
    
    public function index(){
    }
    
    
    public function header($drawMenu=true){
       return $this->load->view('header',array('drawMenu'=>$drawMenu),true);
    }
    
    public function footer(){
       return $this->load->view('footer',true);
    }    
    
    public function table($columns,$data,$pagination=false,$description=''){
        return $this->load->view('table',array('columns'=>$columns, 'data'=>$data,'pagination'=>$pagination, 'description'=>$description),true);
    }
    
    public function form($fields,$data,$errors){
        return $this->load->view('form',array('fields'=>$fields,  'data'=>$data, 'errors'=>$errors),true);
    }
    
    
    
   // public function 
    
    
    
}

?>
