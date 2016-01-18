<script>
	$(function(){
	   if('<?php echo $tab; ?>'=="nonindex"){
	       $("#mn_kegiatan").click();
	   } 
	   
	   $('#btn_tambah_kegiatan, #clearfilteringbutton_kegiatan, #refreshdatabutton_kegiatan, #printbutton_kegiatan, #exportbutton_kegiatan').jqxButton({ height: 25, theme: theme });

	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'urut'},
			{ name: 'waktu', type: 'date' },
			{ name: 'id_kegiatan', type: 'number' },
            { name: 'program', type: 'number' },
            { name: 'strategi', type: 'number' },
            { name: 'nama_program', type: 'string' },
			{ name: 'nama', type: 'string' },
            { name: 'nama_propinsi', type: 'string' },
            { name: 'tahun', type: 'string' },
            { name: 'instansi', type: 'string' },
            { name: 'indikator', type: 'string' },
            { name: 'target',  type: 'string' },
            { name: 'sumber_dana',  type: 'string' }
        ],
		url: "<?php echo base_url(); ?>spkp_pjas_a001/json_kegiatan/{propinsi}/{thn}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgrid_kegiatan").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid_kegiatan").jqxGrid('updatebounddata', 'sort');
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
     
		$("#jqxgrid_kegiatan").jqxGrid(
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
                var propinsi = $("<span style='float: left; margin-top: 5px; margin-right: 4px;'>Propinsi: </span>");
                var propinsinput = $("<select class='jqx-input jqx-widget-content jqx-rc-all' id='filter_propinsi' name='filter_propinsi' style='height: 23px; float: left; width: 210px;' >{option_propinsi}</select>");
				var thn = $("<span style='float: left; margin-top: 5px; margin-right: 4px;margin-left: 4px;'>Tahun: </span>");
				var thninput = $("<select class='jqx-input jqx-widget-content jqx-rc-all' id='filter_thn' name='filter_thn' style='height: 23px; float: left; width: 80px;' >{option_thn}</select>");
				toolbar.append(container);
                container.append(propinsi);
				container.append(propinsinput);
				container.append(thn);
				container.append(thninput);
                propinsinput.change(function(){
					window.location.href="<?php echo base_url(); ?>spkp_pjas_a001/index/"+propinsinput.val()+"/"+thninput.val();
                });
				thninput.change(function(){
					window.location.href="<?php echo base_url(); ?>spkp_pjas_a001/index/"+propinsinput.val()+"/"+thninput.val();
                });
			},
            columns: [
				{ text: '#', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_kegiatan").jqxGrid('getrowdata', row);
					 if({add_permission}==true){
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel_kegiatan("+dataRecord.urut+","+dataRecord.id_kegiatan+")'></a>  <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit_kegiatan("+dataRecord.id_kegiatan+");'></a></div>";
                     }else{
                        return "<div style='text-align: center;padding:3px'>&nbsp;</div>";
                     }
                 }
                },
				//Kolom No otomatis menampilkan filed 'urut' hasil query crud->jqxGrid, gunakan format ini untuk mencegah error filter data
				{ text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_kegiatan").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				// END
				{ text: 'Program', datafield: 'nama_program', columntype: 'textbox', filtertype: 'list', width: '19%' },
			    { text: 'Kegiatan', datafield: 'nama', columntype: 'textbox', filtertype: 'textbox', width: '25%' },
                { text: 'Instansi', datafield: 'instansi', columntype: 'textbox', filtertype: 'textbox', width: '20%' },
				{ text: 'Indikator', datafield: 'indikator', columntype: 'textbox', filtertype: 'textbox', width: '18%' },
				{ text: 'Waktu', datafield: 'waktu', columntype: 'textbox', filtertype: 'textbox', width: '10%' }
		      ]
		});
        
		$('#clearfilteringbutton_kegiatan').click(function () {
			$("#jqxgrid_kegiatan").jqxGrid('clearfilters');
		});
        
 		$('#refreshdatabutton_kegiatan').click(function () {
			$("#jqxgrid_kegiatan").jqxGrid('updatebounddata', 'cells');
		});

	   $('#btn_tambah_kegiatan').click(function(){
			$("#popup_content_kegiatan").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			$("#popup_kegiatan").jqxWindow({
				theme: theme, resizable: false, position: { x: offset.left + 135, y: offset.top},
                width: 550,
                height: 400,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup_kegiatan").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_pjas_a001/add_kegiatan" , function(response) {
				$("#popup_content_kegiatan").html("<div>"+response+"</div>");
			});
		});

		$('#printbutton_kegiatan').click(function () {
  			$("#popup_content_kegiatan").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");

			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgrid_kegiatan").jqxGrid('getfilterinformation');
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
				url: "<?php echo base_url();?>spkp_pjas_a001/html_kegiatan/{propinsi}/{thn}",
				success: function(response){
					$("#popup_content_kegiatan").html(response);
				}
			 }); 		

			var offset = $(this).offset();
			$("#popup_kegiatan").jqxWindow({
				theme: theme, resizable: true, position: { x: 200, y: offset.top},
				width: 900,
				height: 500,
				isModal: true, autoOpen: false, cancelButton: $("#Cancel"), modalOpacity: 0.2
			});
			$("#popup_kegiatan").jqxWindow('open');
			//END - Creating html view
		});
        
        $('#exportbutton_kegiatan').click(function () {
			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgrid").jqxGrid('getfilterinformation');
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
				url: "<?php echo base_url();?>spkp_pjas_a001/word_kegiatan/{propinsi}/{thn}",
				success: function(response){
					//Download excel file response
					window.open("<?php echo base_url();?>spkp_loader/"+response);
				}
			 }); 		
			//END - Creating excel file
		});
        
	});

	function edit_kegiatan(id){
		$("#popup_content_kegiatan").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		var offset = $("#jqxgrid_kegiatan").offset();
		$("#popup_kegiatan").jqxWindow({
			theme: theme, resizable: false, position: { x: offset.left + 135, y: offset.top},
			width: 550,
            height: 400,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup_kegiatan").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_pjas_a001/edit_kegiatan/"+id , function(response) {
			$("#popup_content_kegiatan").html("<div>"+response+"</div>");
		});
	}
    
    function save_edit_kegiatan_dialog(content){
	   	$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a001/doedit_kegiatan",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_dialog_kegiatan();
                     $('#clearfilteringbutton_kegiatan').click();
                     $('#refreshdatabutton_kegiatan').click();
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
    
    function save_add_kegiatan_dialog(content){
		$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a001/doadd_kegiatan",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_dialog_kegiatan();
					 $('#clearfilteringbutton_kegiatan').click();
                     $('#refreshdatabutton_kegiatan').click();
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
    
    function dodel_kegiatan(urut,id){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_pjas_a001/dodel_kegiatan/"+id,
				success: function(response){
					 if(response=="1"){
						 $('#clearfilteringbutton_kegiatan').click();
                         $('#refreshdatabutton_kegiatan').click();
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

	function close_dialog_kegiatan(s){
		$("#popup_kegiatan").jqxWindow('close');
		if(s==1){
			$("#jqxgrid_kegiatan").jqxGrid('updatebounddata', 'cells');
		}
	}
</script>
<div id="popup_kegiatan" style="display:none"><div id="popup_title_kegiatan">Kegiatan</div><div id="popup_content_kegiatan">{popup}</div></div>
<div>
	<div style="width:100%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
        <?php if($add_permission){?><input style="padding: 5px;" value="Tambah" id="btn_tambah_kegiatan" type="button"/><?php } ?>
		<input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbutton_kegiatan" type="button" />
		<input style="padding: 5px;" value=" Refresh Data " id="refreshdatabutton_kegiatan" type="button" />
		<input style="padding: 5px;" value=" Print " id="printbutton_kegiatan" type="button" />
        <input style="padding: 5px;" value="Export" id="exportbutton_kegiatan" type="button" />
        <div id="jqxgrid_kegiatan"></div>
	</div>
	<br>
	<br>
	<br>
</div>