<?php
if(isset($data_comment)){
	foreach($data_comment as $rows){
?>
<div class="msg-time-chat">
	 <div class="message-img"><img src="<?php echo base_url(); ?>media/images/user/" alt="" class="avatar"/></div>
	 <div class="message-body msg-out">
		 <span class="arrow"></span>
		 <div class="text">
			 <p class="attribution">by admin, 2012-12-12 12:12:12</p>
			 <p>
				<a href="<?php echo base_url() ?>spkp/detail/announcement/#">
					<b>komentar anda disini</b>
				</a>
			</p>
		 </div>
	 </div>
 </div>
<?php
	} 
}
?>