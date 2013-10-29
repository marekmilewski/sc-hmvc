
<?php if($pagination){ ?>
<div class="row"><div class="col-md-offset-6 col-lg-6 right"><?php echo $pagination; ?></div></div>
<?php } ?>

<div class="row">
<div class="col-md-12">

<div class="panel panel-default"> 
<div class="panel-heading"><?php echo $description; ?></div>
<div class="panel-body">
    
<table class="table table-hover table-striped">
<thead>
<tr>
<?php foreach($columns as $column){ ?>
<th style="width:<?php echo $column['width'];?>%;"><?php echo $column['description'];?></th>
<?php } ?>
</tr>
</thead>    
    
<tbody>    
    
 <?php 

if(is_array($data) && sizeof($data)>0) 
foreach($data as $key=>$row){ ?>
<tr>    
<?php foreach($columns as $column){ 
    if($column['name']=='edit_action')
        echo '<td><a class="btn btn-success btn-xs pull-left" href="'.$row[$column['name']].'"><span class="glyphicon glyphicon-edit"></span>&nbsp;Edycja</a></td>';
    elseif($column['name']=='delete_action')
        echo '<td><a class="btn btn-danger btn-xs pull-right" href="'.$row[$column['name']].'"><span class="glyphicon glyphicon-remove"></span>&nbsp;Usuń</a></td>';    
    else { ?>
        <td <?php if(isset($column['align']) && $column['align']!='') echo 'class="'.$column['align'].'"'; ?>><?php echo substr(strip_tags($row[$column['name']]),0,200); ?></td>
    <?php } ?>

<?php }; ?>
</tr>
<?php }; ?>    

</tbody>    
</table>
    

</div>
    
</div>
</div>
</div>
