<script type="text/javascript">
    $(document).ready(function(){
       $('#refreshdatabuttonpengawalan, #btnTambahpengawalan').jqxButton({ height: 25, theme: theme });
      
       var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
            { name: 'urut'},
            { name: 'id', type: 'number' },
            { name: 'id_sdmi', type: 'number' },
            { name: 'nama', type: 'string' },
            { name: 'nisn', type: 'string' },
            { name: 'fasilitator', type: 'string' },
            { name: 'intervensi', type: 'string' },
            { name: 'institusi', type: 'string' },
            { name: 'kegiatan', type: 'string' }
        ],
		url: "<?php echo base_url(); ?>index.php/spkp_pjas_f2/json_pengawalan/{id}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgridpengawalan").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgridpengawalan").jqxGrid('updatebounddata', 'sort');
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
        
        $("#jqxgridpengawalan").jqxGrid({		
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
				     var dataRecord = $("#jqxgridpengawalan").jqxGrid('getrowdata', row);
                     if({add_permission}==true){
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel_pengawalan("+dataRecord.urut+","+dataRecord.id_sdmi+")'></a>  <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit_pengawalan("+dataRecord.id_sdmi+");'></a></div>";
                     }else{
                        return "<div style='text-align: center;padding:3px'>&nbsp;</div>";
                     }
                }
                },
                { text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgridpengawalan").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				{ text: 'SD/MI', datafield: 'nama', filtertype: 'textbox',  width: '20%' },
                { text: 'NISN', datafield: 'nisn', filtertype: 'textbox',  width: '12%' },
                { text: 'Fasilitator', datafield: 'fasilitator', filtertype: 'textbox',  width: '15%' },
                { text: 'Intervensi', datafield: 'intervensi', filtertype: 'textbox',  width: '12%' },
                { text: 'Institusi', datafield: 'institusi', filtertype: 'textbox',  width: '12%' },
                { text: 'Kegiatan', datafield: 'kegiatan', filtertype: 'textbox',  width: '20%' }
            ]
		});
        
		$('#clearfilteringbuttonpengawalan').click(function () {
			$("#jqxgridpengawalan").jqxGrid('clearfilters');
		});
        
        $('#refreshdatabuttonpengawalan').click(function () {
			$("#jqxgridpengawalan").jqxGrid('updatebounddata', 'cells');
		});
        
        $('#btnTambahpengawalan').click(function(){
			$("#popup_pengawalan_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			var w=500; var h=350;
			var x=(screen.width/2)-(w/2);
			var y=(screen.height/2)-(h/2)+$(window).scrollTop();
            $("#popup_pengawalan").jqxWindow({
				theme: theme, resizable: false, position: { x: x, y: y},
                width: w,
                height: h,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
            });
            $("#popup_pengawalan").jqxWindow('open');
			$.get("<?php echo base_url();?>index.php/spkp_pjas_f2/add_pengawalan/{id}" , function(response) {
				$("#popup_pengawalan_content").html("<div>"+response+"</div>");
			});
		});
    });
    
    function edit_pengawalan(id_sdmi){
		$("#popup_pengawalan_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
	    var offset = $("#jqxgridpengawalan").offset();
		var w=500; var h=350;
		var x=(screen.width/2)-(w/2);
		var y=(screen.height/2)-(h/2)+$(window).scrollTop();
        $("#popup_pengawalan").jqxWindow({
			theme: theme, resizable: false, position: { x: x, y: y},
            width: w,
            height: h,
			isModal: true, autoOpen: false, modalOpacity: 0.2
        });
        $("#popup_pengawalan").jqxWindow('open');
		$.get("<?php echo base_url();?>index.php/spkp_pjas_f2/edit_pengawalan/"+id_sdmi , function(response) {
			$("#popup_pengawalan_content").html("<div>"+response+"</div>");
		});
	}

    function dodel_pengawalan(urut,id_sdmi){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_pjas_f2/dodel_pengawalan/"+id_sdmi,
				success: function(response){
					 if(response=="1"){
						 $('#refreshdatabuttonpengawalan').click();
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

	function close_pengawalan_dialog(){
		$("#popup_pengawalan").jqxWindow("close");
	}
</script>
<div id="popup_pengawalan" style="display:none"><div id="popup_pengawalan_title">pengawalan</div><div id="popup_pengawalan_content">{popup_pengawalan}</div></div>
<div>
	<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
		<input style="padding: 5px;" value=" Refresh Data" id="refreshdatabuttonpengawalan" type="button" />
        <?php
        if($add_permission || $id==$this->session->userdata('id')){
            ?>
            <input style="padding: 5px;" value=" Tambah " id="btnTambahpengawalan" type="button" />
            <?php
        }
        ?><div style="margin: 2px;" id="jqxgridpengawalan"></div>
	</div>
</div>