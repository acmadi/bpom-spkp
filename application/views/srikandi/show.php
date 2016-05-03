
<script>
	$(function(){
	   $("#bar_informasidankajian").addClass("active open");
       $("#list_kajian").addClass("active open");
	   $('#btn_tambah_upload, #btn_hapus, #clearfilteringbutton_upload, #refreshdatabutton_upload, #printbutton_upload, #excelbutton_upload').jqxButton({ height: 25, theme: theme });
	   
	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'urut'},
			{ name: 'waktu_update', type: 'date' },
			{ name: 'id_file', type: 'number' },
            { name: 'uploader', type: 'number' },
			{ name: 'username', type: 'string' },
			{ name: 'judul', type: 'string' },
			{ name: 'prioritas', type: 'string' },			            
            { name: 'deskripsi', type: 'string' },
            { name: 'kategori', type: 'string' },
            { name: 'filename',  type: 'string' },
            { name: 'jumlahrevisi',  type: 'string' },
            { name: 'status',  type: 'string' },
            { name: 'jumlahkomen',  type: 'string' }
        ],
		url: "<?php echo base_url(); ?>srikandi/json_judul/{subdit}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgrid_upload").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid_upload").jqxGrid('updatebounddata', 'sort');
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
     
		$("#jqxgrid_upload").jqxGrid(
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
				var subdit = $("<span style='float: left; position:relative; margin-top: 5px; margin-right: 4px;'>Pilih Subdit: </span>");
				var subditinput = $("<div style='float: left;position:relative;width:500px'><select class='jqx-input jqx-widget-content jqx-rc-all' id='filter_subdit' name='filter_subdit' style='height: 23px; float: left; width: 450px;' >{option_subdit}</select></div>");
				toolbar.append(container);
				container.append(subdit);
				container.append(subditinput);
				subditinput.change(function(){
					var subdit 	= $('#filter_subdit').val();

					$.post("<?php echo site_url('srikandi/filter/');?>", 'subdit='+subdit, function(response) {
						$("#jqxgrid_upload").jqxGrid('updatebounddata', 'filter');
					});
                });
			},            
			columns: [
				{ text: '#', align: 'center', filtertype: 'none', sortable: false, width: '7%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_upload").jqxGrid('getrowdata', row);
					 if({add_permission}==true || dataRecord.uploader=='<?php echo $this->session->userdata('id')?>'){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);' title='Detail'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif' onclick='detail("+dataRecord.id_file+");'></a> <a href='javascript:void(0);' title='Edit'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit_upload("+dataRecord.id_file+");'></a> <a href='javascript:void(0);' title='Download'><img border=0 src='<?php echo base_url(); ?>public/images/download.gif' onclick='download("+dataRecord.id_file+");'></a></div>";
					 }else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/download.gif' onclick='download("+dataRecord.id_file+");'></a></div>";
					 }
                 }
                },
				//Kolom No otomatis menampilkan filed 'urut' hasil query crud->jqxGrid, gunakan format ini untuk mencegah error filter data
				{ text: ' ', align: 'center', filtertype: 'none', width: '3%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_upload").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'><input type='checkbox' name='kajian[]' value='"+dataRecord.id_file+"'></div>";
                 }
                },
				// END
			    { text: 'Judul Informasi dan Kajian', datafield: 'judul', columntype: 'textbox', filtertype: 'textbox', width: '28%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_upload").jqxGrid('getrowdata', row);
				     if(dataRecord.status=="1"){
                     	return "<div style='width:100%;padding:4px;'>"+dataRecord.judul+"</div>";
                     }else{
                     	return "<div style='width:100%;padding:4px;font-weight:bold'>"+dataRecord.judul+"</div>";
                     }
                 }
                },
				{ text: 'Kategori', datafield: 'kategori', columntype: 'textbox', filtertype: 'textbox', width: '22%' , cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_upload").jqxGrid('getrowdata', row);
				     if(dataRecord.status=="1"){
                     	return "<div style='width:100%;padding:4px;'>"+dataRecord.kategori+"</div>";
                     }else{
                     	return "<div style='width:100%;padding:4px;font-weight:bold'>"+dataRecord.kategori+"</div>";
                     }
                 }},
				{ text: 'Prioritas', datafield: 'prioritas', columntype: 'textbox', filtertype: 'textbox',  width: '6%' , cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_upload").jqxGrid('getrowdata', row);
				     if(dataRecord.status=="1"){
                     	return "<div style='width:100%;padding:4px;'>"+dataRecord.prioritas+"</div>";
                     }else{
                     	return "<div style='width:100%;padding:4px;font-weight:bold'>"+dataRecord.prioritas+"</div>";
                     }
                 }},
				{ text: 'Revisi', datafield: 'jumlahrevisi',filtertype: 'textbox', columntype: 'textbox', width: '5%' , cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_upload").jqxGrid('getrowdata', row);
				     if(dataRecord.status=="1"){
                     	return "<div style='width:100%;padding:4px;'>"+dataRecord.jumlahrevisi+"</div>";
                     }else{
                     	return "<div style='width:100%;padding:4px;font-weight:bold'>"+dataRecord.jumlahrevisi+"</div>";
                     }
                 }},
				{ text: 'Komentar', datafield: 'jumlahkomen',filtertype: 'textbox', columntype: 'textbox', width: '7%' , cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_upload").jqxGrid('getrowdata', row);
				     if(dataRecord.status=="1"){
                     	return "<div style='width:100%;padding:4px;'>"+dataRecord.jumlahkomen+"</div>";
                     }else{
                     	return "<div style='width:100%;padding:4px;font-weight:bold'>"+dataRecord.jumlahkomen+"</div>";
                     }
                 }},
				{ text: 'Date', datafield: 'waktu_update', columntype: 'date', filtertype: 'date', cellsformat: 'yyyy/MM/dd HH:mm:ss', width: '16%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_upload").jqxGrid('getrowdata', row);
				     if(dataRecord.status=="1"){
                     	return "<div style='width:100%;padding:4px;'>"+dataRecord.waktu_update+"</div>";
                     }else{
                     	return "<div style='width:100%;padding:4px;font-weight:bold'>"+dataRecord.waktu_update+"</div>";
                     }
                 }}, 
				{ text: 'User', datafield: 'username', filtertype: 'textbox', columntype: 'textbox', width: '6%' , cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_upload").jqxGrid('getrowdata', row);
				     if(dataRecord.status=="1"){
                     	return "<div style='width:100%;padding:4px;'>"+dataRecord.username+"</div>";
                     }else{
                     	return "<div style='width:100%;padding:4px;font-weight:bold'>"+dataRecord.username+"</div>";
                     }
                 }
             }
            ]
		});
        
		$('#clearfilteringbutton_upload').click(function () {
			$("#jqxgrid_upload").jqxGrid('clearfilters');
		});
        
 		$('#refreshdatabutton_upload').click(function () {
			$("#jqxgrid_upload").jqxGrid('updatebounddata', 'cells');
		});

	    $('#btn_hapus').click(function(){
			var values = new Array();	
			var	data = "";
			$.each($("input[name='kajian[]']:checked"), function() {
			  values.push($(this).val());		
			});
			
			if(values.length > 0){
				if(confirm('Hapus '+ values.length +' data kajian?')){
					$.post("<?php echo base_url().'srikandi/dodel'; ?>", {data: values} ,  function(res) {
						$("#jqxgrid_upload").jqxGrid('updatebounddata', 'cells');
						alert(res);
					});
				}
			}else{
				alert('Silahkan Pilih Kajian Terlebih Dahulu');
			}
		});

	    $('#btn_tambah_upload').click(function(){
			$("#popup_content_upload").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			$("#popup_upload").jqxWindow({
				theme: theme, resizable: true, position: { x: offset.left + 135, y: offset.top},
                width: 700,
                height: 440,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup_upload").jqxWindow('open');
			$.get("<?php echo base_url();?>srikandi/add_upload" , function(response) {
				$("#popup_content_upload").html("<div>"+response+"</div>");
			});
		});

		$('#printbutton_upload').click(function () {
  			$("#popup_content_upload").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");

			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgrid_upload").jqxGrid('getfilterinformation');
			k=0;
			for (i = 0; i < filter.length; i++) {
				var filters = filter[i].filter.getfilters();
				var datafield = filter[i].filtercolumn;
				for (j = 0; j < filters.length; j++) {
					if(filters[j].type=='datefilter'){
						var now = new Date(filters[j].value);
						var thn = now.getFullYear();
						var bln = now.getMonth()+1;
						var tgl = now.getDate();
						var jam = now.getHours();
						var menit = now.getMinutes();
						var detik = now.getSeconds();

						if(bln<10) bln = "0"+bln;
						if(tgl<10) tgl = "0"+tgl;
						if(jam<10) jam = "0"+jam;
						if(menit<10) menit = "0"+menit;
						if(detik<10) detik = "0"+detik;
						var value = thn+"/"+bln+"/"+tgl+" "+jam+":"+menit+":"+detik;
					}else{
						var value = filters[j].value;
					}
					var condition = filters[j].condition;
					var operator = filters[j].operator;
					datastring +='&filtervalue'+k+'=' + value + '&filtercondition'+k+'=' + condition + '&filterdatafield'+k+'=' + datafield+ '&filteroperator'+k+'='+ operator;
					k++;
				}
				datastring +='&'+datafield+'operator=and';
			}
			//END - Collecting filter information into querystring

			//Creating html view
			$.ajax({ 
				type: "POST",
				data: datastring+'&filterscount='+k,
				url: "<?php echo base_url();?>srikandi/html_upload/",
				success: function(response){
					$("#popup_content_upload").html(response);
				}
			 }); 		

			var offset = $(this).offset();
			$("#popup_upload").jqxWindow({
				theme: theme, resizable: true, position: { x: 200, y: offset.top},
				width: 900,
				height: 500,
				isModal: true, autoOpen: false, cancelButton: $("#Cancel"), modalOpacity: 0.2
			});
			$("#popup_upload").jqxWindow('open');
			//END - Creating html view
		});

		$('#excelbutton_upload').click(function () {
			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgrid_upload").jqxGrid('getfilterinformation');
			k=0;
			for (i = 0; i < filter.length; i++) {
				var filters = filter[i].filter.getfilters();
				var datafield = filter[i].filtercolumn;
				for (j = 0; j < filters.length; j++) {
					if(filters[j].type=='datefilter'){
						var now = new Date(filters[j].value);
						var thn = now.getFullYear();
						var bln = now.getMonth()+1;
						var tgl = now.getDate();
						var jam = now.getHours();
						var menit = now.getMinutes();
						var detik = now.getSeconds();

						if(bln<10) bln = "0"+bln;
						if(tgl<10) tgl = "0"+tgl;
						if(jam<10) jam = "0"+jam;
						if(menit<10) menit = "0"+menit;
						if(detik<10) detik = "0"+detik;
						var value = thn+"/"+bln+"/"+tgl+" "+jam+":"+menit+":"+detik;
					}else{
						var value = filters[j].value;
					}
					var condition = filters[j].condition;
					var operator = filters[j].operator;
					datastring +='&filtervalue'+k+'=' + value + '&filtercondition'+k+'=' + condition + '&filterdatafield'+k+'=' + datafield+ '&filteroperator'+k+'='+ operator;
					k++;
				}
				datastring +='&'+datafield+'operator=and';
			}
			//END - Collecting filter information into querystring

			//Creating html view
			$.ajax({ 
				type: "POST",
				data: datastring+'&filterscount='+k,
				url: "<?php echo base_url();?>srikandi/excel_upload/",
				success: function(response){
					//Download excel file response
					window.open("<?php echo base_url();?>spkp_loader/"+response);
				}
			 }); 		
			//END - Creating excel file
		});
	});

	function edit_upload(id){
		$("#popup_content_upload").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		var offset = $("#jqxgrid_upload").offset();
		$("#popup_upload").jqxWindow({
			theme: theme, resizable: true, position: { x: offset.left + 80, y: offset.top},
			width: 700,
			height: 440,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup_upload").jqxWindow('open');
		$.get("<?php echo base_url();?>srikandi/edit_upload/"+id , function(response) {
			$("#popup_content_upload").html("<div>"+response+"</div>");
		});
	}

	function download(id){
		$("#popup_content_upload").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		var offset = $("#jqxgrid_upload").offset();
		$("#popup_upload").jqxWindow({
			theme: theme, resizable: true, position: { x: offset.left + 80, y: offset.top},
			width: 700,
			height: 220,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup_upload").jqxWindow('open');
		$.get("<?php echo base_url();?>srikandi/download/"+id , function(response) {
			$("#popup_content_upload").html("<div>"+response+"</div>");
		});
	}

	function close_dialog_upload(s){
		$("#popup_upload").jqxWindow('close');
		if(s==1){
			$("#jqxgrid_upload").jqxGrid('updatebounddata', 'cells');
		}
	}
	function detail(id){
		document.location.href="<?php echo base_url().'srikandi/detail';?>/" + id;
	}




</script>
<div class="row-fluid">
   <div class="span12">
	   <h3 class="page-title">
		 {title}
	   </h3>
   </div>
</div>
<div id="popup_upload" style="display:none"><div id="popup_title_upload">Upload Data</div><div id="popup_content_upload">{popup}</div></div>
<div>
	<div style="width:100%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
        <?php if($add_permission){?>
        	<input style="padding: 5px;" value=" Tambah Informasi dan Kajian " id="btn_tambah_upload" type="button"/>
        	<input style="padding: 5px;" value=" Hapus Kajian " id="btn_hapus" type="button"/>
        <?php } ?>
		<input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbutton_upload" type="button" />
		<input style="padding: 5px;" value=" Refresh " id="refreshdatabutton_upload" type="button" />
		<input style="padding: 5px;" value=" Print " id="printbutton_upload" type="button" />
		<input style="padding: 5px;" value=" Excel " id="excelbutton_upload" type="button" />
        <div id="jqxgrid_upload"></div>
	</div>
	<br>
	<br>
	<br>
</div>