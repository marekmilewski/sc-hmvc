<?php echo $header; ?>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default" style="margin-top:150px;">
            <div class="panel-heading"><h5 style="margin:0;padding:0;">Admin CMS</h5></div>
            <div class="panel-body" style="padding:30px;">
                
            <form action="<?php echo base_url().'auth/admin/login'; ?>" method="post" role="form" accept-charset="utf-8">
                
                <div class="form-group <?php if(form_error('identity')!='') echo 'has-error'; ?>" style="margin:0;">
                    <label for="identity" style="font-size:13px;font-weight:normal;">Email/Login:</label>
                        <div class="input-group input-group-sm">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input name="identity" type="text" value="<?php echo set_value('identity'); ?>" class="form-control" id="identity" placeholder="Wprowadź nazwę użytkownika lub email">                    
                        </div>
                </div>
                
                <div class="form-group <?php if(form_error('password')!='') echo 'has-error'; ?>">
                    <label for="password" style="font-size:13px;font-weight:normal;">Hasło</label>
                        <div class="input-group input-group-sm">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        <input name="password" type="password" value="<?php echo set_value('password'); ?>" class="form-control" id="password" placeholder="Wprowadź hasło">                    
                        </div>
                </div>                
                
                <div class="row">
                     <div class="col-xs-6 col-sm-6 col-md-6">
                         <input type="checkbox" name="remember" value="1" id="remember" /> Zapamiętaj mnie
                     </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <button name="submit" onclick="this.form.submit();" type="submit" class="btn btn-primary pull-right">Zaloguj się&nbsp;<span class="glyphicon glyphicon-log-in"></span></button>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                    <p><a href="forgot_password">Nie pamiętasz hasła?</a></p>
                    </div>
                </div>
            </form>
                
                
            </div>
            </div>
        </div>
    </div>
</div>



<?php echo $footer; ?>