<div style="width:99%;background-color:#F6F6F6;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #F9F9F9;height:40px">
	<table width='100%' cellpadding=0 cellspacing=0 height='100%'>
		<tr valign="middle">
			<td style='background:#FFFFFF;-moz-border-radius:5px 0px 0px 5px;border-radius:5px 0px 0px 5px;padding-left:5px;font-size:15px;color:#585858;font-weight:bold' width='50%'>
				. {title}
			</td>
			<td style='background:#EDEDED;-moz-border-radius:0px 5px 5px 0px;border-radius:0px 5px 5px 0px;text-align:right;padding-right:20px'>
			</td>
		</tr>
	</table>
</div>
<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
<?php if($this->session->flashdata('alert')!="")
{ ?>
<div class="alert" id="alert">
<div align=right onClick="$('#alert').hide('slow');" style="color:red;font-weight:bold">X</div>
<?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>
<div class="clear">&nbsp;</div>
<form action="<?php echo base_url()?>index.php/ske/edit_account/" method="POST" name="frmUsers">
<input type="hidden" size="30" name="username" value="<?php echo $username?>">
	<br />
	<table border="0" cellpadding="2" cellspacing="2">
		<tr>
			<td class="panel">
				<table border="0" cellpadding="3" cellspacing="2">
					<tr>
						<td>Email / Username</td>
						<td>:</td>
						<td><?php echo $username?></td>
					</tr>
					<tr>
						<td>Password</td>
						<td>:</td>
						<td><input class=input type="password" size="30" name="password" value="<?php echo $password?>" /></td>
					</tr>
					<tr>
						<td>Confirm Password</td>
						<td>:</td>
						<td><input class=input type="password" size="30" name="password2" value="<?php echo $password2?>" /></td>
					</tr>
					<tr>
					<td><?php echo $cap['image'];?></td>
					<td>:</td>
					<td><?php echo form_input('captcha');?></td>
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
