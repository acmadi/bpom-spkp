<script type="text/javascript">
    $(document).ready(function(){
       $('#refreshdatabuttonpeserta, #btnTambahpeserta').jqxButton({ height: 25, theme: theme });
      
       var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
            { name: 'urut'},
            { name: 'id', type: 'number' },
            { name: 'id_peserta', type: 'number' },
            { name: 'nama', type: 'string' },
            { name: 'status', type: 'string' },
            { name: 'akreditasi', type: 'string' },
            { name: 'keterangan', type: 'string' }
        ],
		url: "<?php echo base_url(); ?>index.php/spkp_pjas_a007b/json_peserta/{id}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgridpeserta").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgridpeserta").jqxGrid('updatebounddata', 'sort');
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
        
        $("#jqxgridpeserta").jqxGrid({		
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
				     var dataRecord = $("#jqxgridpeserta").jqxGrid('getrowdata', row);
                     if({add_permission}==true){
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel_peserta("+dataRecord.urut+","+dataRecord.id_peserta+")'></a> <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit_peserta("+dataRecord.id_peserta+")'></a></div>";
                     }else{
                        return "<div style='text-align: center;padding:3px'>&nbsp;</div>";
                     }
                }
                },
                { text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgridpeserta").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				{ text: 'Nama SD/MI', datafield: 'nama', filtertype: 'textbox',  width: '30%' },
				{ text: 'Status', datafield: 'status', filtertype: 'list',  width: '20%' },
				{ text: 'Akreditasi', datafield: 'akreditasi', filtertype: 'textbox',  width: '10%' },
				{ text: 'Keterangan', datafield: 'keterangan', filtertype: 'textbox',  width: '30%' }
            ]
		});
        
		$('#clearfilteringbuttonpeserta').click(function () {
			$("#jqxgridpeserta").jqxGrid('clearfilters');
		});
        
        $('#refreshdatabuttonpeserta').click(function () {
			$("#jqxgridpeserta").jqxGrid('updatebounddata', 'cells');
		});
        
        $('#btnTambahpeserta').click(function(){
			$("#popup_peserta_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			var w=400; var h=300;
			var x=(screen.width/2)-(w/2);
			var y=(screen.height/2)-(h/2)+$(window).scrollTop();
            $("#popup_peserta").jqxWindow({
				theme: theme, resizable: false, position: { x: x, y: y},
                width: w,
                height: h,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
            });
            $("#popup_peserta").jqxWindow('open');
			$.get("<?php echo base_url();?>index.php/spkp_pjas_a007b/add_peserta/{id}" , function(response) {
				$("#popup_peserta_content").html("<div>"+response+"</div>");
			});
		});
    });
	
	function edit_peserta(id_peserta){
			$("#popup_peserta_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			var w=400; var h=300;
			var x=(screen.width/2)-(w/2);
			var y=(screen.height/2)-(h/2)+$(window).scrollTop();
            $("#popup_peserta").jqxWindow({
				theme: theme, resizable: false, position: { x: x, y: y},
                width: w,
                height: h,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
            });
            $("#popup_peserta").jqxWindow('open');
			$.get("<?php echo base_url();?>index.php/spkp_pjas_a007b/edit_peserta/"+id_peserta , function(response) {
				$("#popup_peserta_content").html("<div>"+response+"</div>");
			});
		}

    function dodel_peserta(urut,id_peserta){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_pjas_a007b/dodel_peserta/"+id_peserta,
				success: function(response){
					 if(response=="1"){
						 $('#refreshdatabuttonpeserta').click();
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
<div id="popup_peserta" style="display:none"><div id="popup_peserta_title">peserta</div><div id="popup_peserta_content">{popup_peserta}</div></div>
<div>
	<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
		<?php
        if($add_permission || $id==$this->session->userdata('id')){
            ?>
            <input style="padding: 5px;" value=" Tambah " id="btnTambahpeserta" type="button" />
            <?php
        }
        ?><input style="padding: 5px;" value=" Refresh Data" id="refreshdatabuttonpeserta" type="button" />
        <div style="margin: 2px;" id="jqxgridpeserta"></div>
	</div>
	<br>
	<br>
	<br>
</div>