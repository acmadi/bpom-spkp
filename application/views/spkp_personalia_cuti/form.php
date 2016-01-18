<script>
	$(function(){
       $("#bar_personalia").click();
	   $('#btn_tambah, #clearfilteringbutton, #refreshdatabutton, #printbutton, #excelbutton, #backbutton').jqxButton({ height: 25, theme: theme });

	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'urut'},
			{ name: 'waktu', type: 'date' },
			{ name: 'waktu_update', type: 'date' },
			{ name: 'id', type: 'number' },
			{ name: 'uploader', type: 'number' },
			{ name: 'username', type: 'string' },
			{ name: 'judul', type: 'string' },
			{ name: 'keterangan', type: 'string' },
			{ name: 'filename',  type: 'string' }
        ],
		url: "<?php echo base_url(); ?>spkp_personalia_cuti/json_sasaran/{id}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgrid").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid").jqxGrid('updatebounddata', 'sort');
		},
		root: 'Rows',
        pagesize: 10,
        beforeprocessing: function(data){		
			if (data != null){
				source.totalrecords = data[0].TotalRows;					
			}
		}
		};		
		var dataadapter = new $.jqx.dataAdapter(source, {
			loadError: function(xhr, status, error){
				alert(error);
			}
		});
     
		$("#jqxgrid").jqxGrid(
		{		
			width: '100%',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: true, pagesizeoptions: ['10', '25', '50', '100', '200'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: '#', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
					 if(dataRecord.uploader=='<?php echo $this->session->userdata('id')?>' ||  dataRecord.uid=='<?php echo $this->session->userdata('id')?>'){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit("+dataRecord.id+");'></a> <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/download.gif' onclick='download("+dataRecord.id+");'></a></div>";
					 }else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/download.gif' onclick='download("+dataRecord.id+");'></a></div>";
					 }
                 }
                },
				//Kolom No otomatis menampilkan filed 'urut' hasil query crud->jqxGrid, gunakan format ini untuk mencegah error filter data
				{ text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				// END
				{ text: 'Tanggal', datafield: 'waktu', columntype: 'date', filtertype: 'date', cellsformat: 'yyyy/MM/dd HH:mm:ss', width: '14%' },
				{ text: 'Judul', datafield: 'judul', columntype: 'textbox', filtertype: 'textbox', width: '15%' },
				{ text: 'Keterangan', datafield: 'keterangan', columntype: 'textbox', filtertype: 'textbox', width: '25%' },
				{ text: 'File', datafield: 'filename', columntype: 'textbox', filtertype: 'textbox', width: '16%' },
				{ text: 'Uploader', datafield: 'username', filtertype: 'checkedlist', columntype: 'dropdownlist', width: '8%' },
				{ text: 'Update', datafield: 'waktu_update', columntype: 'date', filtertype: 'date', cellsformat: 'yyyy/MM/dd HH:mm:ss', width: '14%' }
            ]
		});
        
		$('#backbutton').click(function () {
			window.location.href="<?php echo base_url()?>spkp_personalia_cuti/";
		});
        
		$('#clearfilteringbutton').click(function () {
			$("#jqxgrid").jqxGrid('clearfilters');
		});
        
 		$('#refreshdatabutton').click(function () {
			$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
		});

	   $('#btn_tambah').click(function(){
			$("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $("#jqxgrid").offset();
			$("#popup").jqxWindow({
				theme: theme, resizable: true, position: { x: offset.left + 80, y: offset.top-100},
                width: 700,
                height: 250,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_personalia_cuti/add/{uid}" , function(response) {
				$("#popup_content").html("<div>"+response+"</div>");
			});
		});

		$('#printbutton').click(function () {
  			$("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");

			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgrid").jqxGrid('getfilterinformation');
			for (i = 0; i < filter.length; i++) {
				var filters = filter[i];
				var value = filters.filter.getfilters()[0].value;
				var condition = filters.filter.getfilters()[0].condition;
				var operator = filters.filter.getfilters()[0].operator;
				var datafield = filters.filtercolumn;
				datastring +='&filtervalue'+i+'=' + value + '&filtercondition'+i+'=' + condition + '&filterdatafield'+i+'=' + datafield+ '&filteroperator'+i+'='+ operator+'&'+datafield+'operator=and';
			}
			//END - Collecting filter information into querystring

			//Creating html view
			$.ajax({ 
				type: "POST",
				data: datastring+'&filterscount='+i,
				url: "<?php echo base_url();?>spkp_personalia_cuti/html/{id}",
				success: function(response){
					$("#popup_content").html(response);
				}
			 }); 		

			var offset = $(this).offset();
			$("#popup").jqxWindow({
				theme: theme, resizable: true, position: { x: 200, y: offset.top},
				width: 900,
				height: 500,
				isModal: true, autoOpen: false, cancelButton: $("#Cancel"), modalOpacity: 0.2
			});
			$("#popup").jqxWindow('open');
			//END - Creating html view
		});

		$('#excelbutton').click(function () {
			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgrid").jqxGrid('getfilterinformation');
			for (i = 0; i < filter.length; i++) {
				var filters = filter[i];
				var value = filters.filter.getfilters()[0].value;
				var condition = filters.filter.getfilters()[0].condition;
				var operator = filters.filter.getfilters()[0].operator;
				var datafield = filters.filtercolumn;
				datastring +='&filtervalue'+i+'=' + value + '&filtercondition'+i+'=' + condition + '&filterdatafield'+i+'=' + datafield+ '&filteroperator'+i+'='+ operator+'&'+datafield+'operator=and';
			}
			//END - Collecting filter information into querystring

			//Creating excel file
			$.ajax({ 
				type: "POST",
				data: datastring+'&filterscount='+i,
				url: "<?php echo base_url();?>spkp_personalia_cuti/excel/{id}",
				success: function(response){
					//Download excel file response
					window.open("<?php echo base_url();?>spkp_loader/"+response);
				}
			 }); 		
			//END - Creating excel file
		});
	});

	function edit(id){
		$("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		var offset = $("#jqxgrid").offset();
		$("#popup").jqxWindow({
			theme: theme, resizable: true, position: { x: offset.left + 80, y: offset.top-50},
			width: 700,
			height: 350,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_personalia_cuti/edit/"+id , function(response) {
			$("#popup_content").html("<div>"+response+"</div>");
		});
	}

	function download(id){
		$("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		var offset = $("#jqxgrid").offset();
		$("#popup").jqxWindow({
			theme: theme, resizable: true, position: { x: offset.left + 80, y: offset.top},
			width: 700,
			height: 220,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_personalia_cuti/download/"+id , function(response) {
			$("#popup_content").html("<div>"+response+"</div>");
		});
	}

	function close_dialog(s){
		$("#popup").jqxWindow('close');
		if(s==1){
			$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
		}
	}
</script>

<div class="row-fluid">
   <div class="span12">
	   <h3 class="page-title">
		 {title}
	   </h3>
   </div>
</div>
<div id="popup" style="display:none"><div id="popup_title">{title}</div><div id="popup_content">{popup}</div></div>
<div>
	<div style="width:98%;padding-bottom:8px;padding-top:5px">
		<table width="100%" cellpadding="0" cellspacing="0">
			<tr height="30">
				<td width="15%" rowspan="5" ><img src="<?php echo base_url()?>spkp/get_image_profile/{id}" style="border:8px solid #EFEFEF"></td>
				<td width="10%">Nama</td>
				<td width="2%">:</td>
				<td>{nama}</td>
			</tr>
			<tr height="30">
				<td>NIP</td>
				<td>:</td>
				<td>{nip}</td>
			</tr>
			<tr height="30">
				<td>Email</td>
				<td>:</td>
				<td>{email}</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="3" align="right">
				    <?php if($add_permission || $this->session->userdata('id')==$id){?><input style="padding: 5px;" value=" Upload File " id="btn_tambah" type="button"/><?php } ?>
					<input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbutton" type="button" />
					<input style="padding: 5px;" value=" Refresh Data " id="refreshdatabutton" type="button" />
					<input style="padding: 5px;" value=" Print " id="printbutton" type="button" />
					<input style="padding: 5px;" value=" Excel " id="excelbutton" type="button" />
					<input style="padding: 5px;" value=" Kembali " id="backbutton" type="button" />
				</td>
			</tr>
		</table>
	</div>
	<div style="width:98%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
        <div id="jqxgrid"></div>
	</div>
	<br>
	<br>
	<br>
</div>