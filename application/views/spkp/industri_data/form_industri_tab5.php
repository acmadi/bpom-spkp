<script>
	$(document).ready(function(){
		$('#flexmaster').flexigrid({
			url: '<?php echo base_url();?>index.php/industri_master/json_pabrik_bentuksediaan/{id}',
			dataType: 'json',
			colModel : [
				{display: 'Detail', name : 'Detail', width : 50, sortable : false, align: 'center'},
				{display: 'No', name : 'a.id_plant', width : 50, sortable : false, align: 'center'},
				{display: 'Pabrik', name : 'alamat_pabrik', width : 250, sortable : true, align: 'left'},
				{display: 'Jenis', name : 'jenis', width : 250, sortable : true, align: 'left'},
				{display: 'Bentuk Sediaan', name : 'jenis', width : 400, sortable : true, align: 'center'},
				{display: 'Jumlah', name : 'jenis', width : 100, sortable : true, align: 'center'}
			],
			searchitems : [
				{display: 'Pabrik', name : 'alamat_pabrik', isdefault: true},
				{display: 'Jenis', name : 'jenis'},
				{display: 'Bentuk Sediaan', name : 'jenis'},
				{display: 'Jumlah', name : 'jenis'}
			],
			usepager: true,
			rp: 15,
			rpOptions: [10,15,20,25,40],
			sortname: 'a.id_plant',
			sortorder: 'asc',
			showTableToggleBtn: false,
			singleSelect:true,
			width: '90%',
			height: 250
		});
		$('.sDiv').css('display','block');

	});

	$("#popup").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");

	function edit_jenis(id_plant,id_jenis){
		$.get("<?php echo base_url();?>index.php/industri_master/edit_jenissediaan/{id}/"+id_plant+"/"+id_jenis , function(response) {
			$("#popup").empty();
			$("#popup").html("<div>"+response+"</div>");
			$("#popup").dialog({
				width: 900,
				height: 520,
				show: "blind",
				modal: true
			});
		});
	}

</script>
<div style="display:none" id="popup"></div>
<div style="margin:0px;"><table id="flexmaster"></table></div>

