<?php echo $header; ?>

<?php echo $this->session->flashdata('message'); ?>


<div class="container">
<div class="row">
<div class="col-md-4 col-md-offset-4">
    
    <div class="panel panel-default" style="margin-top:150px;">
            <div class="panel-heading"><h5 style="margin:0;padding:0;">Admin CMS</h5></div>
            <div class="panel-body" style="padding:30px;">
            <form action="<?php echo base_url().'users/auth/forgot_password'; ?>" method="post" role="form">

                <div class="form-group <?php if(form_error('email')!='') echo 'has-error'; ?>" style="margin:0;">
                    <label for="email" style="font-size:13px;font-weight:normal;">Email:</label>
                        <div class="input-group input-group-sm">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input name="email" type="text" value="<?php echo set_value('email'); ?>" class="form-control" id="identity" placeholder="Wpisz adres email">                    
                        </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button name="submit" onclick="this.form.submit();" type="submit" class="btn btn-primary pull-right">Wyślij&nbsp;<span class="glyphicon glyphicon-log-in"></span></button>
                    </div>
                </div>
                
            </form>   
            </div>
    </div>
    
    
</div>
</div>
</div>
