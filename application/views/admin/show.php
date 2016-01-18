<div class="clear">&nbsp;</div>
<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert" id="alert">
<div align=right onClick="$('#alert').hide('fold',1000);" style="color:red;font-weight:bold">X</div>
<?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>
<?php
$id_theme=$this->session->userdata('id_theme');
?>
<div class="clear">&nbsp;</div>
<table width="100%" cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td style="background:#999999;text-align:right;color:#EEEEEE;font-size:11px;padding:8px;">....</td>
	</tr>
	<tr>
		<td style="background:#FEFEFE;color:#333333;border-left:5px solid #999999;border-right:5px solid #999999">
			<div style="border:2px solid #EEEEEE;font-size:14px;padding:5px;">
			Welcome : <b><?php echo $this->session->userdata('username');?></b><br>
			Level : <b><?php echo $this->session->userdata('level');?></b><br>
			</div>
		</td>
	</tr>
	<tr>
		<td style="background:#999999;text-align:right;;;"><div style="float:right;padding:10px;font-size:18px;color:#FFFFFF">Panel Menu</div></td>
	</tr>
	<tr>
		<td style="background:#999999;padding:5px;">
		<table align=center cellpadding=0 cellspacing=5>
			<tr>
				<td style="border: 1px solid silver;-moz-border-radius:5px 5px 5px 5px;">
					<div id="menuicon-2">
					<a href="<?php echo base_url()?>index.php/admin_user" class="link2"><img src="<?php echo base_url()?>public/themes/admin/images/user.gif" alt="User List" border=0> <br> User List</a></div>
				</td>
				<td style="border: 1px solid silver;-moz-border-radius:5px 5px 5px 5px;">
					<div id="menuicon-2">
					<a href="<?php echo base_url()?>index.php/admin_file" class="link2"><img src="<?php echo base_url()?>public/themes/admin/images/file.gif" alt="File List" border=0> <br> Files Management</a></div>
				</td>
				<td style="border: 1px solid silver;-moz-border-radius:5px 5px 5px 5px;">
					<div id="menuicon-2">
					<a href="<?php echo base_url()?>index.php/admin_menu" class="link2"><img src="<?php echo base_url()?>public/themes/admin/images/menu.gif" alt="Menu List" border=0> <br> Menu Management</a></div>
				</td>
				<td style="border: 1px solid silver;-moz-border-radius:5px 5px 5px 5px;">
					<div id="menuicon-2">
					<a href="<?php echo base_url()?>index.php/admin_group" class="link2"><img src="<?php echo base_url()?>public/themes/admin/images/group.gif" alt="Group List" border=0> <br> Group List Management</a></div>
				</td>
				<td style="border: 1px solid silver;-moz-border-radius:5px 5px 5px 5px;">
					<div id="menuicon-2">
					<a href="<?php echo base_url()?>index.php/admin_role" class="link2"><img src="<?php echo base_url()?>public/themes/admin/images/role.gif" alt="Group List" border=0> <br> Group Role</a></div>
				</td>
				<td style="border: 1px solid silver;-moz-border-radius:5px 5px 5px 5px;">
					<div id="menuicon-2">
					<a href="<?php echo base_url()?>index.php/admin_config" class="link2"><img src="<?php echo base_url()?>public/themes/admin/images/config.gif" alt="Setting Configuration" border=0> <br> Setting Configuration</a></div>
				</td>
				<td style="border: 1px solid silver;-moz-border-radius:5px 5px 5px 5px;">
					<div id="menuicon-2">
					<a href="<?php echo base_url()?>index.php/admin_contact" class="link2"><img src="<?php echo base_url()?>public/themes/admin/images/contact.gif" alt="Contact Information"> <br> Contact Information</a></div>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td style="background:#999999;text-align:right;;;"><div style="float:right;padding:10px;font-size:18px;color:#FFFFFF">Account</div></td>
	</tr>
	<tr>
		<td style="background:#999999;padding:5px;">
		<table align=center cellpadding=0 cellspacing=5>
			<tr>
				<td style="border: 1px solid silver;-moz-border-radius:5px 5px 5px 5px;">
					<div id="menuicon-2">
					<a href="<?php echo base_url()?>index.php/admin_user/edit_account/<?php echo $this->session->userdata('id');?>" class="link2"><img src="<?php echo base_url()?>public/themes/admin/images/password.gif" alt="Change Password" border=0> <br> Change Password</a></div>
				</td>
				<td style="border: 1px solid silver;-moz-border-radius:5px 5px 5px 5px;">
					<div id="menuicon-2">
					<a href="<?php echo base_url()?>index.php/admin/logout" class="link2"><img src="<?php echo base_url()?>public/themes/admin/images/logout.gif" alt="Logout" border=0> <br> Logout</a></div>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td style="background:#999999;padding:10px;color:#FFFFFF;">Badan POM RI<br>Copyrighted &copy; 2013</td>
	</tr>
</table>
