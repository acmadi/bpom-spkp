<script type="text/javascript">
    $(document).ready(function(){
        
        $("input[type='text']").jqxInput({ theme: 'fresh', height: '22px', width: '90%'}); 
        

		$("[name='btn_simpan']").click(function(){
			$("#uploaddiv").hide();
			$("#uploadloader").show("fade");

			var data = new FormData();	
			data.append('id_subdit', $("[name='id_subdit']").val());
			data.append('kategori_parent', $("[name='kategori_parent']").val());
			<?php if(isset($subkategori)&&$subkategori=="subkategori"){?>
			data.append('id_ketegori', $("[name='id_ketegori']").val());

			<?php }else{ ?>
				data.append('id_ketegori', 0);
			<?php } ?>
			$.ajax({ 
				type: "POST",
				cache: false,
				contentType: false,
				processData: false,
				url: "<?php echo base_url()?>srikandi_kategori/do{action}_kategori/{id_subdit}",
				data: data,
				success: function(response){
					res = response.split("_");
					 if(res[0]=="OK"){
						 $.notific8('Notification', {
						  life: 5000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
						$("#filename").val("");
						close_dialog_kategori(1);
					 }else{
						 $.notific8('Notification', {
						  life: 5000,
						  message: res[1],
						  heading: 'Saving data FAIL',
						  theme: 'red2'
						});
					 }
					$("#uploadloader").hide();
					$("#uploaddiv").show("fade");
				}
			 }); 		
		});

		$("[name='btn_delete']").click(function(){
			if(confirm('Hapus dokumen ini?')){
			
				$("#uploaddiv").hide();
				$("#uploadloader").show("fade");

				$.ajax({ 
					type: "POST",
					cache: false,
					contentType: false,
					processData: false,
					url: "<?php echo base_url()?>srikandi/delete_upload/{id_srikandi}",
					success: function(response){
						res = response.split("_");
						 if(res[0]=="OK"){
							 $.notific8('Notification', {
							  life: 5000,
							  message: 'Save data succesfully.',
							  heading: 'Saving data',
							  theme: 'lime2'
							});
							close_dialog_kategori(1);
						 }else{
							 $.notific8('Notification', {
							  life: 5000,
							  message: res[1],
							  heading: 'Saving data FAIL',
							  theme: 'red2'
							});
						 }
						$("#uploadloader").hide();
						$("#uploaddiv").show("fade");
					}
				 }); 
			}				 
		});

	});
</script>
<div id="uploadloader" style='display:none;text-align:center'><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>uploading<br><br><br><br></div>
<div id="uploaddiv" style="padding:5px;text-align:center">
<form method="POST" id="frmData">
	<?php if($action=="edit"){ ?><button type="button" class="btn btn-default" name="btn_delete"><i class="icon-remove"></i> Delete Data </button> - <?php } ?>
	<button type="button" class="btn btn-default" name="btn_simpan"><i class="icon-plus"></i> Simpan </button>
	<button type="reset"class="btn btn-default" ><i class="icon-repeat"></i> Ulang </button>
	<button type="button" onCLick="close_dialog_kategori();"class="btn btn-default" > <i class="icon-minus-sign"></i>Batal </button>
	<br />
	<br />
	<table border="0" cellpadding="0" cellspacing="8" align="center" width='90%'>
		<tr>
			<td>
                <table border="0" cellpadding="3" cellspacing="2" width='100%'>
                	<tr>
						<td>Sub Dit</td>
						<td>:</td>
						<td>
							{option_subdit} *
						</td>
					</tr>
					<?php if(isset($subkategori)&&$subkategori=="subkategori"){?>
					<tr>
						<td width="30%">Kategori </td>
						<td>:</td>
						<td>
                            {option_kategori} *
						</td>
					</tr>
					<tr>
						<td width="30%">Sub Kategori </td>
						<td>:</td>
						<td>
                            <input type="text" size="40" maxlength="100" name="kategori_parent" id="kategori_parent" value="<?php 
								if(set_value('kategori_parent')=="" && isset($kategori_parent)){
								 	echo $kategori_parent;
								}else{
									echo  set_value('kategori_parent');
								}
								 ?>"
								style="height:25px;padding:2px;margin: 0;width:92%" /> *
						</td>
					</tr>
					<?php }else{ ?>
					<tr>
						<td width="30%">Kategori </td>
						<td>:</td>
						<td>
                            <input type="text" size="40" maxlength="100" name="kategori_parent" id="kategori_parent" value="<?php 
								if(set_value('kategori_parent')=="" && isset($kategori_parent)){
								 	echo $kategori_parent;
								}else{
									echo  set_value('kategori_parent');
								}
								 ?>"
								style="height:25px;padding:2px;margin: 0;width:92%" /> *
						</td>
					</tr>
					<?php } ?>
				</table>
			</td>
		</tr>
	</table>
</form>
</div>