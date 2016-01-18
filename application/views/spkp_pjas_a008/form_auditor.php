<script type="text/javascript">
    $(document).ready(function(){
       $('#back_auditor, #btn_tambah_auditor, #clearfilteringbutton_auditor, #refreshdatabutton_auditor, #printbutton_auditor, #excelbutton_auditor').jqxButton({ height: 25, theme: theme });

	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'urut'},
            { name: 'id', type: 'number' },
			{ name: 'id_auditor', type: 'number' },
            { name: 'tanggal', type: 'date' },
            { name: 'nama', type: 'string' },
            { name: 'nip', type: 'string' },
            { name: 'gol', type: 'string' },
            { name: 'jabatan', type: 'string' },
            { name: 'instansi', type: 'string' }
        ],
		url: "<?php echo base_url(); ?>spkp_pjas_a008/json_auditor/{id}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgrid_auditor").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid_auditor").jqxGrid('updatebounddata', 'sort');
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
     
		$("#jqxgrid_auditor").jqxGrid(
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
				{ text: '#', align: 'center', filtertype: 'none', sortable: false, width: '5%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_auditor").jqxGrid('getrowdata', row);
                     if({add_permission}==true){
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel_auditor("+dataRecord.urut+","+dataRecord.id_auditor+")'></a>  <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit_auditor("+dataRecord.id_auditor+");'></a></div>";
                     }else{
                        return "<div style='text-align: center;padding:3px'>&nbsp;</div>";
                     }
				    }
                },
				//Kolom No otomatis menampilkan filed 'urut' hasil query crud->jqxGrid, gunakan format ini untuk mencegah error filter data
				{ text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_auditor").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				// END
                { text: 'Nama', datafield: 'nama', columntype: 'textbox', filtertype: 'textbox', width: '25%' },
                { text: 'NIP', datafield: 'nip', columntype: 'textbox', filtertype: 'textbox', width: '15%' },
                { text: 'Gol', datafield: 'gol', columntype: 'textbox', filtertype: 'list', align: 'center', cellsalign: 'center',width: '10%' },
                { text: 'Jabatan', datafield: 'jabatan', columntype: 'textbox', filtertype: 'textbox', width: '17%' },
                { text: 'Instansi', datafield: 'instansi', columntype: 'textbox', filtertype: 'textbox', width: '13%' },
                { text: 'Tanggal', datafield: 'tanggal', columntype: 'date', filtertype: 'date', cellsformat: 'yyyy-MM-dd', width: '11%' }
            ]
		});
        
		$('#clearfilteringbutton_auditor').click(function () {
			$("#jqxgrid_auditor").jqxGrid('clearfilters');
		});
        
 		$('#refreshdatabutton_auditor').click(function () {
			$("#jqxgrid_auditor").jqxGrid('updatebounddata', 'cells');
		});

	   $('#btn_tambah_auditor').click(function(){
			$("#popup_content_auditor").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $("#jqxgrid_auditor").offset();
			$("#popup_auditor").jqxWindow({
				theme: theme, resizable: false, position: { x: offset.left + 185, y: offset.top},
                width: 440,
                height: 330,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup_auditor").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_pjas_a008/add_auditor/{id}" , function(response) {
				$("#popup_content_auditor").html("<div>"+response+"</div>");
			});
		});

		$('#printbutton_auditor').click(function () {
  			$("#popup_content_auditor").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");

			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgrid_auditor").jqxGrid('getfilterinformation');
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
				url: "<?php echo base_url();?>spkp_pjas_a008/html_auditor",
				success: function(response){
					$("#popup_content_auditor").html(response);
				}
			 }); 		

			var offset = $(this).offset();
			$("#popup_auditor").jqxWindow({
			//	theme: theme, resizable: true, position: { x: offset.left + 250, y: offset.top},
                theme: theme, resizable: true, position: { x: 200, y: offset.top},
				width: 900,
				height: 500,
				isModal: true, autoOpen: false, cancelButton: $("#Cancel"), modalOpacity: 0.2
			});
			$("#popup_auditor").jqxWindow('open');
			//END - Creating html view
		});

		$('#excelbutton_auditor').click(function () {
			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgrid_auditor").jqxGrid('getfilterinformation');
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
				url: "<?php echo base_url();?>spkp_pjas_a008/excel_auditor",
				success: function(response){
					//Download excel file response
					window.open("<?php echo base_url();?>spkp_loader/"+response);
				}
			 }); 		
			//END - Creating excel file
		});
    });
    
    function edit_auditor(id){
		$("#popup_content_auditor").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
	    $("#popup_auditor").jqxWindow({
			theme: theme, resizable: false, position: { x: 400, y: $("#jqxgrid_auditor").offset().top},
            width: 440,
            height: 330,
			isModal: true, autoOpen: false, modalOpacity: 0.2,
        });
        $("#popup_auditor").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_pjas_a008/edit_auditor/{id}/"+id , function(response) {
			$("#popup_content_auditor").html("<div>"+response+"</div>");
		});
	}
    
    function save_edit_auditor_dialog(content){
	   	$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a008/doedit_auditor/{id}",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_dialog_auditor();
                     $('#clearfilteringbutton_auditor').click();
                     $('#refreshdatabutton_auditor').click();
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

    function save_add_auditor_dialog(content){
        $.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a008/doadd_auditor/{id}",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_dialog_auditor();
					 $('#clearfilteringbutton_auditor').click();
                     $('#refreshdatabutton_auditor').click();
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
    
    function dodel_auditor(urut,id){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_pjas_a008/dodel_auditor/{id}/"+id,
				success: function(response){
					 if(response=="1"){
						 $('#clearfilteringbutton_auditor').click();
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

	function close_dialog_auditor(){
		$("#popup_auditor").jqxWindow("close");
	}
</script>
<div id="popup_auditor" style="display:none"><div id="popup_title_auditor">Auditor</div><div id="popup_content_auditor">{popup}</div></div>
<div>
	<div style="width:100%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
        <input style="padding: 5px;display: none;" value="Kembali" id="back_auditor" onclick="back()" type="button" />
        <?php if($add_permission){?><input style="padding: 5px;" value="Tambah" id="btn_tambah_auditor" type="button"/><?php } ?>
		<input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbutton_auditor" type="button" />
		<input style="padding: 5px;" value=" Refresh Data " id="refreshdatabutton_auditor" type="button" />
		<input style="padding: 5px;display: none;" value=" Print " id="printbutton_auditor" type="button"/>
		<input style="padding: 5px;display: none;" value=" Excel " id="excelbutton_auditor" type="button"/>
        <div id="jqxgrid_auditor"></div>
	</div>
</div>