<script>
	$(function(){
		$("#printbutton_kegiatan,#excelbutton_kegiatan").jqxInput({ theme: 'fresh', height: '20px', width: '50px' }); 
		$("#btn_tambah_kegiatan,#clearfilteringbutton_kegiatan,#refreshdatabutton_kegiatan").jqxInput({ theme: 'fresh', height: '20px', width: '120px' }); 

	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'urut'},
			{ name: 'uploader', type: 'number' },
			{ name: 'id', type: 'number' },
			{ name: 'tgl', type: 'date' },
			{ name: 'tglstring', type: 'string' },
			{ name: 'username', type: 'string' },
			{ name: 'tempat', type: 'string' },
			{ name: 'kegiatan', type: 'string' },
			{ name: 'kode', type: 'string' },
			{ name: 'keterangan',  type: 'string' }
        ],
		url: "<?php echo base_url(); ?>spkp_personalia_jadwal_kegiatan/json_kegiatan_jadwal/{id}/{bulan}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgridkegiatan2").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgridkegiatan2").jqxGrid('updatebounddata', 'sort');
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
     
		$("#jqxgridkegiatan2").jqxGrid(
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
				{ text: '#', align: 'center', filtertype: 'none', sortable: false, width: '8%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgridkegiatan2").jqxGrid('getrowdata', row);
					 if(dataRecord.id==<?php echo $this->session->userdata('id')?> ||  dataRecord.uploader==<?php echo $this->session->userdata('id')?>){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='editjadwal("+dataRecord.id+",\""+dataRecord.tglstring+"\");'></a> <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='deljadwal("+dataRecord.id+",\""+dataRecord.tglstring+"\");'></a></div>";
					 }else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/download.gif' onclick='detail("+dataRecord.id+",\""+dataRecord.tglstring+"\");'></a></div>";
					 }
                 }
                },
				//Kolom No otomatis menampilkan filed 'urut' hasil query crud->jqxGrid, gunakan format ini untuk mencegah error filter data
				{ text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgridkegiatan2").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				// END
				{ text: 'Tanggal', datafield: 'tgl', columntype: 'date', filtertype: 'date', cellsformat: 'yyyy-MM-dd', width: '14%' },
				{ text: 'Kode', datafield: 'kode', columntype: 'textbox', filtertype: 'textbox', width: '6%' },
				{ text: 'Kegiatan', datafield: 'kegiatan', columntype: 'textbox', filtertype: 'textbox', width: '20%' },
				{ text: 'Keterangan', datafield: 'keterangan', columntype: 'textbox', filtertype: 'textbox', width: '25%' },
				{ text: 'Tempat', datafield: 'tempat', columntype: 'textbox', filtertype: 'textbox', width: '13%' },
				{ text: 'Uploader', datafield: 'username', filtertype: 'checkedlist', columntype: 'dropdownlist', width: '10%' }
            ]
		});
        
		$('#backbutton').click(function () {
			window.location.href="<?php echo base_url()?>spkp_personalia_jadwal_kegiatan/";
		});
        
		$('#clearfilteringbutton_kegiatan').click(function () {
			$("#jqxgridkegiatan2").jqxGrid('clearfilters');
		});
        
 		$('#refreshdatabutton_kegiatan').click(function () {
			$("#jqxgridkegiatan2").jqxGrid('updatebounddata', 'cells');
		});

	   $('#btn_tambah_kegiatan').click(function(){
			$("#popupkegiatan_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $("#popup").offset();
			$("#popupkegiatan").jqxWindow({
				theme: theme, resizable: true, position: { x: 340, y: offset.top+100},
                width: 600,
                height: 320,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popupkegiatan").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_personalia_jadwal_kegiatan/add_jadwal/{uid}/{thn}" , function(response) {
				$("#popupkegiatan_content").html("<div>"+response+"</div>");
			});
		});

		$('#printbutton_kegiatan').click(function () {
  			$("#popupkegiatan_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");

			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgridkegiatan2").jqxGrid('getfilterinformation');
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
				url: "<?php echo base_url();?>spkp_personalia_jadwal_kegiatan/html/{id}",
				success: function(response){
					$("#popupkegiatan_content").html(response);
				}
			 }); 		

			var offset = $(this).offset();
			$("#popupkegiatan").jqxWindow({
				theme: theme, resizable: true, position: { x: 240, y: offset.top-80},
				width: 900,
				height: 500,
				isModal: true, autoOpen: false, cancelButton: $("#Cancel"), modalOpacity: 0.2
			});
			$("#popupkegiatan").jqxWindow('open');
			//END - Creating html view
		});

		$('#excelbutton_kegiatan').click(function () {
			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgridkegiatan2").jqxGrid('getfilterinformation');
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
				url: "<?php echo base_url();?>spkp_personalia_jadwal_kegiatan/excel/{id}",
				success: function(response){
					//Download excel file response
					window.open("<?php echo base_url();?>spkp_loader/"+response);
				}
			 }); 		
			//END - Creating excel file
		});
	});

	function editjadwal(id,tgl){
		$("#popupkegiatan_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		var offset = $("#popup").offset();
		$("#popupkegiatan").jqxWindow({
			theme: theme, resizable: true, position: { x: offset.left+40, y: offset.top+100},
			width: 600,
			height: 320,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popupkegiatan").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_personalia_jadwal_kegiatan/edit_jadwal/"+id+"/"+tgl , function(response) {
			$("#popupkegiatan_content").html("<div>"+response+"</div>");
		});
	}

	function deljadwal(id,tgl){
		if(confirm("Anda yakin akan menghapus data ("+tgl+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>spkp_personalia_jadwal_kegiatan/dodel_jadwal/"+id+"/"+tgl,
				success: function(response){
					 if(response=="1"){
						 $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
						 $("#jqxgridkegiatan2").jqxGrid('updatebounddata', 'cells');
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
</script>
<div>
	<div style="width:98%;padding-bottom:8px;padding-top:5px">
		<table width="100%" cellpadding="2" cellspacing="2">
			<tr height="30">
				<td width="15%" rowspan="3"><img src="<?php echo base_url()?>spkp/get_image_profile/{id}" style="border:8px solid #EFEFEF" width="80"></td>
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
				<td>Bulan</td>
				<td>:</td>
				<td>{bulan}</td>
			</tr>
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="4" align="right">
					<input style="padding: 5px;" value=" Tambah Kegiatan" id="btn_tambah_kegiatan" type="button" />
					<input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbutton_kegiatan" type="button" />
					<input style="padding: 5px;" value=" Refresh Data " id="refreshdatabutton_kegiatan" type="button" />
					<input style="padding: 5px;" value=" Print " id="printbutton_kegiatan" type="button" />
					<input style="padding: 5px;" value=" Excel " id="excelbutton_kegiatan" type="button" />
				</td>
			</tr>
		</table>
	</div>
	<div style="width:98%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
        <div id="jqxgridkegiatan2"></div>
	</div>
	<br>
	<br>
	<br>
</div>