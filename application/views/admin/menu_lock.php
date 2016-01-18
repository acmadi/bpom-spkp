<div class="jqx-widget-header jqx-widget-header-arctic jqx-fill-state-pressed jqx-fill-state-pressed-arctic jqx-expander-header-expanded jqx-expander-header-expanded-arctic jqx-expander-header jqx-expander-header-arctic" style="position: relative; height: auto; z-index: 0;">
	<div class="jqx-expander-header-content jqx-expander-header-content-arctic" style="padding: 4px 2px 1px 12px; float: left; margin-left: 0px; min-height: 17px;">Main Panel</div>
</div>
<div class="jqx-widget-content jqx-widget-content-arctic jqx-expander-content jqx-expander-content-arctic jqx-expander-content-bottom jqx-expander-content-bottom-arctic"  style="padding: 10px 2px 1px 15px; position: relative; display: block; height: 263px;">
	<table>
		<tr>
			<td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/user.gif" alt="User List"></td>
			<td><a href="<?php echo base_url()?>index.php/admin_user" class="link2">User List</a></td>
		</tr>
		<tr>
			<td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/file.gif" alt="File List"></td>
			<td><a href="<?php echo base_url()?>index.php/admin_file" class="link2">Files Management</a></td>
		</tr>
		<tr>
			<td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/menu.gif" alt="Menu Management"></td>
			<td><a href="<?php echo base_url()?>index.php/admin_menu" class="link2">Menu Management</a></td>
		</tr>
		<tr>
			<td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/group.gif" alt="Group List Management"></td>
			<td><a href="<?php echo base_url()?>index.php/admin_group" class="link2">Group List Management</a></td>
		</tr>
		<tr>
			<td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/role.gif" alt="Group Role"></td>
			<td><a href="<?php echo base_url()?>index.php/admin_role" class="link2">Group Role</a></td>
		</tr>
		<tr>
			<td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/user.gif" alt="Group Authorization"></td>
			<td><a href="<?php echo base_url()?>index.php/admin_user_authorization" class="link2">Group Authorization</a></td>
		</tr>
		<tr>
			<td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/config.gif" alt="Setting Configuration"></td>
			<td><a href="<?php echo base_url()?>index.php/admin_config" class="link2">Setting Configuration</a></td>
		</tr>
		<tr>
			<td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/contact.gif" alt="Contact Information"></td>
			<td><a href="<?php echo base_url()?>index.php/admin_contact" class="link2">Contact Information</a></td>
		</tr>
	</table>
</div>

<div style="background:#444444;color:#DDDDDD;font-size:11px;padding:5px;">
Web address: <br><div style="padding-left:20px;padding-bottom:5px"><?php echo base_url();?></div>
Server : <br><div style="padding-left:20px;padding-bottom:5px"><?php echo $_SERVER['SERVER_ADDR'];?><br><?php echo $_SERVER['SERVER_SIGNATURE'];?></div>
Remote IP: <br><div style="padding-left:20px;padding-bottom:5px"><?php echo $_SERVER['REMOTE_ADDR'];?></div>
User agent : <br><div style="padding-left:20px;padding-bottom:5px"><?php echo $_SERVER['HTTP_USER_AGENT'];?></div>
</div>
