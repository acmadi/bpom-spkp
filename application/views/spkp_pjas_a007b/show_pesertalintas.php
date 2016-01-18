<script type="text/javascript">
    $(document).ready(function(){
       $('#refreshdatabuttonpesertalintas, #btnTambahpesertalintas').jqxButton({ height: 25, theme: theme });
      
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
		url: "<?php echo base_url(); ?>index.php/spkp_pjas_a007b/json_pesertalintas/{id}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgridpesertalintas").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgridpesertalintas").jqxGrid('updatebounddata', 'sort');
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
        
        $("#jqxgridpesertalintas").jqxGrid({		
			width: '99%',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true, showtoolbar: true, pagesizeoptions: ['10', '25', '50', '100', '200'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: 'Proses', align: 'center', columntype: 'none', filtertype: 'none', sortable: false, width: 55, cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgridpesertalintas").jqxGrid('getrowdata', row);
                     if({add_permission}==true){
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel_pesertalintas("+dataRecord.urut+","+dataRecord.id_peserta+")'></a> <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit_pesertalintas("+dataRecord.id_peserta+")'></a></div>";
                     }else{
                        return "<div style='text-align: center;padding:3px'>&nbsp;</div>";
                     }
                }
                },
                { text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgridpesertalintas").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				{ text: 'Nama', datafield: 'nama', filtertype: 'textbox',  width: '30%' },
				{ text: 'Instansi', datafield: 'instansi', filtertype: 'textbox',  width: '40%' }
            ]
		});
        
		$('#clearfilteringbuttonpesertalintas').click(function () {
			$("#jqxgridpesertalintas").jqxGrid('clearfilters');
		});
        
        $('#refreshdatabuttonpesertalintas').click(function () {
			$("#jqxgridpesertalintas").jqxGrid('updatebounddata', 'cells');
		});
        
        $('#btnTambahpesertalintas').click(function(){
			$("#popup_pesertalintas_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			var w=500; var h=200;
			var x=(screen.width/2)-(w/2);
			var y=(screen.height/2)-(h/2)+$(window).scrollTop();
            $("#popup_pesertalintas").jqxWindow({
				theme: theme, resizable: false, position: { x: x, y: y},
                width: w,
                height: h,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
            });
            $("#popup_pesertalintas").jqxWindow('open');
			$.get("<?php echo base_url();?>index.php/spkp_pjas_a007b/add_pesertalintas/{id}" , function(response) {
				$("#popup_pesertalintas_content").html("<div>"+response+"</div>");
			});
		});
    });
	
	function edit_pesertalintas(id_peserta){
			$("#popup_pesertalintas_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			var w=500; var h=200;
			var x=(screen.width/2)-(w/2);
			var y=(screen.height/2)-(h/2)+$(window).scrollTop();
            $("#popup_pesertalintas").jqxWindow({
				theme: theme, resizable: false, position: { x: x, y: y},
                width: w,
                height: h,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
            });
            $("#popup_pesertalintas").jqxWindow('open');
			$.get("<?php echo base_url();?>index.php/spkp_pjas_a007b/edit_pesertalintas/"+id_peserta , function(response) {
				$("#popup_pesertalintas_content").html("<div>"+response+"</div>");
			});
		}

    function dodel_pesertalintas(urut,id_peserta){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_pjas_a007b/dodel_pesertalintas/"+id_peserta,
				success: function(response){
					 if(response=="1"){
						 $('#refreshdatabuttonpesertalintas').click();
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

	function close_pesertalintas_dialog(){
		$("#popup_pesertalintas").jqxWindow("close");
	}
</script>
<div id="popup_pesertalintas" style="display:none"><div id="popup_pesertalintas_title">Peserta Lintas</div><div id="popup_pesertalintas_content">{popup_pesertalintas}</div></div>
<div>
	<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
		<?php
        if($add_permission || $id==$this->session->userdata('id')){
            ?>
            <input style="padding: 5px;" value=" Tambah " id="btnTambahpesertalintas" type="button" />
            <?php
        }
        ?><input style="padding: 5px;" value=" Refresh Data" id="refreshdatabuttonpesertalintas" type="button" />
        <div style="margin: 2px;" id="jqxgridpesertalintas"></div>
	</div>
	<br>
	<br>
	<br>
</div>