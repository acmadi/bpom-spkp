<div id="logedin">
	<div style="float:left;position:relative;padding-top:7px;padding-right:5px;padding-left:5px;padding-bottom:6px;background:#FFFFFF;border-radius:5px;"><img src="<?php echo base_url()?>media/images/profile.jpeg" height="50" style="border:0"/></div>
	<div style="float:left;position:relative;font-weight:bold;padding-top:2px;padding-left:5px;width:170px"><?php echo $this->session-> userdata('username')?></div>
	<div style="float:left;position:relative;padding-left:5px;"><?php echo ucfirst($this->session->userdata('level'))?></div>
	<div id="clear">&nbsp;</div>
	<div id="clear">&nbsp;</div>
	<div id="clear">&nbsp;</div>
	<div style="float:left;position:relative;padding:2px;font-weight:bold;">{menu_14}</div>
	<div style="float:left;position:relative;font-weight:bold"><?php echo anchor(base_url()."spkp/profile.bpom"," Profile ","class=link2")?></div>
	<div style="float:left;position:relative;padding-left:5px;">&nbsp;</div>
	<div style="float:left;position:relative;font-weight:bold;"><?php echo anchor(base_url()."spkp/logout.bpom"," Logout ","class=link2")?></div>
</div>
