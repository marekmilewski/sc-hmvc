<?php

echo $header;

if ($this->uri->segment( $this->config->item('action_segment'),'view')=='view')
    echo $table;
elseif($this->uri->segment( $this->config->item('action_segment') )=='add' || $this->uri->segment( $this->config->item('action_segment') )=='edit')
    echo $form;


echo $footer;

?>




