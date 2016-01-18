<script type="text/javascript">
    $(document).ready(function(){
       $('#back_uji, #btn_tambah_uji, #clearfilteringbutton_uji, #refreshdatabutton_uji, #printbutton_uji, #excelbutton_uji').jqxButton({ height: 25, theme: theme });

	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'urut'},
            { name: 'id', type: 'number' },
			{ name: 'id_hasil', type: 'number' },
            { name: 'id_parameter', type: 'number' },
            { name: 'parameter', type: 'string' },
            { name: 'hasil', type: 'string' },
            { name: 'kesimpulan', type: 'string' }
        ],
		url: "<?php echo base_url(); ?>spkp_pjas_a016/json_uji/{id}/{id_hasil}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgrid_uji").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid_uji").jqxGrid('updatebounddata', 'sort');
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
     
		$("#jqxgrid_uji").jqxGrid(
		{		
			width: '100%',
            height: '300px',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: true, pagesizeoptions: ['10', '25', '50', '100', '200'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: false, pageable: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: '#', align: 'center', filtertype: 'none', sortable: false, width: '8%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_uji").jqxGrid('getrowdata', row);
                     if({add_permission}==true){
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel_uji("+dataRecord.urut+","+dataRecord.id_parameter+")'></a>  <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit_uji("+dataRecord.id_parameter+");'></a></div>";
                     }else{
                        return "<div style='text-align: center;padding:3px'>&nbsp;</div>";
                     }
				    }
                },
				//Kolom No otomatis menampilkan filed 'urut' hasil query crud->jqxGrid, gunakan format ini untuk mencegah error filter data
				{ text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_uji").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				// END
                { text: 'Parameter', datafield: 'parameter', columntype: 'textbox', filtertype: 'textbox', width: '30%' },
                { text: 'Hasil', datafield: 'hasil', columntype: 'textbox', filtertype: 'list',width: '30%' },
                { text: 'Kesimpulan', datafield: 'kesimpulan', columntype: 'textbox', filtertype: 'list', width: '28%' }
            ]
		});
        
		$('#clearfilteringbutton_uji').click(function () {
			$("#jqxgrid_uji").jqxGrid('clearfilters');
		});
        
 		$('#refreshdatabutton_uji').click(function () {
			$("#jqxgrid_uji").jqxGrid('updatebounddata', 'cells');
		});

	   $('#btn_tambah_uji').click(function(){
			$("#popup_content_uji").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			$("#popup_uji").jqxWindow({
				theme: theme, resizable: false, position: { x: offset.left + 54, y: offset.top},
                width: 540,
                height: 230,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup_uji").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_pjas_a016/add_uji/{id}/{id_hasil}" , function(response) {
				$("#popup_content_uji").html("<div>"+response+"</div>");
			});
		});

		$('#printbutton_uji').click(function () {
  			$("#popup_content_uji").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");

			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgrid_uji").jqxGrid('getfilterinformation');
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
				url: "<?php echo base_url();?>spkp_pjas_a016/html_uji",
				success: function(response){
					$("#popup_content_uji").html(response);
				}
			 }); 		

			var offset = $(this).offset();
			$("#popup_uji").jqxWindow({
			//	theme: theme, resizable: true, position: { x: offset.left + 250, y: offset.top},
                theme: theme, resizable: true, position: { x: 200, y: offset.top},
				width: 900,
				height: 500,
				isModal: true, autoOpen: false, cancelButton: $("#Cancel"), modalOpacity: 0.2
			});
			$("#popup_uji").jqxWindow('open');
			//END - Creating html view
		});

		$('#excelbutton_uji').click(function () {
			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgrid_uji").jqxGrid('getfilterinformation');
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
				url: "<?php echo base_url();?>spkp_pjas_a016/excel_uji",
				success: function(response){
					//Download excel file response
					window.open("<?php echo base_url();?>spkp_loader/"+response);
				}
			 }); 		
			//END - Creating excel file
		});
    });
    
    function edit_uji(id){
		$("#popup_content_uji").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
	    var offset = $(this).offset();
        $("#popup_uji").jqxWindow({
			theme: theme, resizable: false, position: { x: 400, y: 180},
            width: 540,
            height: 230,
			isModal: true, autoOpen: false, modalOpacity: 0.2,
        });
        $("#popup_uji").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_pjas_a016/edit_uji/{id}/{id_hasil}/"+id , function(response) {
			$("#popup_content_uji").html("<div>"+response+"</div>");
		});
	}
    
    function save_edit_uji_dialog(content){
	   	$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a016/doedit_uji/{id}/{id_hasil}",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_dialog_uji();
                     $('#clearfilteringbutton_uji').click();
                     $('#refreshdatabutton_uji').click();
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

    function save_add_uji_dialog(content){
        $.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a016/doadd_uji/{id}/{id_hasil}",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_dialog_uji();
					 $('#clearfilteringbutton_uji').click();
                     $('#refreshdatabutton_uji').click();
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
    
    function dodel_uji(urut,id){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_pjas_a016/dodel_uji/{id}/{id_hasil}/"+id,
				success: function(response){
					 if(response=="1"){
						 $('#clearfilteringbutton_uji').click();
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

	function close_dialog_uji(){
		$("#popup_uji").jqxWindow("close");
	}
</script>
<style>
.title_uji {
    display: block;
    font-family: 'MyriadPro-Light';
    font-size: 20px;
    font-weight: normal;
}
</style>
<div class="title_uji" style="padding: 10px;">{title_uji}</div>
<div style="padding: 10px;">
    <table width='100%' border='0' cellpadding='5' cellspacing='1' style="font-size: 12px;">
        <tr>
            <td width='15%'>Kode Sampel</td>
            <td width='3%' align='center'>:</td>
            <td width='50%'>{kode_sampel}</td>
        </tr>
        <tr>
            <td width='15%'>Nama Produk</td>
            <td width='3%' align='center'>:</td>
            <td width='50%'>{produk}</td>
        </tr>
        <tr>
            <td width='15%'>No. Pendaftaran</td>
            <td width='3%' align='center'>:</td>
            <td width='50%'>{no_pendaftaran}</td>
        </tr>
    </table>
</div>
<div id="popup_uji" style="display:none"><div id="popup_title_uji">Pengujian</div><div id="popup_content_uji">{popup}</div></div>
<div style="padding: 10px;">
	<div style="width:100%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
        <input style="padding: 5px;display: none;" value="Kembali" id="back_uji" onclick="back()" type="button" />
        <?php if($add_permission){?><input style="padding: 5px;" value="Tambah" id="btn_tambah_uji" type="button"/><?php } ?>
		<input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbutton_uji" type="button" />
		<input style="padding: 5px;" value=" Refresh Data " id="refreshdatabutton_uji" type="button" />
		<input style="padding: 5px;display: none;" value=" Print " id="printbutton_uji" type="button"/>
		<input style="padding: 5px;display: none;" value=" Excel " id="excelbutton_uji" type="button"/>
        <div id="jqxgrid_uji"></div>
	</div>
</div>