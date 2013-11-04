<?php

echo $header;

if ($this->uri->segment( $this->config->item('action_segment'),'view')=='view'){ ?>
<div class="row">
    <div class="col-md-offset-3 col-md-6 center" ><a href="<?php echo $add_link; ?>" class="btn btn-sm btn-primary" style="margin:10px;"><span class="glyphicon glyphicon-plus"></span>&nbsp;Dodaj</a></div> 
</div>
    <?php
    echo $table;
}
elseif($this->uri->segment( $this->config->item('action_segment') )=='add' || $this->uri->segment( $this->config->item('action_segment') )=='edit')
    echo $form;


echo $footer;

?>




