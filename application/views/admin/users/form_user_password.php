<script type="text/javascript">
    $(document).ready(function(){
       $("button,submit,reset").jqxInput({ theme: 'fresh', height: '28px' }); 
       $("#btnSimpan").click(function(){
            $("#divForm").hide();
            $("#divLoad").css("display","block");
            $("#divLoad").html("<div style='text-align:center;margin-top: 70px'><br><br><br><br><img src='<?php echo base_url();?>media/images/loaderB64.gif' alt='loading content.. '><br>loading</div>");
         //   alert($("#frmData").serialize());
            $.ajax({
                type: "POST",
                data: $("#frmData").serialize(),
                url: "<?php echo base_url(); ?>index.php/admin_user/doedit_password/"+{id},
                success: function(response){
                    if(response=="1"){
                        close_dialog();
                        $('#clearfilteringbutton').click();
    					$.notific8('Notification', {
    					  life: 5000,
    					  message: 'Save data succesfully.',
    					  heading: 'Saving data',
    					  theme: 'lime'
    					});
                    }else{
                        $.notific8('Notification', {
    					  life: 5000,
    					  message: response,
    					  heading: 'Saving data FAIL',
    					  theme: 'red'
    					});
                        
                        $("#divLoad").css("display","none");
                        $.ajax({
                           type: "POST",
                           url: "<?php echo base_url(); ?>index.php/admin_user/edit_password/"+{id},
                           success: function(response){
                             $("#divForm").show();
                             $("#divForm").html(response);
                           } 
                        });
                        
                    }    
                }
             });
       });
    });
</script>
<div style="display: none;" id="divLoad"></div>
<div style="padding:5px;text-align:center" id="divForm">
<form method="POST" id="frmData">
	<button type="button" id="btnSimpan">Simpan</button>
	<button type="reset">Ulang</button>
	<button type="button" onClick="close_dialog();">Batal</button>
	<br />
	<br />
	<table border="0" cellpadding="0" cellspacing="8" class="panel" align="center">
		<tr>
			<td>
                <table border="0" cellpadding="3" cellspacing="2">
				    <tr>
                        <td>Username</td>
                        <td>:</td>
                        <td>
                            <input class=input type="text" size="25" name="username" value="<?php echo $username; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Level</td>
                        <td>:</td>
                        <td>
                            <select size="1" class="input" name="level" style="width: 120px;">
                                <?php
                                $level = $this->admin_users_model->get_user_level();
                                foreach($level as $row_level){
                                ?>
                                    <option value="<?php echo $row_level->level; ?>" <?php if($row_level->level==$level) echo "Selected"; ?>><?php echo $row_level->level; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td>:</td>
                        <td>
                            <input type="password" size="20" class="input" name="password" value="<?php echo $password; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Confirm Password</td>
                        <td>:</td>
                        <td>
                            <input type="password" size="20" class="input" name="password2" value="<?php echo $password2; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Active</td>
                        <td>:</td>
                        <td>
                            <input type="checkbox" value="1" name="status_active" class="input" <?php if($status_active=="1") echo "Checked"; ?>/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $cap['image']; ?>
                        </td>
                        <td>:</td>
                        <td>
                            <input class=input type="text" size="10" name="captcha"/>
                        </td>
                    </tr>
                    <tr>
						<td colspan="3" height="30">&nbsp;</td>
					</tr>
				</table>
            </td>
		</tr>
	</table>
</form>
</div>