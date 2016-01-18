<script type="text/javascript">
    $(document).ready(function(){
       $('#back_kegiatan, #btn_tambah_kegiatan, #clearfilteringbutton_kegiatan, #refreshdatabutton_kegiatan, #printbutton_kegiatan, #excelbutton_kegiatan').jqxButton({ height: 25, theme: theme });

	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'urut'},
            { name: 'id', type: 'number' },
			{ name: 'id_kegiatan', type: 'number' },
            { name: 'tanggal', type: 'date' },
            { name: 'penerima', type: 'string' },
            { name: 'distribusi', type: 'string' },
            { name: 'produk', type: 'string' },
            { name: 'jumlah', type: 'number' }
        ],
		url: "<?php echo base_url(); ?>spkp_pjas_a014b/json_kegiatan/{id}",
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
			columns: [
				{ text: '#', align: 'center', filtertype: 'none', sortable: false, width: '5%', cellsrenderer: function (row) {
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
                { text: 'Tanggal', datafield: 'tanggal', columntype: 'date', filtertype: 'date', cellsformat: 'yyyy-MM-dd', width: '11%' },
                { text: 'Penerima Produk', datafield: 'penerima', columntype: 'textbox', filtertype: 'textbox', width: '23%' },
                { text: 'Metode Distribusi', datafield: 'distribusi', columntype: 'textbox', filtertype: 'textbox',width: '22%' },
                { text: 'Produk', datafield: 'produk', columntype: 'textbox', filtertype: 'textbox', width: '20%' },
                { text: 'Jumlah', datafield: 'jumlah', columntype: 'textbox', filtertype: 'textbox', width: '15%' }
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
			var offset = $("#jqxgrid_kegiatan").offset();
			$("#popup_kegiatan").jqxWindow({
				theme: theme, resizable: false, position: { x: offset.left + 185, y: offset.top},
                width: 540,
                height: 310,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup_kegiatan").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_pjas_a014b/add_kegiatan/{id}" , function(response) {
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
				url: "<?php echo base_url();?>spkp_pjas_a014b/html_kegiatan",
				success: function(response){
					$("#popup_content_kegiatan").html(response);
				}
			 }); 		

			var offset = $(this).offset();
			$("#popup_kegiatan").jqxWindow({
			//	theme: theme, resizable: true, position: { x: offset.left + 250, y: offset.top},
                theme: theme, resizable: true, position: { x: 200, y: offset.top},
				width: 900,
				height: 500,
				isModal: true, autoOpen: false, cancelButton: $("#Cancel"), modalOpacity: 0.2
			});
			$("#popup_kegiatan").jqxWindow('open');
			//END - Creating html view
		});

		$('#excelbutton_kegiatan').click(function () {
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
				url: "<?php echo base_url();?>spkp_pjas_a014b/excel_kegiatan",
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
	    $("#popup_kegiatan").jqxWindow({
			theme: theme, resizable: false, position: { x: 400, y: $("#jqxgrid_kegiatan").offset().top},
            width: 540,
            height: 315,
			isModal: true, autoOpen: false, modalOpacity: 0.2,
        });
        $("#popup_kegiatan").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_pjas_a014b/edit_kegiatan/{id}/"+id , function(response) {
			$("#popup_content_kegiatan").html("<div>"+response+"</div>");
		});
	}
    
    function save_edit_kegiatan_dialog(content){
	   	$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a014b/doedit_kegiatan/{id}",
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
			url: "<?php echo base_url()?>index.php/spkp_pjas_a014b/doadd_kegiatan/{id}",
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
				url: "<?php echo base_url()?>index.php/spkp_pjas_a014b/dodel_kegiatan/{id}/"+id,
				success: function(response){
					 if(response=="1"){
						 $('#clearfilteringbutton_kegiatan').click();
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

	function close_dialog_kegiatan(){
		$("#popup_kegiatan").jqxWindow("close");
	}
</script>
<div id="popup_kegiatan" style="display:none"><div id="popup_title_kegiatan">Kegiatan</div><div id="popup_content_kegiatan">{popup}</div></div>
<div>
	<div style="width:100%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
        <input style="padding: 5px;display: none;" value="Kembali" id="back_kegiatan" onclick="back()" type="button" />
        <?php if($add_permission){?><input style="padding: 5px;" value="Tambah" id="btn_tambah_kegiatan" type="button"/><?php } ?>
		<input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbutton_kegiatan" type="button" />
		<input style="padding: 5px;" value=" Refresh Data " id="refreshdatabutton_kegiatan" type="button" />
		<input style="padding: 5px;display: none;" value=" Print " id="printbutton_kegiatan" type="button"/>
		<input style="padding: 5px;display: none;" value=" Excel " id="excelbutton_kegiatan" type="button"/>
        <div id="jqxgrid_kegiatan"></div>
	</div>
</div>