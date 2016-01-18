<script type="text/javascript">
    $(document).ready(function(){
       $('#back_narasumber, #btn_tambah_narasumber, #clearfilteringbutton_narasumber, #refreshdatabutton_narasumber, #printbutton_narasumber, #excelbutton_narasumber').jqxButton({ height: 25, theme: theme });

	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'urut'},
            { name: 'id', type: 'number' },
			{ name: 'id_narasumber', type: 'number' },
            { name: 'nama', type: 'string' },
            { name: 'materi', type: 'string' }
        ],
		url: "<?php echo base_url(); ?>spkp_pjas_a020/json_narasumber/{id}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgrid_narasumber").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid_narasumber").jqxGrid('updatebounddata', 'sort');
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
     
		$("#jqxgrid_narasumber").jqxGrid(
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
				     var dataRecord = $("#jqxgrid_narasumber").jqxGrid('getrowdata', row);
                     if({add_permission}==true){
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel_narasumber("+dataRecord.urut+","+dataRecord.id_narasumber+")'></a>  <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit_narasumber("+dataRecord.id_narasumber+");'></a></div>";
                     }else{
                        return "<div style='text-align: center;padding:3px'>&nbsp;</div>";
                     }
				    }
                },
				//Kolom No otomatis menampilkan filed 'urut' hasil query crud->jqxGrid, gunakan format ini untuk mencegah error filter data
				{ text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_narasumber").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				// END
                { text: 'Narasumber', datafield: 'nama', columntype: 'textbox', filtertype: 'textbox', width: '40%' },
                { text: 'Materi yang disampaikan', datafield: 'materi', columntype: 'textbox', filtertype: 'textbox', width: '51%' }
            ]
		});
        
		$('#clearfilteringbutton_narasumber').click(function () {
			$("#jqxgrid_narasumber").jqxGrid('clearfilters');
		});
        
 		$('#refreshdatabutton_narasumber').click(function () {
			$("#jqxgrid_narasumber").jqxGrid('updatebounddata', 'cells');
		});

	   $('#btn_tambah_narasumber').click(function(){
			$("#popup_content_narasumber").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		    var offset = $("#jqxgrid_narasumber").offset();  
			$("#popup_narasumber").jqxWindow({
				theme: theme, resizable: false, position: { x: 400, y: offset.top},
                width: 540,
                height: 280,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup_narasumber").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_pjas_a020/add_narasumber/{id}" , function(response) {
				$("#popup_content_narasumber").html("<div>"+response+"</div>");
			});
		});
    });
    
    function edit_narasumber(id){
		$("#popup_content_narasumber").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
	    $("#popup_narasumber").jqxWindow({
			theme: theme, resizable: false, position: { x: 400, y: $("#jqxgrid_narasumber").offset().top},
            width: 540,
            height: 285,
			isModal: true, autoOpen: false, modalOpacity: 0.2,
        });
        $("#popup_narasumber").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_pjas_a020/edit_narasumber/{id}/"+id , function(response) {
			$("#popup_content_narasumber").html("<div>"+response+"</div>");
		});
	}
    
    function save_edit_narasumber_dialog(content){
	   	$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a020/doedit_narasumber/{id}",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_dialog_narasumber();
                     $('#clearfilteringbutton_narasumber').click();
                     $('#refreshdatabutton_narasumber').click();
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

    function save_add_narasumber_dialog(content){
        $.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a020/doadd_narasumber/{id}",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_dialog_narasumber();
					 $('#clearfilteringbutton_narasumber').click();
                     $('#refreshdatabutton_narasumber').click();
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
    
    function dodel_narasumber(urut,id){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_pjas_a020/dodel_narasumber/{id}/"+id,
				success: function(response){
					 if(response=="1"){
						 $('#clearfilteringbutton_narasumber').click();
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

	function close_dialog_narasumber(){
		$("#popup_narasumber").jqxWindow("close");
	}
</script>
<div id="popup_narasumber" style="display:none"><div id="popup_title_narasumber">Narasumber</div><div id="popup_content_narasumber">{popup}</div></div>
<div>
	<div style="width:100%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
        <input style="padding: 5px;display: none;" value="Kembali" id="back_narasumber" onclick="back()" type="button" />
        <?php if($add_permission){?><input style="padding: 5px;" value="Tambah" id="btn_tambah_narasumber" type="button"/><?php } ?>
		<input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbutton_narasumber" type="button" />
		<input style="padding: 5px;" value=" Refresh Data " id="refreshdatabutton_narasumber" type="button" />
		<input style="padding: 5px;display: none;" value=" Print " id="printbutton_narasumber" type="button"/>
		<input style="padding: 5px;display: none;" value=" Excel " id="excelbutton_narasumber" type="button"/>
        <div id="jqxgrid_narasumber"></div>
	</div>
</div>