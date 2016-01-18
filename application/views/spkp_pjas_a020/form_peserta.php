<script type="text/javascript">
    $(document).ready(function(){
       $('#back_peserta, #btn_tambah_peserta, #clearfilteringbutton_peserta, #refreshdatabutton_peserta, #printbutton_peserta, #excelbutton_peserta').jqxButton({ height: 25, theme: theme });

	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'urut'},
            { name: 'id', type: 'number' },
			{ name: 'id_peserta', type: 'number' },
            { name: 'nama', type: 'string' },
            { name: 'institusi', type: 'string' },
            { name: 'pre_test', type: 'string' },
            { name: 'post_test', type: 'string' }
        ],
		url: "<?php echo base_url(); ?>spkp_pjas_a020/json_peserta/{id}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgrid_peserta").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid_peserta").jqxGrid('updatebounddata', 'sort');
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
     
		$("#jqxgrid_peserta").jqxGrid(
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
				     var dataRecord = $("#jqxgrid_peserta").jqxGrid('getrowdata', row);
                     if({add_permission}==true){
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel_peserta("+dataRecord.urut+","+dataRecord.id_peserta+")'></a>  <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit_peserta("+dataRecord.id_peserta+");'></a></div>";
                     }else{
                        return "<div style='text-align: center;padding:3px'>&nbsp;</div>";
                     }
				    }
                },
				//Kolom No otomatis menampilkan filed 'urut' hasil query crud->jqxGrid, gunakan format ini untuk mencegah error filter data
				{ text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_peserta").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				// END
                { text: 'Nama', datafield: 'nama', columntype: 'textbox', filtertype: 'textbox', width: '21%' },
                { text: 'Institusi', datafield: 'institusi', columntype: 'textbox', filtertype: 'textbox', width: '40%' },
                { text: 'Pre test', datafield: 'pre_test', columntype: 'textbox', filtertype: 'textbox', width: '15%' },
                { text: 'Post test', datafield: 'post_test', columntype: 'textbox', filtertype: 'textbox', width: '15%' }
            ]
		});
        
		$('#clearfilteringbutton_peserta').click(function () {
			$("#jqxgrid_peserta").jqxGrid('clearfilters');
		});
        
 		$('#refreshdatabutton_peserta').click(function () {
			$("#jqxgrid_peserta").jqxGrid('updatebounddata', 'cells');
		});

	   $('#btn_tambah_peserta').click(function(){
			$("#popup_content_peserta").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		    var offset = $("#jqxgrid_peserta").offset();  
			$("#popup_peserta").jqxWindow({
				theme: theme, resizable: false, position: { x: 400, y: offset.top},
                width: 540,
                height: 270,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup_peserta").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_pjas_a020/add_peserta/{id}" , function(response) {
				$("#popup_content_peserta").html("<div>"+response+"</div>");
			});
		});
    });
    
    function edit_peserta(id){
		$("#popup_content_peserta").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
	    $("#popup_peserta").jqxWindow({
			theme: theme, resizable: false, position: { x: 400, y: $("#jqxgrid_peserta").offset().top},
            width: 540,
            height: 275,
			isModal: true, autoOpen: false, modalOpacity: 0.2,
        });
        $("#popup_peserta").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_pjas_a020/edit_peserta/{id}/"+id , function(response) {
			$("#popup_content_peserta").html("<div>"+response+"</div>");
		});
	}
    
    function save_edit_peserta_dialog(content){
	   	$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a020/doedit_peserta/{id}",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_dialog_peserta();
                     $('#clearfilteringbutton_peserta').click();
                     $('#refreshdatabutton_peserta').click();
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

    function save_add_peserta_dialog(content){
        $.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a020/doadd_peserta/{id}",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_dialog_peserta();
					 $('#clearfilteringbutton_peserta').click();
                     $('#refreshdatabutton_peserta').click();
					 $.notific8('Notification', {
					  life: 5000,
					  message: 'Save data succesfully.',
					  heading: 'Saving data',
					  theme: 'lime'
					});
                   
                    $("#divCount").hide("blind");
                    $.ajax({
                       type: "POST",
                       url : "<?php echo base_url(); ?>spkp_pjas_a020/load_form_count/{id}",
                       success: function(response){
                            $("#divCount").show("slow");
                            $("#divCount").html(response);
                       } 
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
    
    function dodel_peserta(urut,id){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_pjas_a020/dodel_peserta/{id}/"+id,
				success: function(response){
					 if(response=="1"){
						 $('#clearfilteringbutton_peserta').click();
                         $.notific8('Notification', {
						  life: 5000,
						  message: 'Delete data succesfully.',
						  heading: 'Delete data',
						  theme: 'lime'
						});
                        
                        $("#divCount").hide("blind");
                        $.ajax({
                           type: "POST",
                           url : "<?php echo base_url(); ?>spkp_pjas_a020/load_form_count/{id}",
                           success: function(response){
                                $("#divCount").show("slow");
                                $("#divCount").html(response);
                           } 
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

	function close_dialog_peserta(){
		$("#popup_peserta").jqxWindow("close");
	}
</script>
<div id="popup_peserta" style="display:none"><div id="popup_title_peserta">Peserta</div><div id="popup_content_peserta">{popup}</div></div>
<div>
	<div style="width:100%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
        <input style="padding: 5px;display: none;" value="Kembali" id="back_peserta" onclick="back()" type="button" />
        <?php if($add_permission){?><input style="padding: 5px;" value="Tambah" id="btn_tambah_peserta" type="button"/><?php } ?>
		<input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbutton_peserta" type="button" />
		<input style="padding: 5px;" value=" Refresh Data " id="refreshdatabutton_peserta" type="button" />
		<input style="padding: 5px;display: none;" value=" Print " id="printbutton_peserta" type="button"/>
		<input style="padding: 5px;display: none;" value=" Excel " id="excelbutton_peserta" type="button"/>
        <div id="jqxgrid_peserta"></div>
	</div>
</div>