<script>
	$(document).ready(function(){
		$('#flexmaster').flexigrid({
			url: '<?php echo base_url();?>index.php/industri_master/json_izin/{id}',
			dataType: 'json',
			colModel : [
				{display: 'Proses', name : 'PROSES', width : 60, sortable : false, align: 'center'},
				{display: 'No', name : 'id_izin', width : 60, sortable : false, align: 'left'},
				{display: 'Nama Izin', name : 'nama_izin', width : 300, sortable : true, align: 'left'},
				{display: 'Tgl Izin', name : 'tgl_izin', width : 150, sortable : true, align: 'center'},
				{display: 'Tgl Permohonan', name : 'tgl_permohonan', width : 150, sortable : true, align: 'center'},
				{display: 'Nomor', name : 'nomor', width : 250, sortable : true, align: 'center'}
			],
			searchitems : [
				{display: 'Nama Izin', name : 'nama', isdefault: true},
				{display: 'Tgl Izin', name : 'tgl_izin'},
				{display: 'Tgl Permohonan', name : 'tgl_permohonan'},
				{display: 'Tgl Permohonan', name : 'nomor'}
			],
			usepager: true,
			rp: 15,
			rpOptions: [10,15,20,25,40],
			sortname: 'id_izin',
			sortorder: 'asc',
			showTableToggleBtn: false,
			singleSelect:true,
			width: '90%',
			height: 250
		});
		$('.sDiv').css('display','block');
		$('.sDiv').append("<div style='float:right;position:relative;padding-right:15px;padding-top:25px'><button class='btn' id='btn_tambah'>+ Tambah Data</button></div>");

		var sDiv = $('.sDiv');
		$('#btn_tambah',sDiv).click(function(){
			$.get("<?php echo base_url();?>index.php/industri_master/add_izin/{id}" , function(response) {
				$("#popup").empty();
				$("#popup").html("<div>"+response+"</div>");
				$("#popup").dialog({
					width: 600,
					height: 350,
					show: "blind",
					modal: true
				});
				var pop = $("#popup");
				$("#tgl_izin",pop).datepicker({ dateFormat: "yy-mm-dd" });
				$("#tgl_permohonan",pop).datepicker({ dateFormat: "yy-mm-dd" });

			});
		});
	});

	$("#popup").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");

	function edit_izin(id){
		$.get("<?php echo base_url();?>index.php/industri_master/edit_izin/{id}/"+id , function(response) {
			$("#popup").empty();
			$("#popup").html("<div>"+response+"</div>");
			$("#popup").dialog({
				width: 600,
				height: 350,
				show: "blind",
				modal: true
			});
			$("#tgl_izin",pop).datepicker({ dateFormat: "yy-mm-dd" });
			$("#tgl_permohonan",pop).datepicker({ dateFormat: "yy-mm-dd" });

		});
	}

	function dodel_izin(id){
		if(confirm("Anda yakin akan menghapus data ("+id+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/industri_master/dodel_izin/{id}/"+id,
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
<div style="display:none" id="popup"></div>
<div style="margin:0px;"><table id="flexmaster"></table></div>

