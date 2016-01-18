<?php
$this->db->select(array('image','nama'));
$query = $this->db->get_where('app_users_profile', array('id'=>$this->session->userdata('id')));
$data = $query->row_array();
?>
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <img src="<?php echo base_url(); ?>spkp/get_small_profile/1/0" height="29" width="29"/>
    <span class="username"><?php echo $data['nama']; ?></span>
   <b class="caret"></b>
</a>
<ul class="dropdown-menu extended logout">
   <li><a href="<?php echo base_url(); ?>index.php/spkp/edit_profile"><i class="icon-user"></i> My Profile</a></li>
   <li><a href="<?php echo base_url(); ?>index.php/spkp/logout"><i class="icon-key"></i> Log Out</a></li>
</ul>