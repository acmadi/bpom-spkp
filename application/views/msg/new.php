<script>
	$(function() {
		$("#participant").fcbkcomplete({
			json_url: "<?php echo base_url()?>index.php/msg/get_userlist",
			addontab: true,                   
			maxitems: 20,
			height: 10,
            width: 165,
			cache: true,
			filter_selected: true,
			filter_case: false
		});

		$('#btn_save').click(function(){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/msg/do{act}/",
				data: $('#frmMsg').serialize() + tinyMCE.get('mmessage').getContent(),
				success: function(response){
					 if(response>0){
						 $.notific8('Notification', {
						  life: 3000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});

						$('#frmMsg')[0].reset();
						get_message(response);

					 }else{
						 $.notific8('Notification', {
						  life: 5000,
						  message: response,
						  heading: 'Saving data FAIL',
						  theme: 'red2'
						});
					 }
				}
			 }); 		
		});
	});
</script>
<table width="100%" cellspacing="2" cellpadding="2" style="background:#FFFFFF;border-bottom:1px solid #DDDDDD" border='0'>
	<tr height="25">
		<td width="12%" style="padding-left:15px">Subject</td>
		<td width="1%">:</td>
		<td>
			 <input type="text" class="input2" id="msubject" name="msubject" style="border: 0px;margin: 0;height: 25px;width: 100%">
		</td>
	</tr>
	<tr height="25">
		<td style="padding-left:15px" valign='top'>To</td>
		<td width="1%" valign='top'>:</td>
		<td>
			 <select class="input2" id="participant" name="participant"></select>
		</td>
	</tr>
</table>
