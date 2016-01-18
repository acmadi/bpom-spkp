<script>
	$(function(){

		$('#flexmaster').flexigrid({
			url: 'admin_master_uraian/json',
			dataType: 'json',
			colModel : [
				{display: 'Proses', name : 'PROSES', width : 50, sortable : false, align: 'center'},
				{display: 'No Uraian', name : 'no_uraian', width : 55, sortable : true, align: 'left'},
				{display: 'Deskripsi', name : 'deskripsi', width : 300, sortable : true, align: 'left'},
				{display: 'Group', name : 'group', width : 60, sortable : true, align: 'left'},
				{display: 'Head', name : 'head', width : 60, sortable : true, align: 'center'}
				
			],
			searchitems : [
				{display: 'No Uraian', name : 'no_uraian', isdefault: true},
				{display: 'Deskripsi', name : 'deskripsi'},
				{display: 'Group', name : 'group'},
				{display: 'Head', name : 'head'},
			
			],
			usepager: true,
			rp: 15,
			rpOptions: [10,15,20,25],
			sortname: 'no_uraian',
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
			$.get("<?php echo base_url();?>index.php/admin_master_uraian/add" , function(response) {
				$("#popup").html("<div>"+response+"</div>");
			});
		});
	});


	function save_add_dialog(content){
		$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/admin_master_uraian/doadd",
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
		$.get("<?php echo base_url();?>index.php/admin_master_uraian/edit/"+id , function(response) {
			$("#popup").html("<div>"+response+"</div>");
		});
	}

	function save_edit_dialog(content){
		$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/admin_master_uraian/doedit",
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
				url: "<?php echo base_url()?>index.php/admin_master_uraian/dodel/"+id,
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