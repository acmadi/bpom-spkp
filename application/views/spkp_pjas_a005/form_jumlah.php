<script type="text/javascript">
    $(document).ready(function(){
       $('#back_jumlah, #btn_tambah_jumlah, #clearfilteringbutton_jumlah, #refreshdatabutton_jumlah, #printbutton_jumlah, #excelbutton_jumlah').jqxButton({ height: 25, theme: theme });

	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'urut'},
            { name: 'id', type: 'number' },
			{ name: 'hari', type: 'number' },
            { name: 'kepsek', type: 'number' },
            { name: 'guru_uks', type: 'number' },
            { name: 'guru', type: 'number' },
            { name: 'kantin', type: 'number' },
            { name: 'komite', type: 'number' },
            { name: 'kelas4', type: 'number' },
            { name: 'kelas5', type: 'number' },
            { name: 'lainnya', type: 'number' },
            { name: 'total', type: 'number' }
        ],
		url: "<?php echo base_url(); ?>spkp_pjas_a005/json_jumlah/{id}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgrid_jumlah").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid_jumlah").jqxGrid('updatebounddata', 'sort');
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
     
		$("#jqxgrid_jumlah").jqxGrid(
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
				     var dataRecord = $("#jqxgrid_jumlah").jqxGrid('getrowdata', row);
                     if({add_permission}==true){
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel_jumlah("+dataRecord.urut+","+dataRecord.hari+")'></a>  <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit_jumlah("+dataRecord.hari+");'></a></div>";
                     }else{
                        return "<div style='text-align: center;padding:3px'>&nbsp;</div>";
                     }
				    }
                },
				//Kolom No otomatis menampilkan filed 'urut' hasil query crud->jqxGrid, gunakan format ini untuk mencegah error filter data
				{ text: 'No', align: 'center', filtertype: 'none', width: '5%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_jumlah").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				// END
                { text: 'Hari', datafield: 'hari', columntype: 'textbox', filtertype: 'textbox', width: '5%' },
                { text: 'Kepsek', datafield: 'kepsek', columntype: 'textbox', filtertype: 'textbox', width: '9%' },
                { text: 'Guru UKS', datafield: 'guru_uks', columntype: 'textbox', filtertype: 'textbox', width: '9%' },
                { text: 'Guru', datafield: 'guru', columntype: 'textbox', filtertype: 'textbox', width: '5%' },
                { text: 'Pengelola Kantin', datafield: 'kantin', columntype: 'textbox', filtertype: 'textbox', width: '12%' },
                { text: 'Komite Sekolah', datafield: 'komite', columntype: 'textbox', filtertype: 'textbox', width: '12%' },
                { text: 'Siswa Kelas 4', datafield: 'kelas4', columntype: 'textbox', filtertype: 'textbox', width: '11%' },
                { text: 'Siswa Kelas 5', datafield: 'kelas5', columntype: 'textbox', filtertype: 'textbox', width: '11%' },
                { text: 'Lainnya', datafield: 'lainnya', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
                { text: 'Total', datafield: 'total', columntype: 'textbox', filtertype: 'textbox', width: '9%' }
            ]
		});
        
		$('#clearfilteringbutton_jumlah').click(function () {
			$("#jqxgrid_jumlah").jqxGrid('clearfilters');
		});
        
 		$('#refreshdatabutton_jumlah').click(function () {
			$("#jqxgrid_jumlah").jqxGrid('updatebounddata', 'cells');
		});

	   $('#btn_tambah_jumlah').click(function(){
			$("#popup_content_jumlah").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $("#jqxgrid_jumlah").offset();
			$("#popup_jumlah").jqxWindow({
				theme: theme, resizable: false, position: { x: 400, y: offset.top},
                width: 500,
                height: 410,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup_jumlah").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_pjas_a005/add_jumlah/{id}" , function(response) {
				$("#popup_content_jumlah").html("<div>"+response+"</div>");
			});
		});

		$('#printbutton_jumlah').click(function () {
  			$("#popup_content_jumlah").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");

			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgrid_jumlah").jqxGrid('getfilterinformation');
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
				url: "<?php echo base_url();?>spkp_pjas_a005/html_jumlah",
				success: function(response){
					$("#popup_content_jumlah").html(response);
				}
			 }); 		

			var offset = $(this).offset();
			$("#popup_jumlah").jqxWindow({
			//	theme: theme, resizable: true, position: { x: offset.left + 250, y: offset.top},
                theme: theme, resizable: true, position: { x: 200, y: offset.top},
				width: 900,
				height: 500,
				isModal: true, autoOpen: false, cancelButton: $("#Cancel"), modalOpacity: 0.2
			});
			$("#popup_jumlah").jqxWindow('open');
			//END - Creating html view
		});

		$('#excelbutton_jumlah').click(function () {
			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgrid_jumlah").jqxGrid('getfilterinformation');
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
				url: "<?php echo base_url();?>spkp_pjas_a005/excel_jumlah",
				success: function(response){
					//Download excel file response
					window.open("<?php echo base_url();?>spkp_loader/"+response);
				}
			 }); 		
			//END - Creating excel file
		});
    });
    
    function edit_jumlah(id){
		$("#popup_content_jumlah").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
	    $("#popup_jumlah").jqxWindow({
			theme: theme, resizable: false, position: { x: 400, y: $("#jqxgrid_jumlah").offset().top},
            width: 500,
            height: 420,
			isModal: true, autoOpen: false, modalOpacity: 0.2,
        });
        $("#popup_jumlah").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_pjas_a005/edit_jumlah/{id}/"+id , function(response) {
			$("#popup_content_jumlah").html("<div>"+response+"</div>");
		});
	}
    
    function save_edit_jumlah_dialog(content){
	   	$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a005/doedit_jumlah/{id}",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_dialog_jumlah();
                     $('#clearfilteringbutton_jumlah').click();
                     $('#refreshdatabutton_jumlah').click();
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

    function save_add_jumlah_dialog(content){
        $.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a005/doadd_jumlah/{id}",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_dialog_jumlah();
					 $('#clearfilteringbutton_jumlah').click();
                     $('#refreshdatabutton_jumlah').click();
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
    
    function dodel_jumlah(urut,id){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_pjas_a005/dodel_jumlah/{id}/"+id,
				success: function(response){
					 if(response=="1"){
						 $('#clearfilteringbutton_jumlah').click();
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

	function close_dialog_jumlah(){
		$("#popup_jumlah").jqxWindow("close");
	}
    
</script>
<div id="popup_jumlah" style="display:none"><div id="popup_title_jumlah">Jumlah Peserta</div><div id="popup_content_jumlah">{popup}</div></div>
<div>
	<div style="width:100%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
        <input style="padding: 5px;display: none;" value="Kembali" id="back_jumlah" onclick="back()" type="button" />
        <?php if($add_permission){?><input style="padding: 5px;" value="Tambah" id="btn_tambah_jumlah" type="button"/><?php } ?>
		<input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbutton_jumlah" type="button" />
		<input style="padding: 5px;" value=" Refresh Data " id="refreshdatabutton_jumlah" type="button" />
		<input style="padding: 5px;display: none;" value=" Print " id="printbutton_jumlah" type="button"/>
		<input style="padding: 5px;display: none;" value=" Excel " id="excelbutton_jumlah" type="button"/>
        <div id="jqxgrid_jumlah"></div>
	</div>
</div>