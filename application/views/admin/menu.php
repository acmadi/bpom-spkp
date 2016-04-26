<script type="text/javascript">
    $(document).ready(function(){
        $("#accordion").jqxNavigationBar({ width: 300, theme: theme });
    });
</script>
<style type="text/css">
    li {
        list-style: none;
        margin-left: -20px;
        width: 200px;
    }
</style>
<div id="accordion">
    <div>
      <div style='margin-top: 2px;'>
          <div style='margin-left: 4px; float: left;'>Main Panel</div>
      </div>
    </div>
    <div>
      <ul>
         <li>
            <table>
                <tr>
    				<td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/user.gif" alt="User List"></td>
    				<td><a href="<?php echo base_url()?>index.php/admin_user" class="link2">User List</a></td>
			    </tr>
            </table>
         </li>
         <li>
            <table>
                <tr>
                    <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/file.gif" alt="File List"></td>
    				<td><a href="<?php echo base_url()?>index.php/admin_file" class="link2">Files Management</a></td>
			    </tr>
            </table>
         </li>
         <li>
            <table>
                <tr>
    				<td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/menu.gif" alt="Menu Management"></td>
    				<td><a href="<?php echo base_url()?>index.php/admin_menu" class="link2">Menu Management</a></td>
    			</tr>
            </table>
         </li>
         <li>
            <table>
                <tr>
                    <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/group.gif" alt="Group List Management"></td>
				    <td><a href="<?php echo base_url()?>index.php/admin_group" class="link2">Group List Management</a></td>
                </tr>
            </table>
         </li>
          <li>
            <table>
                <tr>
                    <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/role.gif" alt="Group Role"></td>
				    <td><a href="<?php echo base_url()?>index.php/admin_role" class="link2">Group Role</a></td>
                </tr>
            </table>
         </li>
          <li>
            <table>
                <tr>
                    <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/config.gif" alt="Setting Configuration"></td>
				    <td><a href="<?php echo base_url()?>index.php/admin_config" class="link2">Setting Configuration</a></td>
                </tr>
            </table>
         </li>
         <li>
            <table>
                <tr>
                    <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/contact.gif" alt="Contact Information"></td>
				    <td><a href="<?php echo base_url()?>index.php/admin_contact" class="link2">Contact Information</a></td>
                </tr>
            </table>
         </li>
      </ul>
    </div>
    <div>
      <div style='margin-top: 2px;'>
          <div style='margin-left: 4px; float: left;'>Master Data</div>
      </div>
    </div>
    <div>
        <ul>
            <li>
                <table>
                    <tr>
                        <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/content.gif" alt="Menu"></td>
				        <td><a href="<?php echo base_url()?>index.php/admin_master_subdit" class="link2">Subdit</a></td>
                    </tr>
                </table>
            </li>
            <li>
                <table>
                    <tr>
                        <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/content.gif" alt="Menu"></td>
				        <td><a href="<?php echo base_url()?>index.php/admin_master_departemen" class="link2">Departemen</a></td>
                    </tr>
                </table>
            </li>
			<li>
                <table>
                    <tr>
                        <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/content.gif" alt="Menu"></td>
				        <td><a href="<?php echo base_url()?>index.php/admin_master_pendidikan" class="link2">Pendidikan</a></td>
                    </tr>
                </table>
				
            </li>
			<li>
                <table>
                    <tr>
                        <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/content.gif" alt="Menu"></td>
				        <td><a href="<?php echo base_url()?>index.php/admin_agama" class="link2">Agama</a></td>
                    </tr>
                </table>
				
            </li>
			<li>
                <table>
                    <tr>
                        <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/content.gif" alt="Menu"></td>
				        <td><a href="<?php echo base_url()?>index.php/admin_master_jabatan" class="link2">Jabatan</a></td>
                    </tr>
                </table>
				
            </li>
			<li>
                <table>
                    <tr>
                        <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/content.gif" alt="Menu"></td>
				        <td><a href="<?php echo base_url()?>index.php/admin_master_jenjang_jabatan" class="link2">Jenjang Jabatan</a></td>
                    </tr>
                </table>
				
            </li>
			<li>
                <table>
                    <tr>
                        <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/content.gif" alt="Menu"></td>
				        <td><a href="<?php echo base_url()?>index.php/admin_master_golongan" class="link2">Golongan</a></td>
                    </tr>
                </table>
				
            </li>
			<li>
                <table>
                    <tr>
                        <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/content.gif" alt="Menu"></td>
				        <td><a href="<?php echo base_url()?>index.php/admin_master_keluarga" class="link2">Keluarga</a></td>
                    </tr>
                </table>
			</li>
            <li>
                <table>
                    <tr>
                        <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/content.gif" alt="Menu"></td>
				        <td><a href="<?php echo base_url()?>index.php/admin_master_status_pernikahan" class="link2">Status Pernikahan</a></td>
                    </tr>
                </table>
			</li>
            <li>
                <table>
                    <tr>
                        <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/content.gif" alt="Menu"></td>
				        <td><a href="<?php echo base_url()?>index.php/admin_master_jenis_anggaran" class="link2">Jenis Anggaran</a></td>
                    </tr>
                </table>
			</li>
        </ul>
    </div>
<!--    <div>
      <div style='margin-top: 2px;'>
          <div style='margin-left: 4px; float: left;'>Master Data Industri</div>
      </div>
    </div>
    <div>
        <ul>
            <li>
                <table>
                    <tr>
                      <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/content.gif" alt="Menu"></td>
				      <td><a href="<?php echo base_url()?>index.php/admin_master_fasilitas" class="link2">Fasilitas Industri</a></td>
                    </tr>
                </table>
            </li>
            <li>
                <table>
                    <tr>
                       <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/content.gif" alt="Menu"></td>
				       <td><a href="<?php echo base_url()?>index.php/admin_master_jnsindustri" class="link2">Jenis Industri</a></td>
                    </tr>
                </table>
            </li>
            <li>
                <table>
                    <tr>
                       <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/content.gif" alt="Menu"></td>
				       <td><a href="<?php echo base_url()?>index.php/admin_master_statusindustri" class="link2">Status Industri</a></td>
                    </tr>
                </table>
            </li>
            <li>
                <table>
                    <tr>
                       <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/content.gif" alt="Menu"></td>
				       <td><a href="<?php echo base_url()?>index.php/admin_master_bentukusaha" class="link2">Bentuk Perusahaan</a></td>
                    </tr>
                </table>
            </li>
            <li>
                <table>
                    <tr>
                       <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/content.gif" alt="Menu"></td>
				       <td><a href="<?php echo base_url()?>index.php/admin_master_izin" class="link2">Izin</a></td>
                    </tr>
                </table>
            </li>
            <li>
                <table>
                    <tr>
                       <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/content.gif" alt="Menu"></td>
				       <td><a href="<?php echo base_url()?>index.php/admin_master_lokasiindustri" class="link2">Lokasi Industri</a></td>
                    </tr>
                </table>
            </li>
        </ul>
    </div>
-->    
	<div>
      <div style='margin-top: 2px;'>
          <div style='margin-left: 4px; float: left;'>Master Data Lokasi</div>
      </div>
    </div>
    <div>
        <ul>
            <li>
                <table>
                    <tr>
                       <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/content.gif" alt="Menu"></td>
				       <td><a href="<?php echo base_url()?>index.php/admin_master_propinsi" class="link2">Propinsi</a></td>
                    </tr>
                </table>
            </li>
            <li>
                <table>
                    <tr>
                       <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/content.gif" alt="Menu"></td>
				       <td><a href="<?php echo base_url()?>index.php/admin_master_kota" class="link2">Kota</a></td>
                    </tr>
                </table>
            </li>
            <li>
                <table>
                    <tr>
                       <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/content.gif" alt="Menu"></td>
				       <td><a href="<?php echo base_url()?>index.php/admin_master_kecamatan" class="link2">Kecamatan</a></td>
                    </tr>
                </table>
            </li>
            <li>
                <table>
                    <tr>
                       <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/content.gif" alt="Menu"></td>
				       <td><a href="<?php echo base_url()?>index.php/admin_master_desa" class="link2">Desa</a></td>
                    </tr>
                </table>
            </li>
        </ul>
    </div>
	<div>
      <div style='margin-top: 2px;'>
          <div style='margin-left: 4px; float: left;'>Account</div>
      </div>
    </div>
    <div>
        <ul>
            <li>
                <table>
                    <tr>
                      	<td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/password.gif" alt="Change Password"></td>
				        <td><a href="<?php echo base_url()?>index.php/admin_user/edit_account/<?php echo $this->session->userdata('id');?>" class="link2">Change Password</a></td>
			        </tr>
                </table>
            </li>
            <li>
                <table>
                    <tr>
                       <td><img width=24 height=24 src="<?php echo base_url()?>public/themes/admin/images/logout.gif" alt="Logout"></td>
				       <td><a href="<?php echo base_url()?>index.php/admin/logout" class="link2">Logout</a></td>
                    </tr>
                </table>
            </li>
        </ul>
    </div>
</div>
    <div style="background:#444444;color:#DDDDDD;font-size:11px;padding:5px;">
	Web address: <br><div style="padding-left:20px;padding-bottom:5px"><?php echo base_url();?></div>
	Server : <br><div style="padding-left:20px;padding-bottom:5px"><?php echo $_SERVER['SERVER_ADDR'];?><br><?php echo $_SERVER['SERVER_SIGNATURE'];?></div>
	Remote IP: <br><div style="padding-left:20px;padding-bottom:5px"><?php echo $_SERVER['REMOTE_ADDR'];?></div>
	User agent : <br><div style="padding-left:20px;padding-bottom:5px"><?php echo $_SERVER['HTTP_USER_AGENT'];?></div>
	</div>
