<?php

$errors=(isset($errors) && $errors!='') ? $errors : '' ;    

if($errors!='')
    echo '<div class="alert alert-dismissable alert-danger">'.$errors.'</div>';

?>
<div class="panel panel-default">
  <div class="panel-heading"><?php echo $title; if($this->uri->segment( $this->config->item('action_segment') )=='add') echo ': Nowy rekord'; else echo ': Edycja'; ?></div>
  <div class="panel-body">


<form method="post" action="<?php echo current_url();?>" class="form-horizontal" enctype="multipart/form-data" role="form">
    
<?php
foreach($fields as $field) { ?>
        
<div class="form-group <?php if(form_error($field['name'])!='') echo 'has-error'; ?>">
<label for="<?php echo $field['name']; ?>" class="col-lg-2 control-label"><?php echo $field['label']; ?></label>
<div class="col-lg-<?php echo $field['size']; ?>">
    
<?php
switch($field['type']){
    case 'text':
    case 'password':
        $value=(isset($data[$field['name']]) && $data[$field['name']]!='') ? set_value($field['name'], $data[$field['name']]) : set_value($field['name'], $field['default']);
        echo '<input type="'.$field['type'].'" class="form-control input-sm" name="'.$field['name'].'" id="'.$field['name'].'" placeholder="'.$field['label'].'" value="'.$value.'"/>';
    break;
    case 'select':
        $sdata=array();
        $tmp=explode(';',$field['data']);
        
        echo '<select name="'.$field['name'].'" class="form-control input-sm">'; 
        $default=(!$this->input->post()) ? $field['default'] : $this->input->post($field['name']);
        
        echo '<option value="0">--- Wybierz ---</option>';
        foreach($tmp as $t){    
            $_t=explode(':',$t);
            echo '<option '.set_select($field['name'], $_t[0], ($default==$_t[0]) ? TRUE : FALSE ).' value="'.$_t[0].'">'.$_t[1].'</option>';
        }
        echo '</select>';
    break;

    case 'checkbox':
        $sdata=array();
        $tmp=explode(';',$field['data']);
        $default=(!$this->input->post()) ? $field['default'] : $this->input->post($field['name']);
        
         foreach($tmp as $t){
            $_t=explode(':',$t);
            echo '<div class="checkbox"><label><input type="checkbox" name="'.$field['name'].'" id="'.$field['name'].'" value="'.$_t[0].'" '.set_checkbox($field['name'],$_t[0],($_t[0]==$default) ? TRUE : FALSE ).' >'.$_t[1].'</label></div>';
         }
    break;
    
    case 'radio':
         $tmp=explode(';',$field['data']);
         $default=(!$this->input->post()) ? $field['default'] : $this->input->post($field['name']);
         
         foreach($tmp as $t){
            $_t=explode(':',$t);
            echo '<div class="radio"><label><input type="radio" name="'.$field['name'].'" id="'.$field['name'].'" value="'.$_t[0].'" '.set_radio($field['name'],$_t[0],($_t[0]==$default) ? TRUE : FALSE ).'>'.$_t[1].'</label></div>';
         }
         
    break;

    case 'textarea':
        $value=(isset($data[$field['name']]) && $data[$field['name']]!='') ? set_value($field['name'], $data[$field['name']]) : set_value($field['name'], $field['default']);
        echo '<textarea class="form-control input-sm" id="'.$field['name'].'" name="'.$field['name'].'">'.$value.'</textarea>';
    break;

    case 'editor':
        $value=(isset($data[$field['name']]) && $data[$field['name']]!='') ? set_value($field['name'], $data[$field['name']]) : set_value($field['name'], $field['default']);
        echo '<textarea id="'.$field['name'].'" name="'.$field['name'].'">'.$value.'</textarea>';
        echo '<script type="text/javascript">';
        echo '	CKEDITOR.replace("'.$field['name'].'",{
            enterMode: 2,
            shiftEnterMode: 2}); ';
        echo '</script>';

    break;

    case 'file':
        echo '<input type="file"  id="'.$field['name'].'" name="'.$field['name'].'"/>';
    break;
    
    case 'image':
        echo '<input type="file" id="'.$field['name'].'" name="'.$field['name'].'" />';
        
        if(isset($data[$field['name']])){
            $tmp=explode($field['data']);
            
            foreach($tmp as $tm){
                $t=explode(':',$tm);
                if($t[0]=='upload_path'){
                        $path=$t[1];
                }
                    
            }
                
            echo '<img src="'.$path.$data[$field['name']].'" alt="" border="" />';  
        }
    break;
    
    case 'date':
        $id=rand();
        echo '<div class="form-group date">
                <div class="input-group date" id="date'.$id.'">
                    <input type="text" class="form-control input-sm" data-format="yyyy-MM-dd" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
';
        echo '<script type="text/javascript">
                    $("#date'.$id.'").datetimepicker({pickTime: false});
                  </script>';
    break;

    case 'time':
        $id=rand();
        echo '<div class="form-group date">
                <div class="input-group date" id="time'.$id.'">
                    <input type="text" class="form-control input-sm" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
            </div>
';
        echo '<script type="text/javascript">
                    $("#time'.$id.'").datetimepicker({pickDate: false,pickSeconds: false});
                  </script>';
    break;

    case 'datetime':
        $id=rand();
        echo '<div class="form-group date">
                <div class="input-group date" id="datetime'.$id.'">
                    <input type="text" class="form-control input-sm" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
            </div>
';
        echo '<script type="text/javascript">
                    $("#datetime'.$id.'").datetimepicker({pickDate: true, pickTime: true, pickSeconds: true});
                  </script>';
    break;

}  

if(form_error($field['name'])!='')
    echo '<span class="help-block">'.form_error($field['name']).'</span>';
    
?>
    </div>
    </div>
<?php } ?>
        
<div class="row">
    <div class="col-md-12 center">
    <input class="btn btn-default" onclick="document.location.href='<?php echo $this->session->userdata('referer'); ?>'" type="button" value="Anuluj"/>
    <input class="btn btn-primary" type="submit" name="send" value="<?php if($this->uri->segment( $this->config->item('action_segment') )=='add') echo 'Dodaj'; else echo 'Zapisz'; ?>"/>
    </div>
</div>        
        
    </form>


  </div>
</div>
