<script type="text/javascript">
    $(document).ready(function(){
       $('#back_pelaksanaan, #btn_tambah_pelaksanaan, #clearfilteringbutton_pelaksanaan, #refreshdatabutton_pelaksanaan, #printbutton_pelaksanaan, #excelbutton_pelaksanaan').jqxButton({ height: 25, theme: theme });

	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'urut'},
            { name: 'id', type: 'number' },
			{ name: 'id_pelaksanaan', type: 'number' },
            { name: 'tgl', type: 'date' },
            { name: 'jenis', type: 'string' },
            { name: 'media', type: 'string' },
            { name: 'kegiatan', type: 'string' },
            { name: 'evaluasi', type: 'string' }
        ],
		url: "<?php echo base_url(); ?>spkp_pjas_a013/json_pelaksanaan/{id}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgrid_pelaksanaan").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid_pelaksanaan").jqxGrid('updatebounddata', 'sort');
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
     
		$("#jqxgrid_pelaksanaan").jqxGrid(
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
				     var dataRecord = $("#jqxgrid_pelaksanaan").jqxGrid('getrowdata', row);
                     if({add_permission}==true){
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel_pelaksanaan("+dataRecord.urut+","+dataRecord.id_pelaksanaan+")'></a>  <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit_pelaksanaan("+dataRecord.id_pelaksanaan+");'></a></div>";
                     }else{
                        return "<div style='text-align: center;padding:3px'>&nbsp;</div>";
                     }
				    }
                },
				//Kolom No otomatis menampilkan filed 'urut' hasil query crud->jqxGrid, gunakan format ini untuk mencegah error filter data
				{ text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_pelaksanaan").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				// END
                { text: 'Tanggal', datafield: 'tgl', columntype: 'date', filtertype: 'date', cellsformat: 'yyyy-MM-dd', width: '9%' },
                { text: 'Jenis KIE', datafield: 'jenis', columntype: 'textbox', filtertype: 'textbox', width: '20%' },
                { text: 'Media KIE', datafield: 'media', columntype: 'textbox', filtertype: 'textbox', width: '17%' },
                { text: 'Nama Kegiatan', datafield: 'kegiatan', columntype: 'textbox', filtertype: 'textbox',width: '15%' },
                { text: 'Evaluasi', datafield: 'evaluasi', columntype: 'textbox', filtertype: 'textbox', width: '30%' }
            ]
		});
        
		$('#clearfilteringbutton_pelaksanaan').click(function () {
			$("#jqxgrid_pelaksanaan").jqxGrid('clearfilters');
		});
        
 		$('#refreshdatabutton_pelaksanaan').click(function () {
			$("#jqxgrid_pelaksanaan").jqxGrid('updatebounddata', 'cells');
		});

	   $('#btn_tambah_pelaksanaan').click(function(){
			$("#popup_content_pelaksanaan").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		    var offset = $("#jqxgrid_pelaksanaan").offset();  
			$("#popup_pelaksanaan").jqxWindow({
				theme: theme, resizable: false, position: { x: 400, y: offset.top},
                width: 540,
                height: 380,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup_pelaksanaan").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_pjas_a013/add_pelaksanaan/{id}" , function(response) {
				$("#popup_content_pelaksanaan").html("<div>"+response+"</div>");
			});
		});
    });
    
    function edit_pelaksanaan(id){
		$("#popup_content_pelaksanaan").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
	    $("#popup_pelaksanaan").jqxWindow({
			theme: theme, resizable: false, position: { x: 400, y: $("#jqxgrid_pelaksanaan").offset().top},
            width: 540,
            height: 380,
			isModal: true, autoOpen: false, modalOpacity: 0.2,
        });
        $("#popup_pelaksanaan").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_pjas_a013/edit_pelaksanaan/{id}/"+id , function(response) {
			$("#popup_content_pelaksanaan").html("<div>"+response+"</div>");
		});
	}
    
    function save_edit_pelaksanaan_dialog(content){
	   	$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a013/doedit_pelaksanaan/{id}",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_dialog_pelaksanaan();
                     $('#clearfilteringbutton_pelaksanaan').click();
                     $('#refreshdatabutton_pelaksanaan').click();
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

    function save_add_pelaksanaan_dialog(content){
        $.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a013/doadd_pelaksanaan/{id}",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_dialog_pelaksanaan();
					 $('#clearfilteringbutton_pelaksanaan').click();
                     $('#refreshdatabutton_pelaksanaan').click();
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
    
    function dodel_pelaksanaan(urut,id){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_pjas_a013/dodel_pelaksanaan/{id}/"+id,
				success: function(response){
					 if(response=="1"){
						 $('#clearfilteringbutton_pelaksanaan').click();
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

	function close_dialog_pelaksanaan(){
		$("#popup_pelaksanaan").jqxWindow("close");
	}
</script>
<div id="popup_pelaksanaan" style="display:none"><div id="popup_title_pelaksanaan">Pelaksanaan</div><div id="popup_content_pelaksanaan">{popup}</div></div>
<div>
	<div style="width:100%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
        <input style="padding: 5px;display: none;" value="Kembali" id="back_pelaksanaan" onclick="back()" type="button" />
        <?php if($add_permission){?><input style="padding: 5px;" value="Tambah" id="btn_tambah_pelaksanaan" type="button"/><?php } ?>
		<input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbutton_pelaksanaan" type="button" />
		<input style="padding: 5px;" value=" Refresh Data " id="refreshdatabutton_pelaksanaan" type="button" />
		<input style="padding: 5px;display: none;" value=" Print " id="printbutton_pelaksanaan" type="button"/>
		<input style="padding: 5px;display: none;" value=" Excel " id="excelbutton_pelaksanaan" type="button"/>
        <div id="jqxgrid_pelaksanaan"></div>
	</div>
</div>