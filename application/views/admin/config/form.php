<div style="padding:10px">
<div class="title">{title_form}</div>
<div class="clear">&nbsp;</div>
<?php if($this->session->flashdata('alert_form')!=""){ ?>
<div class="alert" id="alert">
<div align=right onClick="$('#alert').hide('fold',1000);" style="color:red;font-weight:bold">X</div>
<?php echo $this->session->flashdata('alert_form')?>
</div>
<?php } ?>
<div class="clear">&nbsp;</div>
<form action="<?php echo base_url()?>index.php/admin_config/doupdate" method="POST" name="frmUsers">
	<br />
	<table border="0" cellpadding="0" cellspacing="8" class="panel">
		<tr>
			<td>

				<table border="0" cellpadding="3" cellspacing="2">
					<tr>
						<td>Web Title</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="title" value="<?php echo $title?>" /></td>
					</tr>
					<tr>
						<td>META Descripton</td>
						<td>:</td>
						<td><input class=input type="text" size="80" name="description" value="<?php echo $description?>" /></td>
					</tr>
					<tr>
						<td>META Keywords</td>
						<td>:</td>
						<td><input class=input type="text" size="80" name="keywords" value="<?php echo $keywords?>" /></td>
					</tr>
					<tr>
						<td>Detault Template ID</td>
						<td>:</td>
						<td><?php echo form_dropdown('theme_default', $theme_default_option, $theme_default," class=input");?></td>
					</tr>
					<tr>
						<td>Offline Template ID</td>
						<td>:</td>
						<td><?php echo form_dropdown('theme_offline', $theme_default_option, $theme_offline," class=input");?></td>
					</tr>
					<tr>
						<td>Online/Offline</td>
						<td>:</td>
						<td><input class=input type="checkbox" name="online" value="1" <?php if($online) echo "checked"; ?>></td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
	<br />
	<div class="title">Mail Configuration</div>
	<div class="clear">&nbsp;</div>
	<br />
	<table border="0" cellpadding="0" cellspacing="8" class="panel">
		<tr>
			<td>

				<table border="0" cellpadding="3" cellspacing="2">
					<tr>
						<td>Mail Server</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="mail_server" value="<?php echo $mail_server?>" /></td>
					</tr>
					<tr>
						<td>Mail Port</td>
						<td>:</td>
						<td><input class=input type="text" size="5" name="mail_port" value="<?php echo $mail_port?>" /></td>
					</tr>
					<tr>
						<td>Mail User</td>
						<td>:</td>
						<td><input class=input type="text" size="30" name="mail_user" value="<?php echo $mail_user?>" /></td>
					</tr>
					<tr>
						<td>Mail Password</td>
						<td>:</td>
						<td><input class=input type="password" size="30" name="mail_password" value="<?php echo $mail_password?>" /></td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
	<br />
	<button type="submit" class=btn>Simpan</button>
	<button type="reset" class=btn>Ulang</button>
</form>
</div>