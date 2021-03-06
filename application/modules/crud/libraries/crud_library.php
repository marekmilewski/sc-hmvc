<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


class crud_library {
    private $CI;
    private $crudID;
    private $params;


    private $form_fields;
    private $form_data;
    private $form_upload_errors;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('crud/crud_model');
        
        $this->CI->config->load('crud/crud');
        $this->crudID=$this->getScrudID();
        $this->params=$this->CI->uri->uri_to_assoc($this->CI->config->item('params_start_segment') );

        $this->form_data=NULL;
        $this->upload_errors=NULL;
    }
    
    
    
    public function getView(){
        $this->CI->session->set_userdata(array('referer'=>current_url()) );

        if(isset($this->params['from']) && $this->params['from']!=''){
            $from=(int)$this->params['from'];
            unset($this->params['from']);
        }
        else
            $from=0;
        
        
        $description=$this->CI->crud_model->getTableDescription($this->crudID);
        $columns=$this->CI->crud_model->getColumns($this->crudID);

        $keys=$this->CI->crud_model->getKeys($this->crudID);
        $search_terms=$this->CI->crud_model->getSearch($this->crudID);        
        
        if(!$this->CI->input->post('search')){
            $search_terms=NULL;
            $search_value=NULL;
        }
        else
            $search_value=$this->CI->input->post('search');        
        
    
        $cols=array();
        foreach($columns as $col)
            $cols[].=$col['name'];
    
        foreach($keys as $key)
            $cols[].=$key['name'];
    
        $cols= array_unique($cols);
    
    
        $data=$this->CI->crud_model->getTableData($this->crudID,$cols,$this->params,$search_terms,$search_value,$this->CI->config->item('scrud_limit'),$from);

        foreach($data as $key=>$row){
            $data[$key]['edit_action']=base_url().$this->CI->uri->segment($this->CI->config->item('module_segment')).'/'.$this->CI->uri->segment($this->CI->config->item('class_segment')).'/edit/'.$this->crudID.'/'.$this->getKeys($keys,$data[$key]);
            $data[$key]['delete_action']="javascript:confirmDialog('".base_url().$this->CI->uri->segment($this->CI->config->item('module_segment')).'/'.$this->CI->uri->segment($this->CI->config->item('class_segment')).'/delete/'.$this->crudID.'/'.$this->getKeys($keys,$data[$key])."')";
        }
        
        
        $all_columns[0]=array('name' => 'edit_action','description'=>'Edycja','align'=>'center','width' => '10');
        $all_columns=array_merge($all_columns, $columns);
        array_push($all_columns, array('name' => 'delete_action','description'=>'Usuń','align'=>'center','width' => '10'));

        $this->CI->load->library('pagination');
        $config['base_url'] = base_url().$this->CI->uri->segment($this->CI->config->item('module_segment')).'/'.$this->CI->uri->segment($this->CI->config->item('class_segment')).'/view/'.$this->crudID.'/from/';
        $config['total_rows'] = $this->CI->crud_model->countResults($this->crudID);
        $config['per_page'] = $this->CI->config->item('scrud_limit');
        
        $this->CI->pagination->initialize($config);
        $pagination=$this->CI->pagination->create_links();
        return array('columns'=>$all_columns,'keys'=>$keys,'search'=>$search_terms,'data'=>$data,'description'=>$description,'pagination'=>$pagination,'scrudID'=>$this->crudID );
    }
    
    
    public function getKeys($keys,$data){
    $out=array();

    foreach($keys as $key)
        $out[].=$key['name'].'/'.$data[$key['name']];
    
    return implode('/',$out);
    }

    
    private function prepareCellData($data,$out){
    
        preg_match_all('/{(.*?)}/i',$out,$matches);
        foreach ($matches[1] as $match)
            $out=str_replace('{'.$match.'}',$data[$match],$out);
    
        $data= strip_tags($out);
        return $out;
    }

    public function isValidForm(){
        $form_valid=false;
        
        $this->form_fields=$this->CI->crud_model->getFields($this->crudID);       
        $this->CI->load->library('form_validation');
        $this->CI->form_validation->set_error_delimiters('','');
        
        $this->setFormValidation( $this->form_fields );
        
        $form_valid=$this->CI->form_validation->run();
        
        if ($form_valid)
            foreach($this->form_fields as $field)
                if($field['type']=='file' || $field['type']=='image'){
                
                    $required=false;
                
                    $tmp=explode(';',$field['data']);
                    $upload_config=array();
                
                    foreach($tmp as $tm){
                        $t=explode(':',$tm);
                        if($t[0]=='file_name')
                            $upload_config['file_name']=$this->CI->input->post($t[1]);
                        elseif($t[0]=='required' && $t[1]=='true')
                            $required=true;
                        else
                            $upload_config[$t[0]]=$t[1];
                    
                    }
                    $this->CI->load->library('upload', $upload_config);

                    $file_uploaded=$this->CI->upload->do_upload($field['name']);
                
                    if($file_uploaded){
                        $fdata=$this->upload->data();
                        $this->form_data[$field['name']]=$fdata['file_name'];
                    }
                    elseif(!$file_uploaded && $required){
                        $this->form_upload_errors=$this->upload->display_errors();
                        $form_valid=false;
                    }
                    
                    
            }        
            
    return $form_valid;        
    }
    
    
    private function setFormValidation(){
        foreach($this->form_fields as $field){
            if($field['rules']!='')
                $this->CI->form_validation->set_rules($field['name'], $field['label'], $field['rules']);
            else
                $this->CI->form_validation->set_rules($field['name'],'','');
            }
    
    }
    

    public function getForm(){
        
        $title=$this->CI->crud_model->getTableDescription($this->crudID);
        $errors=($this->form_upload_errors!='') ? NULL : $this->form_upload_errors ;
        
        if($this->CI->uri->segment( $this->CI->uri->segment($this->CI->config->item('method_segment')) )=='edit'){
            $select=array();
            
            foreach($this->form_fields as $field)
                $select[].=$field['name'];
                
            $data=$this->CI->crud_model->getData($this->crudID,$select, $this->getKeysFromURL() );
            $data=$data[0];
        }
        else
            $data=NULL;

        return array('title'=>$title,'fields'=>$this->form_fields, 'data'=>$data, 'errors'=>$errors );
    }
    
    
    
    public function getFormData(){

        foreach($this->form_fields as $field)
            if($field['type']!='file' || $field['type']!='image')
                $this->form_data[$field['name']]=$_POST[$field['name']];
    
    
    return $this->form_data;
    }
    
    
    public function addRecord($data){
        $this->CI->crud_model->addRecord($this->crudID,$data);
    }
    
    public function updateRecord($data){
        $this->CI->crud_model->updateRecord($this->crudID,$data,$this->getKeysFromURL() );
    }
    
    public function deleteRecord(){
        $keys=$this->getKeysFromURL();
        var_export($keys);
        $this->CI->crud_model->deleteRecord($this->crudID,$keys);
    }
    
    
    
    
    
    
    public function getKeysFromURL(){
        $keys=$this->CI->uri->uri_to_assoc( $this->CI->config->item('params_start_segment') );
        if(isset($keys['from']) && $keys['from']!='')
            unset($keys['from']);    
    
        return $keys;
    }

    public function getScrudID(){
        $this->crudID=$this->CI->uri->segment( $this->CI->config->item('crudID_segment') );
        if(!$this->crudID)
            die('No scrudID !!!');
        else
            return $this->crudID;
    }    
    
    
}


?>
