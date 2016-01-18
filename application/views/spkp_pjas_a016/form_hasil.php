<script type="text/javascript">
    $(document).ready(function(){
       $('#back_hasil, #btn_tambah_hasil, #clearfilteringbutton_hasil, #refreshdatabutton_hasil, #printbutton_hasil, #excelbutton_hasil').jqxButton({ height: 25, theme: theme });

	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'urut'},
            { name: 'id', type: 'number' },
			{ name: 'id_hasil', type: 'number' },
            { name: 'lokasi', type: 'string' },
            { name: 'alamat', type: 'string' },
            { name: 'kabkota', type: 'string' },
            { name: 'kode_sampel', type: 'string' },
            { name: 'produk', type: 'string' },
            { name: 'pedagang', type: 'string' },
            { name: 'pengolah', type: 'string' },
            { name: 'jenis', type: 'string' },
            { name: 'no_pendaftaran', type: 'string' },
            { name: 'kesimpulan_akhir', type: 'string' },
            { name: 'tindaklanjut', type: 'string' }
        ],
		url: "<?php echo base_url(); ?>spkp_pjas_a016/json_hasil/{id}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgrid_hasil").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid_hasil").jqxGrid('updatebounddata', 'sort');
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
     
		$("#jqxgrid_hasil").jqxGrid(
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
				{ text: '#', align: 'center', filtertype: 'none', sortable: false, width: '7%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_hasil").jqxGrid('getrowdata', row);
                     if({add_permission}==true){
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel_hasil("+dataRecord.urut+","+dataRecord.id_hasil+")'></a>  <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit_hasil("+dataRecord.id_hasil+");'></a> <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/file_gif.png' onclick='det_hasil("+dataRecord.id_hasil+");'></a></div>";
                     }else{
                        return "<div style='text-align: center;padding:3px'>&nbsp;</div>";
                     }
				    }
                },
				//Kolom No otomatis menampilkan filed 'urut' hasil query crud->jqxGrid, gunakan format ini untuk mencegah error filter data
				{ text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_hasil").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				// END
                { text: 'Lokasi', datafield: 'lokasi', columntype: 'textbox', filtertype: 'textbox', width: '15%' },
                { text: 'Kode', datafield: 'kode_sampel', columntype: 'textbox', filtertype: 'textbox',width: '12%' },
                { text: 'Produk', datafield: 'produk', columntype: 'textbox', filtertype: 'textbox', width: '14%' },
                { text: 'Pedagang', datafield: 'pedagang', columntype: 'textbox', filtertype: 'textbox', width: '14%' },
                { text: 'Jenis', datafield: 'jenis', columntype: 'textbox', filtertype: 'textbox', width: '10%' },
                { text: 'No. Pendaftaran', datafield: 'no_pendaftaran', columntype: 'textbox', filtertype: 'textbox', width: '13%' },
                { text: 'Kesimpulan', datafield: 'kesimpulan_akhir', columntype: 'textbox', filtertype: 'textbox', width: '11%' }
            ]
		});
        
		$('#clearfilteringbutton_hasil').click(function () {
			$("#jqxgrid_hasil").jqxGrid('clearfilters');
		});
        
 		$('#refreshdatabutton_hasil').click(function () {
			$("#jqxgrid_hasil").jqxGrid('updatebounddata', 'cells');
		});

	   $('#btn_tambah_hasil').click(function(){
			$("#popup_content_hasil").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $("#jqxgrid_hasil").offset();
			$("#popup_hasil").jqxWindow({
				theme: theme, resizable: false, position: { x: 400, y: offset.top},
                width: 540,
                height: 450,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup_hasil").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_pjas_a016/add_hasil/{id}" , function(response) {
				$("#popup_content_hasil").html("<div>"+response+"</div>");
			});
		});

		$('#printbutton_hasil').click(function () {
  			$("#popup_content_hasil").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");

			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgrid_hasil").jqxGrid('getfilterinformation');
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
				url: "<?php echo base_url();?>spkp_pjas_a016/html_hasil",
				success: function(response){
					$("#popup_content_hasil").html(response);
				}
			 }); 		

			var offset = $(this).offset();
			$("#popup_hasil").jqxWindow({
			//	theme: theme, resizable: true, position: { x: offset.left + 250, y: offset.top},
                theme: theme, resizable: true, position: { x: 200, y: offset.top},
				width: 900,
				height: 500,
				isModal: true, autoOpen: false, cancelButton: $("#Cancel"), modalOpacity: 0.2
			});
			$("#popup_hasil").jqxWindow('open');
			//END - Creating html view
		});

		$('#excelbutton_hasil').click(function () {
			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgrid_hasil").jqxGrid('getfilterinformation');
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
				url: "<?php echo base_url();?>spkp_pjas_a016/excel_hasil",
				success: function(response){
					//Download excel file response
					window.open("<?php echo base_url();?>spkp_loader/"+response);
				}
			 }); 		
			//END - Creating excel file
		});
    });
    
    function edit_hasil(id){
		$("#popup_content_hasil").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
	    $("#popup_hasil").jqxWindow({
			theme: theme, resizable: false, position: { x: 400, y: $("#jqxgrid_hasil").offset().top},
            width: 540,
            height: 450,
			isModal: true, autoOpen: false, modalOpacity: 0.2,
        });
        $("#popup_hasil").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_pjas_a016/edit_hasil/{id}/"+id , function(response) {
			$("#popup_content_hasil").html("<div>"+response+"</div>");
		});
	}
    
    function det_hasil(id){
        $("#popup_content_hasil").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
	    var offset = $(this).offset();
        $("#popup_hasil").jqxWindow({
			theme: theme, resizable: false, position: { x: 300, y: 180},
            width: 700,
            height: 540,
			isModal: true, autoOpen: false, modalOpacity: 0.2,
        });
        $("#popup_hasil").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_pjas_a016/load_uji/{id}/"+id , function(response) {
			$("#popup_content_hasil").html("<div>"+response+"</div>");
		});
    }
    
    function save_edit_hasil_dialog(content){
	   	$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a016/doedit_hasil/{id}",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_dialog_hasil();
                     $('#clearfilteringbutton_hasil').click();
                     $('#refreshdatabutton_hasil').click();
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

    function save_add_hasil_dialog(content){
        $.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a016/doadd_hasil/{id}",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_dialog_hasil();
					 $('#clearfilteringbutton_hasil').click();
                     $('#refreshdatabutton_hasil').click();
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
    
    function dodel_hasil(urut,id){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_pjas_a016/dodel_hasil/{id}/"+id,
				success: function(response){
					 if(response=="1"){
						 $('#clearfilteringbutton_hasil').click();
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

	function close_dialog_hasil(){
		$("#popup_hasil").jqxWindow("close");
	}
</script>
<div id="popup_hasil" style="display:none"><div id="popup_title_hasil">Hasil</div><div id="popup_content_hasil">{popup}</div></div>
<div>
	<div style="width:100%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
        <input style="padding: 5px;display: none;" value="Kembali" id="back_hasil" onclick="back()" type="button" />
        <?php if($add_permission){?><input style="padding: 5px;" value="Tambah" id="btn_tambah_hasil" type="button"/><?php } ?>
		<input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbutton_hasil" type="button" />
		<input style="padding: 5px;" value=" Refresh Data " id="refreshdatabutton_hasil" type="button" />
		<input style="padding: 5px;display: none;" value=" Print " id="printbutton_hasil" type="button"/>
		<input style="padding: 5px;display: none;" value=" Excel " id="excelbutton_hasil" type="button"/>
        <div id="jqxgrid_hasil"></div>
	</div>
</div>