<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH . '/modules/crud/controllers/main.php';


class Admin extends Main{

public function __construct(){
    parent::__construct();
    $this->config->load('menu');
}
    

    public function edit(){
        if( !$this->crud_library->isValidForm() ){
            $data=$this->crud_library->getForm();

            $header=modules::run('html/draw/header');
            $footer=modules::run('html/draw/footer');            
            $form=modules::run('html/draw/form',$data['fields'],$data['data'],$data['errors']);
            $this->load->view('crud/main',array('header'=>$header,'footer'=>$footer,'form'=>$form) );
        }
        else{
            $data=$this->crud_library->getFormData();
            $this->crud_library->updateRecord($data);
            $this->renderMenu();
            redirect($this->session->userdata('referer'));
        }
            
    }
    

    public function add(){
        if( !$this->crud_library->isValidForm() ){
            $header=modules::run('html/draw/header');
            $footer=modules::run('html/draw/footer');            
            $form=modules::run('html/draw/form',$data['fields'],$data['data'],$data['errors']);
            
            $this->load->view('crud/main',array('header'=>$header,'footer'=>$footer,'form'=>$form) );
        }
        else{
            $data=$this->crud_library->getFormData();
            $this->crud_library->addRecord($data);
            $this->renderMenu();            
            redirect($this->session->userdata('referer'));
        }
            
            
            
    }



private function renderMenu(){
    $this->load->model('menu/menu_model');
    $items=$this->menu_model->getMenu(0);
    
    $fixed=($this->config->item('fixed')!='') ? $this->config->item('fixed') : '' ;
    $style=($this->config->item('style')!='') ? $this->config->item('style') : 'navbar-default' ;
    
    $out='';
    $out.='<nav class="navbar '.$style.' '.$fixed.'" role="navigation">';
    
        $out.='<div class="navbar-header">';
            $out.='<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">';
            $out.='<span class="sr-only">Toggle navigation</span>';
            
            $out.='<span class="icon-bar"></span>';
            $out.='<span class="icon-bar"></span>';
            $out.='<span class="icon-bar"></span>';
            
            $out.='</button>';
            if($this->config->item('brand')!='')
                $out.='<a class="navbar-brand" href="#">'.$this->config->item('brand').'</a>';
        $out.='</div>';
    
        
        $out.='<div class="collapse navbar-collapse navbar-ex1-collapse">';
            $out.='<ul class="nav navbar-nav">';
            
            
            
            
            foreach($items as $item){
                $subitems=$this->menu_model->getMenu($item['menuID']);
                
                if(count($subitems)>0){
                    $out.='<li class="dropdown">';
                    $out.='<a href="#"  class="dropdown-toggle" data-toggle="dropdown">'.$item['name'].' <b class="caret"></b></a>';
                    $out.='<ul class="dropdown-menu" role="menu">';
                                  
                    foreach($subitems as $subitem)
                        $out.='<li><a href="'.base_url().$subitem['link'].'">'.$subitem['name'].'</a></li>';
                    
                    $out.='</ul>';
                    $out.='</li>';
                    
                }
                else
                    $out.='<li><a href="'.base_url().$item['link'].'">'.$item['name'].'</a></li>';
                
            }
        
        
            $out.='</ul>';
        $out.='</div>';
        
        
    $out.='</nav>';
    
    $this->load->helper('file');
    file_put_contents('application/modules/html/views/menu.php', $out);

}



}
?>
