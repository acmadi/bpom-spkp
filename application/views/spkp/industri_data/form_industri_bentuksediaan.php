<script>
	$(document).ready(function(){
		$('#flexmaster_sediaan').flexigrid({
			url: '<?php echo base_url();?>index.php/industri_master/json_bentuksediaan/{id}/{id_plant}/{id_jenis}',
			dataType: 'json',
			colModel : [
				{display: 'Proses', name : 'PROSES', width : 60, sortable : false, align: 'center'},
				{display: 'No', name : 'bentuk_sediaan', width : 60, sortable : false, align: 'center'},
				{display: 'Nama Bentuk Sediaan', name : 'nama_sediaan', width : 200, sortable : true, align: 'left'},
				{display: 'Kapasitas Produksi', name : 'kap_prod_pertahun', width : 150, sortable : true, align: 'center'},
				{display: 'Mesin Peralatan', name : 'mesin_peralatan', width : 150, sortable : true, align: 'center'},
				{display: 'Rencana Produksi', name : 'rencana_prod', width : 150, sortable : true, align: 'center'}
			],
			searchitems : [
				{display: 'Nama Bentuk Sediaan', name : 'nama_sediaan', isdefault: true},
				{display: 'Kapasitas Produksi', name : 'kap_prod_pertahun'},
				{display: 'Mesin Peralatan', name : 'mesin_peralatan'},
				{display: 'Rencana Produksi', name : 'rencana_prod'}
			],
			usepager: true,
			rp: 15,
			rpOptions: [10,15,20,25,40],
			sortname: 'bentuk_sediaan',
			sortorder: 'asc',
			showTableToggleBtn: false,
			singleSelect:true,
			width: '865',
			height: 150
		});
		$('.sDiv').css('display','block');
		var popup = $('#popup');
		$('.sDiv',popup).append("<div style='float:right;position:relative;padding-right:15px;padding-top:25px'><button class='btn' id='btn_tambah_jenis'>+ Tambah Data</button></div>");

		var sDiv = $('.sDiv');
		$('#btn_tambah_jenis',sDiv).click(function(){
			$.get("<?php echo base_url();?>index.php/industri_master/add_bentuksediaan/{id}/{id_plant}/{id_jenis}" , function(response) {
				$("#popup_sediaan").empty();
				$("#popup_sediaan").html("<div>"+response+"</div>");
				$("#popup_sediaan").dialog({
					width: 600,
					height: 420,
					show: "blind",
					modal: true
				});
			});
		});
	});

	$("#popup_sediaan").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");

	function close_bentuksediaan(){
		var sDiv = $('.sDiv');
		$("#popup_sediaan").dialog("close");
		$("input[name='bcari']",sDiv).click();
	}

	function edit_bentuksediaan(id_sediaan,id_plant,id_jenis){
		$.get("<?php echo base_url();?>index.php/industri_master/edit_bentuksediaan/{id}/"+id_sediaan+"/"+id_plant+"/"+id_jenis , function(response) {
			$("#popup_sediaan").empty();
			$("#popup_sediaan").html("<div>"+response+"</div>");
			$("#popup_sediaan").dialog({
				width: 600,
				height: 420,
				show: "blind",
				modal: true
			});
		});
	}

	function dodel_bentuksediaan(id_sediaan,id_plant,id_jenis){
		if(confirm("Anda yakin akan menghapus data ("+id_sediaan+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/industri_master/dodel_bentuksediaan/{id}/"+id_sediaan+"/"+id_plant,
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
	<table width="100%">
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="5" class="panel">
					<tr>
						<td>
						<table border="0" cellpadding="3" cellspacing="2">
							<tr>
								<td>Pabrik</td>
								<td>:</td>
								<td><?php
										echo $pabrik['alamat_pabrik']." - ".$pabrik['nama_kota'].", ".$pabrik['nama_propinsi'];
								?> 
								</td> 
							</tr>
							<tr>
								<td>Jenis</td>
								<td>:</td>
								<td><?php
										echo $jenis['nama_jenis']." - ".$jenis['nama_jenis2'];
								?> 
								</td> 
							</tr>
							<tr>
								<td>Penanggung Jawab</td>
								<td>:</td>
								<td><?php echo $penanggungjawab." ,".$pend_penanggungjawab ." (".$stra_penanggungjawab.")"; ?>
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
				<div style="display:none" id="popup_sediaan"></div>
				<div style="margin:0px;"><table id="flexmaster_sediaan"></table></div>
			</td>
		</tr>
	</table>
</div>

