<div class="title">{title_form}</div>
<div class="clear">&nbsp;</div>
<?php if($this->session->flashdata('alert')!="")
{ ?>
<div class="alert" id="alert">
<div align=right onClick="$('#alert').hide('fold',1000);" style="color:red;font-weight:bold">X</div>
<?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>
<div class="clear">&nbsp;</div>
<form action="<?php echo base_url()?>index.php/admin_user/{action}" method="POST" name="frmUsers">
	<br />
	<table border="0" cellpadding="2" cellspacing="2">
		<tr>
			<td class="panel">
				<table border="0" cellpadding="3" cellspacing="2">
					<tr>
						<td>Email</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="email" value="<?php echo $email?>" /></td>
					</tr>
					
					<tr>
					<td><?php echo $cap['image'];?></td>
					<td>:</td>
					<?php
					$data = array(
								  'name'        => 'captcha',
								  'id'          => 'captcha',
								  'class'       => 'input',
								);
					?>
					<td><?php echo form_input($data);?></td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
	<br />
	<button type="submit" class=btn>Submit</button>
	<button type="reset" class=btn>Ulang</button>
	<button type="button" class=btn onclick="document.location.href='<?php echo base_url()?>index.php/admin/login/';">Kembali</button>
</form>
