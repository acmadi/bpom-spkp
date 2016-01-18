<script>
	$(document).ready(function(){
		$('#flexmaster').flexigrid({
			url: '<?php echo base_url();?>index.php/industri_master/json_kantor/{id}',
			dataType: 'json',
			colModel : [
				{display: 'Proses', name : 'PROSES', width : 60, sortable : false, align: 'center'},
				{display: 'No', name : 'id_kantor', width : 60, sortable : true, align: 'left'},
				{display: 'Alamat', name : 'alamat_kantor', width : 450, sortable : true, align: 'left'},
				{display: 'Telp', name : 'telp_kantor', width : 150, sortable : true, align: 'center'},
				{display: 'Fax', name : 'fax_kantor', width : 150, sortable : true, align: 'center'},
				{display: 'Kodepos', name : 'kodepos', width : 150, sortable : true, align: 'center'}
			],
			searchitems : [
				{display: 'Alamat', name : 'alamat_kantor', isdefault: true},
				{display: 'Telp', name : 'telp_kantor'},
				{display: 'Fax', name : 'fax_kantor'},
				{display: 'Kodepos', name : 'kodepos'}
			],
			usepager: true,
			rp: 15,
			rpOptions: [10,15,20,25,40],
			sortname: 'id_kantor',
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
			$.get("<?php echo base_url();?>index.php/industri_master/add_kantor/{id}" , function(response) {
				$("#popup").empty();
				$("#popup").html("<div>"+response+"</div>");
				$("#popup").dialog({
					width: 600,
					height: 500,
					show: "blind",
					modal: true
				});
			});
		});
	});

	$("#popup").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");

	function edit_kantor(id){
		$.get("<?php echo base_url();?>index.php/industri_master/edit_kantor/{id}/"+id , function(response) {
			$("#popup").empty();
			$("#popup").html("<div>"+response+"</div>");
			$("#popup").dialog({
				width: 600,
				height: 500,
				show: "blind",
				modal: true
			});
		});
	}

	function dodel_kantor(id){
		if(confirm("Anda yakin akan menghapus data ("+id+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/industri_master/dodel_kantor/{id}/"+id,
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
