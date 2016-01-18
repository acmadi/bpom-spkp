<script type="text/javascript">
    $(document).ready(function(){
       $('#refreshdatabuttonsdmi, #btnTambahsdmi, #ExcelButton').jqxButton({ height: 25, theme: theme });
      
       var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
            { name: 'urut'},
            { name: 'id', type: 'number' },
            { name: 'id_sdmi', type: 'number' },
            { name: 'nama', type: 'string' },
            { name: 'nisn', type: 'string' },
            { name: 'intervensi', type: 'string' },
            { name: 'petugas', type: 'string' },
            { name: 'institusi', type: 'string' },
            { name: 'kegiatan', type: 'string' }
        ],
		url: "<?php echo base_url(); ?>index.php/spkp_pjas_a023/json_sdmi/{id}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgridsdmi").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgridsdmi").jqxGrid('updatebounddata', 'sort');
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
        
        $("#jqxgridsdmi").jqxGrid({		
			width: '99%',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: true, pagesizeoptions: ['10', '25', '50', '100', '200'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: 'Proses', align: 'center', columntype: 'none', filtertype: 'none', sortable: false, width: '5%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgridsdmi").jqxGrid('getrowdata', row);
                     if({add_permission}==true){
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel_sdmi("+dataRecord.urut+","+dataRecord.id_sdmi+")'></a>  <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit_sdmi("+dataRecord.id_sdmi+");'></a></div>";
                     }else{
                        return "<div style='text-align: center;padding:3px'>&nbsp;</div>";
                     }
                }
                },
                { text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgridsdmi").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				{ text: 'SD/MI', datafield: 'nama', filtertype: 'textbox',  width: '15%' },
                { text: 'NISN', datafield: 'nisn', filtertype: 'textbox',  width: '12%' },
                { text: 'Intervensi', datafield: 'intervensi', filtertype: 'textbox',  width: '15%' },
                { text: 'Petugas', datafield: 'petugas', filtertype: 'textbox',  width: '12%' },
                { text: 'Institusi', datafield: 'institusi', filtertype: 'textbox',  width: '12%' },
                { text: 'Kegiatan', datafield: 'kegiatan', filtertype: 'textbox',  width: '25%' }
            ]
		});
        
		$('#clearfilteringbuttonsdmi').click(function () {
			$("#jqxgridsdmi").jqxGrid('clearfilters');
		});
        
        $('#refreshdatabuttonsdmi').click(function () {
			$("#jqxgridsdmi").jqxGrid('updatebounddata', 'cells');
		});
        
        $('#btnTambahsdmi').click(function(){
			$("#popup_sdmi_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			var w=500; var h=350;
            $("#popup_sdmi").jqxWindow({
				theme: theme, resizable: false, position: { x: (screen.width/2)-(w/2), y: (screen.height/2)-(h/2)+$(window).scrollTop()},
                width: 500,
                height: 350,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
            });
            $("#popup_sdmi").jqxWindow('open');
			$.get("<?php echo base_url();?>index.php/spkp_pjas_a023/add_sdmi/{id}" , function(response) {
				$("#popup_sdmi_content").html("<div>"+response+"</div>");
			});
		});
	});
    
    function edit_sdmi(id_sdmi){
		$("#popup_sdmi_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
	    var offset = $("#jqxgridsdmi").offset();
		var w=500; var h=350;
        $("#popup_sdmi").jqxWindow({
			theme: theme, resizable: false, position: { x: (screen.width/2)-(w/2), y: (screen.height/2)-(h/2)+$(window).scrollTop() },
            width: 500,
            height: 350,
			isModal: true, autoOpen: false, modalOpacity: 0.2
        });
        $("#popup_sdmi").jqxWindow('open');
		$.get("<?php echo base_url();?>index.php/spkp_pjas_a023/edit_sdmi/"+id_sdmi , function(response) {
			$("#popup_sdmi_content").html("<div>"+response+"</div>");
		});
	}

    function dodel_sdmi(urut,id_sdmi){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_pjas_a023/dodel_sdmi/"+id_sdmi,
				success: function(response){
					 if(response=="1"){
						 $('#refreshdatabuttonsdmi').click();
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

	function close_sdmi_dialog(){
		$("#popup_sdmi").jqxWindow("close");
	}
</script>
<div id="popup_sdmi" style="display:none"><div id="popup_sdmi_title">sdmi</div><div id="popup_sdmi_content">{popup_sdmi}</div></div>
<div>
	<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
		<input style="padding: 5px;" value=" Refresh Data" id="refreshdatabuttonsdmi" type="button" />
        <?php
        if($add_permission || $id==$this->session->userdata('id')){
            ?>
            <input style="padding: 5px;" value=" Tambah " id="btnTambahsdmi" type="button" />
            <?php
        }
        ?>
		<!--input style="padding: 5px;" value=" Excel " id="excelbutton" type="button" /-->
		<div style="margin: 2px;" id="jqxgridsdmi"></div>
	</div>
</div>