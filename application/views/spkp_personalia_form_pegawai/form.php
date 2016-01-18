<script>
	$(function(){
       $("#bar_personalia").click();
	   $('#btn_tambah, #clearfilteringbutton, #refreshdatabutton, #printbutton, #excelbutton, #backbutton').jqxButton({ height: 25, theme: theme });

	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'urut'},
			{ name: 'id', type: 'string' },
            { name: 'kode', type: 'string' },
            { name: 'user_id', type: 'string' },
            { name: 'tgl', type: 'date' },
            { name: 'stat_tgl', type: 'date' },
            { name: 'alasan', type: 'string' },
            { name: 'jml', type: 'number' },
            { name: 'hitungan', type: 'string' },
            { name: 'status_approve', type: 'string' },
			{ name: 'status_kirim', type: 'string' },
			{ name: 'keterangan', type: 'string' }
        ],
		url: "<?php echo base_url(); ?>spkp_personalia_form_pegawai/json_izincuti/{id}/{thn}",
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
			rendertoolbar: function (toolbar) {
				var me = this;
				var container = $("<div style='margin: 5px;'></div>");
				var thn = $("<span style='float: left; margin-top: 5px; margin-right: 4px;'>Tahun: </span>");
				var thninput = $("<select class='jqx-input jqx-widget-content jqx-rc-all' id='filter_thn' name='filter_thn' style='height: 23px; float: left; width: 80px;' >{option_thn}</select>");
				toolbar.append(container);
				container.append(thn);
				container.append(thninput);
				thninput.change(function(){
					window.location.href="<?php echo base_url(); ?>spkp_personalia_form_pegawai/detail/{uid}/"+thninput.val();
				});
			},
			columns: [
				{ text: '#', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                     if({add_permission}==true || dataRecord.user_id=='<?php echo $this->session->userdata('id')?>'){
						if(dataRecord.status_approve=='1' && dataRecord.status_kirim=='1'){
					         return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit("+dataRecord.id+");'></a></div>";
					 	}else{
						     return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel("+dataRecord.urut+","+dataRecord.id+")'></a> <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit("+dataRecord.id+");'></a></div>";
					    }
                     }else{
						return "<div style='width:100%;padding:2px;text-align:right'><a href='javascript:void(0);' style='margin-right:4px'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit("+dataRecord.id+");'></a></div>";
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
			//	{ text: 'Tanggal', datafield: 'tgl', columntype: 'date', filtertype: 'date', cellsformat: 'yyyy-MM-dd', align: 'center', cellsalign: 'center', width: '9%' },
                { text: 'Mulai Cuti', datafield: 'stat_tgl', columntype: 'date', filtertype: 'date', cellsformat: 'yyyy-MM-dd', align: 'center', cellsalign: 'center', width: '9%' },
                { text: 'Jenis', datafield: 'keterangan', columntype: 'textbox', filtertype: 'textbox', width: '30%' },
				{ text: 'Keperluan', datafield: 'alasan', columntype: 'textbox', filtertype: 'textbox', width: '27%' },
				{ text: 'Lama Cuti', datafield: '', columntype: 'list', filtertype: 'none', align: 'center', cellsalign: 'center', width: '9%', cellsrenderer: function(row){
				  var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                  var day = dataRecord.hitungan;
                  if(dataRecord.kode=='itm'){
                    return "<div style='width:100%;padding-top: 5px;text-align:center'>-</div>";  
                  }else{
                    return "<div style='width:100%;padding-top: 5px;text-align:center'>"+dataRecord.jml+" "+day+"</div>";  
                  }
                 }
                },
                { text: 'Persetujuan', datafield: 'status_approve', columntype: 'list', filtertype: 'none', align: 'center', cellsalign: 'center', width: '10%', cellsrenderer: function(row){
				  var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                  return "<div style='width:100%;padding-top: 5px;text-align:center'><img border=0 src='<?php echo base_url(); ?>media/images/status_"+dataRecord.status_approve+".gif'></div>";  
                 } 
                },
                { text: 'Kirim', datafield: 'status_kirim', columntype: 'list', filtertype: 'none', align: 'center', cellsalign: 'center', width: '7%', cellsrenderer: function(row){
				  var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                  return "<div style='width:100%;padding-top: 5px;text-align:center'><img border=0 src='<?php echo base_url(); ?>media/images/status_"+dataRecord.status_kirim+".gif'></div>";  
                 }
                }
            ]
		});
        
		$('#backbutton').click(function () {
			window.location.href="<?php echo base_url()?>spkp_personalia_form_pegawai/";
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
                height: 270,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_personalia_form_pegawai/add/{uid}" , function(response) {
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
				url: "<?php echo base_url();?>spkp_personalia_form_pegawai/html/{id}/{thn}",
				success: function(response){
					$("#popup_content").html(response);
				}
			 }); 		

			var offset = $(this).offset();
			$("#popup").jqxWindow({
				theme: theme, resizable: false, position: { x: 200, y: offset.top},
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
				url: "<?php echo base_url();?>spkp_personalia_form_pegawai/excel/{id}/{thn}",
				success: function(response){
					//Download excel file response
					window.open("<?php echo base_url();?>spkp_loader/"+response);
				}
			 }); 		
			//END - Creating excel file
		});
	});
    
    function dodel(urut,id){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_personalia_form_pegawai/dodelete/"+id,
				success: function(response){
					 if(response=="1"){
						 $('#clearfilteringbutton').click();
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

	function edit(id){
		window.location.href="<?php echo base_url()?>spkp_personalia_form_pegawai/edit/{id}/"+id;
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
		<table width="100%" cellpadding="5" cellspacing="0" border='0' style="color: black;font-size: 12px;">
			<tr height="30" valign='top'>
				<td width="15%" rowspan="8" ><img src="<?php echo base_url()?>spkp/get_image_profile/{id}" style="border:8px solid #EFEFEF"></td>
				<td width="15%">Nama</td>
				<td width="2%" align='center'>:</td>
				<td>{nama}</td>
			</tr>
			<tr height="30">
				<td>NIP</td>
				<td align='center'>:</td>
				<td>{nip}</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
            <tr height="30">
				<td>Sisa Cuti <?php echo date('Y')-1; ?></td>
				<td align='center'>:</td>
				<td>{sisa_back}</td>
			</tr>
            <tr height="30">
				<td>Cuti yang diambil <?php echo date('Y')-1; ?></td>
				<td align='center'>:</td>
				<td>{taken_back}</td>
			</tr>
            <tr height="30">
				<td>Sisa Cuti <?php echo date('Y'); ?></td>
				<td align='center'>:</td>
				<td>{sisa_now}</td>
			</tr>
            <tr height="30">
				<td>Cuti yang diambil <?php echo date('Y'); ?></td>
				<td align='center'>:</td>
				<td>{taken_now}</td>
			</tr>
            <tr height="30">
				<td>Sisa Cuti Gabungan</td>
				<td align='center'>:</td>
				<td>{sisa_join}</td>
			</tr>
            <tr>
				<td colspan="3">&nbsp;</td>
			</tr>
            <tr>
				<td colspan="4" align="right">
				    <?php if($add_permission || $this->session->userdata('id')==$id){?><input style="padding: 5px;" value=" Pengajuan Cuti/Izin " id="btn_tambah" type="button"/><?php } ?>
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