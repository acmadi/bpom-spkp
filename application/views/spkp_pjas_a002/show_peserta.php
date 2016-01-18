<script type="text/javascript">
    $(document).ready(function(){
       $('#refreshdatabuttonPeserta, #btnTambahPeserta').jqxButton({ height: 25, theme: theme });
      
       var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
            { name: 'urut'},
            { name: 'id', type: 'number' },
            { name: 'id_peserta', type: 'number' },
            { name: 'nama', type: 'string' },
            { name: 'instansi', type: 'string' }
        ],
		url: "<?php echo base_url(); ?>index.php/spkp_pjas_a002/json_peserta/{id}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgridPeserta").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgridPeserta").jqxGrid('updatebounddata', 'sort');
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
        
        $("#jqxgridPeserta").jqxGrid({		
			width: '99%',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: true, pagesizeoptions: ['10', '25', '50', '100', '200'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: 'Proses', align: 'center', columntype: 'none', filtertype: 'none', sortable: false, width: 55, cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgridPeserta").jqxGrid('getrowdata', row);
                     if({add_permission}==true || dataRecord.id=='<?php echo $this->session->userdata('id')?>'){
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel_peserta("+dataRecord.urut+","+dataRecord.id+","+dataRecord.id_peserta+")'></a>  <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit_peserta("+dataRecord.id+","+dataRecord.id_peserta+");'></a></div>";
                     }else{
                        return "<div style='text-align: center;padding:3px'>&nbsp;</div>";
                     }
                }
                },
                { text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgridPeserta").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				{ text: 'Nama', datafield: 'nama', filtertype: 'textbox',  width: 300 },
                { text: 'Instansi', datafield: 'instansi', filtertype: 'textbox',  width: 400 }
            ]
		});
        
		$('#clearfilteringbuttonPeserta').click(function () {
			$("#jqxgridPeserta").jqxGrid('clearfilters');
		});
        
        $('#refreshdatabuttonPeserta').click(function () {
			$("#jqxgridPeserta").jqxGrid('updatebounddata', 'cells');
		});
        
        $("#btnBackPangkat").click(function(){
           window.location.href = "<?php echo base_url(); ?>spkp_pjas_a002"; 
        });
        
        $('#btnTambahPeserta').click(function(){
			$("#popup_peserta_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			var w=450; var h=225;
			var x=(screen.width/2)-(w/2);
			var y=(screen.height/2)-(h/2)+$(window).scrollTop();
            $("#popup_peserta").jqxWindow({
				theme: theme, resizable: false, position: { x: x, y: y},
                width: w,
                height: h,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
            });
            $("#popup_peserta").jqxWindow('open');
			$.get("<?php echo base_url();?>index.php/spkp_pjas_a002/add_peserta" , function(response) {
				$("#popup_peserta_content").html("<div>"+response+"</div>");
			});
		});
    });
    
    function edit_peserta(id,id_peserta){
		$("#popup_peserta_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
	    var offset = $("#jqxgridPeserta").offset();
		var w=450; var h=225;
		var x=(screen.width/2)-(w/2);
		var y=(screen.height/2)-(h/2)+$(window).scrollTop();
		$("#popup_peserta").jqxWindow({
			theme: theme, resizable: false, position: { x: x, y: y},
			width: w,
			height: h,
			isModal: true, autoOpen: false, modalOpacity: 0.2
        });
        $("#popup_peserta").jqxWindow('open');
		$.get("<?php echo base_url();?>index.php/spkp_pjas_a002/edit_peserta/"+id+"/"+id_peserta , function(response) {
			$("#popup_peserta_content").html("<div>"+response+"</div>");
		});
	}

	function save_edit_peserta_dialog(content){
	   	$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a002/doedit_peserta",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_peserta_dialog();
					 $('#refreshdatabuttonPeserta').click();
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
			url: "<?php echo base_url()?>index.php/spkp_pjas_a002/doadd_peserta/{id}",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_peserta_dialog();
					 $('#refreshdatabuttonPeserta').click();
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
    
    function dodel_peserta(urut,id,id_peserta){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_pjas_a002/dodel_peserta/"+id+"/"+id_peserta,
				success: function(response){
					 if(response=="1"){
						 $('#refreshdatabuttonPeserta').click();
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

	function close_peserta_dialog(){
		$("#popup_peserta").jqxWindow("close");
	}
</script>
<div id="popup_peserta" style="display:none"><div id="popup_peserta_title">Peserta</div><div id="popup_peserta_content">{popup_peserta}</div></div>
<div>
	<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
		<input style="padding: 5px;" value=" Refresh Data" id="refreshdatabuttonPeserta" type="button" />
        <?php
        if($add_permission || $id==$this->session->userdata('id')){
            ?>
            <input style="padding: 5px;" value=" Tambah " id="btnTambahPeserta" type="button" />
            <?php
        }
        ?><div style="margin: 2px;" id="jqxgridPeserta"></div>
	</div>
	<br>
	<br>
	<br>
</div>