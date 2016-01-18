<script>
	$(function(){
	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'urut'},
			{ name: 'waktu', type: 'date' },
			{ name: 'waktu_update', type: 'date' },
			{ name: 'id', type: 'number' },
            { name: 'user', type: 'number' },
            { name: 'uploader', type: 'number' },
			{ name: 'username', type: 'string' },
			{ name: 'judul', type: 'string' },
			{ name: 'keterangan', type: 'string' },
			{ name: 'filename',  type: 'string' }
        ],
		url: "<?php echo base_url(); ?>spkp_director_history/json_file/{id}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgrid_file").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid_file").jqxGrid('updatebounddata', 'sort');
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
     
		$("#jqxgrid_file").jqxGrid(
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
				     var dataRecord = $("#jqxgrid_file").jqxGrid('getrowdata', row);
					 if(dataRecord.uploader=='<?php echo $this->session->userdata('id')?>' || dataRecord.user=='<?php echo $this->session->userdata('id')?>'){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit_file("+dataRecord.id+");'></a> <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/download.gif' onclick='download_file("+dataRecord.id+");'></a></div>";
					 }else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/download.gif' onclick='download_file("+dataRecord.id+");'></a></div>";
					 }
                 }
                },
				//Kolom No otomatis menampilkan filed 'urut' hasil query crud->jqxGrid, gunakan format ini untuk mencegah error filter data
				{ text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_file").jqxGrid('getrowdata', row);
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
        
		$('#clearfilteringbutton_file').click(function () {
			$("#jqxgrid_file").jqxGrid('clearfilters');
		});
        
 		$('#refreshdatabutton_file').click(function () {
			$("#jqxgrid_file").jqxGrid('updatebounddata', 'cells');
		});

        $("#btnBackDokumen").click(function(){
           window.location.href = "<?php echo base_url(); ?>spkp_director_history"; 
        });

	    $('#btn_tambah_file').click(function(){
			$("#popup_content_file").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			$("#popup_file").jqxWindow({
				theme: theme, resizable: true, position: { x: offset.left + 80, y: offset.top},
                width: 700,
                height: 250,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup_file").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_director_history/add_file/{id}" , function(response) {
				$("#popup_content_file").html("<div>"+response+"</div>");
			});
		});

		$('#printbutton_file').click(function () {
  			$("#popup_content_file").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");

			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgrid_file").jqxGrid('getfilterinformation');
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
				url: "<?php echo base_url();?>spkp_director_history/html_file/{id}",
				success: function(response){
					$("#popup_content_file").html(response);
				}
			 }); 		

			var offset = $(this).offset();
			$("#popup_file").jqxWindow({
				theme: theme, resizable: true, position: { x: 200, y: offset.top},
				width: 900,
				height: 500,
				isModal: true, autoOpen: false, cancelButton: $("#Cancel"), modalOpacity: 0.2
			});
			$("#popup_file").jqxWindow('open');
			//END - Creating html view
		});

		$('#excelbutton_file').click(function () {
			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgrid_file").jqxGrid('getfilterinformation');
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
				url: "<?php echo base_url();?>spkp_director_history/excel_file/{id}",
				success: function(response){
					//Download excel file response
					window.open("<?php echo base_url();?>spkp_loader/"+response);
				}
			 }); 		
			//END - Creating excel file
		});
	});

	function edit_file(id){
		$("#popup_content_file").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		var offset = $("#jqxgrid_file").offset();
		$("#popup_file").jqxWindow({
			theme: theme, resizable: true, position: { x: offset.left + 80, y: offset.top},
			width: 700,
			height: 250,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup_file").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_director_history/edit_file/"+id , function(response) {
			$("#popup_content_file").html("<div>"+response+"</div>");
		});
	}

	function download_file(id){
		$("#popup_content_file").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		var offset = $("#jqxgrid_file").offset();
		$("#popup_file").jqxWindow({
			theme: theme, resizable: true, position: { x: offset.left + 80, y: offset.top},
			width: 700,
			height: 220,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup_file").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_director_history/download_file/"+id , function(response) {
			$("#popup_content_file").html("<div>"+response+"</div>");
		});
	}

	function close_dialog(s){
		$("#popup_file").jqxWindow('close');
		if(s==1){
			$("#jqxgrid_file").jqxGrid('updatebounddata', 'cells');
		}
	}
</script>
<div id="popup_file" style="display:none"><div id="popup_title_file">Dokumen</div><div id="popup_content_file">{popup}</div></div>
<div>
	<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
	    <input style="padding: 5px;" value=" Kembali " id="btnBackDokumen" type="button" />
        <?php if($add_permission || $id==$this->session->userdata('id')){?><input style="padding: 5px;" value=" Upload File " id="btn_tambah_file" type="button"/><?php } ?>
		<input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbutton_file" type="button" />
		<input style="padding: 5px;" value=" Refresh Data " id="refreshdatabutton_file" type="button" />
		<input style="padding: 5px;" value=" Print " id="printbutton_file" type="button" />
		<input style="padding: 5px;" value=" Excel " id="excelbutton_file" type="button" />
        <div id="jqxgrid_file"></div>
	</div>
	<br>
	<br>
	<br>
</div>