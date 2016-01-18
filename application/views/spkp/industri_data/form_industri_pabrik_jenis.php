<script>
	$(document).ready(function(){
		$('#flexmaster_jenis').flexigrid({
			url: '<?php echo base_url();?>index.php/industri_master/json_pabrik_jenis/{id}/{id_plant}',
			dataType: 'json',
			colModel : [
				{display: 'Proses', name : 'PROSES', width : 60, sortable : false, align: 'center'},
				{display: 'No', name : 'id_jenis', width : 60, sortable : true, align: 'center'},
				{display: 'Jenis', name : 'jenis', width : 200, sortable : true, align: 'left'},
				{display: 'Penanggung Jawab', name : 'penanggungjawab', width : 160, sortable : true, align: 'center'},
				{display: 'Pendidikan', name : 'pend_penanggungjawab', width : 160, sortable : true, align: 'center'},
				{display: 'Strata', name : 'stra_penanggungjawab', width : 100, sortable : true, align: 'center'}
			],
			searchitems : [
				{display: 'Jenis', name : 'b.nama_jenis2', isdefault: true},
				{display: 'Penanggung Jawab', name : 'penanggungjawab'}
			],
			usepager: true,
			rp: 15,
			rpOptions: [10,15,20,25,40],
			sortname: 'id_jenis',
			sortorder: 'asc',
			showTableToggleBtn: false,
			singleSelect:true,
			width: 860,
			height: 200
		});
		$('.sDiv').css('display','block');
		var popup = $('#popup');
		$('.sDiv',popup).append("<div style='float:right;position:relative;padding-right:15px;padding-top:25px'><button class='btn' id='btn_tambah_jenis'>+ Tambah Data</button></div>");

		var sDiv = $('.sDiv');
		$('#btn_tambah_jenis',sDiv).click(function(){
			$.get("<?php echo base_url();?>index.php/industri_master/add_jenis/{id}/{id_plant}" , function(response) {
				$("#popup_jenis").empty();
				$("#popup_jenis").html("<div>"+response+"</div>");
				$("#popup_jenis").dialog({
					width: 600,
					height: 360,
					show: "blind",
					modal: true
				});
			});
		});
	});

	$("#popup_jenis").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");

	function close_jenis(){
		var sDiv = $('.sDiv');
		$("#popup_jenis").dialog("close");
		$("input[name='bcari']",sDiv).click();
	}

	function edit_jenis(id_plant,id_jenis){
		$.get("<?php echo base_url();?>index.php/industri_master/edit_jenis/{id}/"+id_plant+"/"+id_jenis , function(response) {
			$("#popup_jenis").empty();
			$("#popup_jenis").html("<div>"+response+"</div>");
			$("#popup_jenis").dialog({
				width: 600,
				height: 360,
				show: "blind",
				modal: true
			});
		});
	}

	function dodel_jenis(id_plant,id_jenis){
		if(confirm("Anda yakin akan menghapus data ("+id_jenis+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/industri_master/dodel_jenis/{id}/"+id_plant+"/"+id_jenis,
				success: function(response){
					 if(response=="1"){
						 var sDiv = $('.sDiv');
						 $('input[value=Clear]',sDiv).click();
						 $.notific8('Notification', {
						  life: 5000,
						  message: 'Delete data succesfully.',
						  heading: 'Delete data',
						  theme: 'lime2'
						});
					 }else{
						 $.notific8('Notification', {
						  life: 5000,
						  message: response,
						  heading: 'Delete data FAIL',
						  theme: 'red2'
						});
					 }
				}
			 }); 		
		}
	}
</script>
<div style="width:99%;background-color:#F6F6F6;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #F9F9F9;height:40px">
	<table width='100%' cellpadding=0 cellspacing=0 height='100%'>
		<tr valign="middle">
			<td style='background:#FFFFFF;-moz-border-radius:5px 0px 0px 5px;border-radius:5px 0px 0px 5px;padding-left:5px;font-size:15px;color:#585858;font-weight:bold'>
				. {title}
			</td>
		</tr>
	</table>
</div>
<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
	<table width="100%" >
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="5" class="panel">
					<tr>
						<td>
						<table border="0" cellpadding="3" cellspacing="2">
							<tr>
								<td width="20%">ID Pabrik</td>
								<td width="2%">:</td>
								<td><?php  echo $id_plant; ?>
								</td>
							</tr>
							<tr>
								<td>Alamat</td>
								<td>:</td>
								<td><?php 
										if(set_value('alamat_pabrik')=="" && isset($alamat_pabrik)){
											echo $alamat_pabrik;
										}else{
											echo  set_value('alamat_pabrik');
										}
										 ?>
								</td>
							</tr>
							</table>
							</td> 
						</tr>
					</table>
			</td>
		</tr>
		<tr>
			<td>
			<div style="display:none" id="popup_jenis"></div>
			<div style="margin:0px;"><table id="flexmaster_jenis"></table></div>
			</td>
		</tr>
	</table>
</div>