<?php
if(isset($data_comment)){
	foreach($data_comment as $rows){
?>
<div class="msg-time-chat">
	 <div class="message-img"><img src="<?php echo base_url(); ?>media/images/user/<?php echo $rows->image; ?>" alt="" class="avatar"/></div>
	 <div class="message-body msg-out">
		 <span class="arrow"></span>
		 <div class="text">
			 <p class="attribution">by <?php echo $rows->username; ?>, <?php echo date("d-m-Y H:i:s",$rows->update); ?><button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="deletecom(<?php echo $rows->id_comment?>)">×</button></p>
				<a href="<?php // echo base_url()spkp/detail/announcement/ ?>#">
					<b><?php echo $rows->komentar; ?></b>
				</a>
			</p>
		 </div>
	 </div>
 </div>
<?php
	} 
}
?>

<script type="text/javascript">
	function deletecom(id){
			if(confirm('Hapus komentar ini?')){
				$.ajax({ 
					type: "POST",
					cache: false,
					contentType: false,
					processData: false,
					url: "<?php echo base_url()?>srikandi/delete_komentar/"+id,
					success: function(response){
						timeline_comment();
					}
				 }); 
			}		
	}
</script>