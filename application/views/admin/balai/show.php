<script>
	$(function(){

		$('#flexmaster').flexigrid({
			url: 'admin_master_balai/json',
			dataType: 'json',
			colModel : [
				{display: 'Proses', name : 'PROSES', width : 50, sortable : false, align: 'center'},
				{display: 'ID Balai', name : 'id_balai', width : 50, sortable : true, align: 'left'},
				{display: 'Nama Balai', name : 'nama_balai', width : 230, sortable : true, align: 'left'},
				{display: 'Alamat', name : 'alamat', width : 300, sortable : true, align: 'left'},
				{display: 'Kode Pos', name : 'kd_pos', width : 60, sortable : true, align: 'center'},
				{display: 'Email', name : 'email', width : 180, sortable : true, align: 'left'}
			],
			searchitems : [
				{display: 'ID Balai', name : 'id_balai', isdefault: true},
				{display: 'Nama Balai', name : 'nama_balai'},
				{display: 'Alamat', name : 'alamat'},
				{display: 'Kode Pos', name : 'kd_pos'},
				{display: 'Email', name : 'email'},
			],
			usepager: true,
			rp: 15,
			rpOptions: [10,15,20,25,40],
			sortname: 'id_balai',
			sortorder: 'asc',
			showTableToggleBtn: false,
			singleSelect:true,
			width: '965',
			height: 344
		});
		$('.sDiv').css('display','block');
		$('.sDiv').append("<div style='float:right;position:relative;padding-right:15px;padding-top:25px'><button class='btn' id='btn_tambah'>+ Tambah Data</button></div>");

		var sDiv = $('.sDiv');
		$('#btn_tambah',sDiv).click(function(){
			$("#popup").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			$("#popup").dialog({
				width: 700,
				height: 550,
				show: "blind",
				modal: true
			});
			$.get("<?php echo base_url();?>index.php/admin_master_balai/add" , function(response) {
				$("#popup").html("<div>"+response+"</div>");
			});
		});
	});


	function save_add_dialog(content){
		$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/admin_master_balai/doadd",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_dialog();
					 var sDiv = $('.sDiv');
					 $('input[value=Clear]',sDiv).click();
					 $.notific8('Notification', {
					  life: 5000,
					  message: 'Save data succesfully.',
					  heading: 'Saving data',
					  theme: 'lime'
					});
				 }else{
					 $.notific8('Notification', {
					  life: 5000,
					  message: response,
					  heading: 'Saving data FAIL',
					  theme: 'red'
					});
				 }
			}
		 }); 		
	}

	function edit(id){
		$("#popup").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		$("#popup").dialog({
			width: 700,
			height: 550,
			show: "blind",
			modal: true
		});
		$.get("<?php echo base_url();?>index.php/admin_master_balai/edit/"+id , function(response) {
			$("#popup").html("<div>"+response+"</div>");
		});
	}

	function save_edit_dialog(content){
		$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/admin_master_balai/doedit",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_dialog();
					 var sDiv = $('.sDiv');
					 $('input[value=Clear]',sDiv).click();
					 $.notific8('Notification', {
					  life: 5000,
					  message: 'Save data succesfully.',
					  heading: 'Saving data',
					  theme: 'lime'
					});
				 }else{
					 $.notific8('Notification', {
					  life: 5000,
					  message: response,
					  heading: 'Saving data FAIL',
					  theme: 'red'
					});
				 }
			}
		 }); 		
	}


	function dodel(id){
		if(confirm("Anda yakin akan menghapus data ("+id+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/admin_master_balai/dodel/"+id,
				success: function(response){
					 if(response=="1"){
						 var sDiv = $('.sDiv');
						 $('input[value=Clear]',sDiv).click();
						 $.notific8('Notification', {
						  life: 5000,
						  message: 'Delete data succesfully.',
						  heading: 'Delete data',
						  theme: 'lime'
						});
					 }else{
						 $.notific8('Notification', {
						  life: 5000,
						  message: response,
						  heading: 'Delete data FAIL',
						  theme: 'red'
						});
					 }
				}
			 }); 		
		}
	}

	function close_dialog(){
		$("#popup").dialog("close");
	}
</script>
<div style="display:none" id="popup">{popup}</div>
<div style="padding:8px">
	<div style="width:98%;height:30px;font-size:20px;">
		. {title}
	</div>
	<br>
	<div style="width:98%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
		<div style="margin:0px;"><table id="flexmaster"></table></div>
	</div>
	<br>
	<br>
	<br>
</div>