<script type="text/javascript">
    $(document).ready(function(){
       $('#refreshdatabuttonpembinaan, #btnTambahpembinaan').jqxButton({ height: 25, theme: theme });
      
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
            { name: 'institusi', type: 'string' },
            { name: 'kegiatan', type: 'string' }
        ],
		url: "<?php echo base_url(); ?>index.php/spkp_pjas_f2/json_pembinaan/{id}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgridpembinaan").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgridpembinaan").jqxGrid('updatebounddata', 'sort');
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
        
        $("#jqxgridpembinaan").jqxGrid({		
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
				     var dataRecord = $("#jqxgridpembinaan").jqxGrid('getrowdata', row);
                     if({add_permission}==true){
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel_pembinaan("+dataRecord.urut+","+dataRecord.id_sdmi+")'></a>  <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit_pembinaan("+dataRecord.id_sdmi+");'></a></div>";
                     }else{
                        return "<div style='text-align: center;padding:3px'>&nbsp;</div>";
                     }
                }
                },
                { text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgridpembinaan").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				{ text: 'SD/MI', datafield: 'nama', filtertype: 'textbox',  width: '20%' },
                { text: 'NISN', datafield: 'nisn', filtertype: 'textbox',  width: '15%' },
                { text: 'Fasilitator', datafield: 'fasilitator', filtertype: 'textbox',  width: '15%' },
                { text: 'Institusi', datafield: 'institusi', filtertype: 'textbox',  width: '15%' },
                { text: 'Kegiatan', datafield: 'kegiatan', filtertype: 'textbox',  width: '25%' }
            ]
		});
        
		$('#clearfilteringbuttonpembinaan').click(function () {
			$("#jqxgridpembinaan").jqxGrid('clearfilters');
		});
        
        $('#refreshdatabuttonpembinaan').click(function () {
			$("#jqxgridpembinaan").jqxGrid('updatebounddata', 'cells');
		});
        
        $('#btnTambahpembinaan').click(function(){
			$("#popup_pembinaan_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			var w=500; var h=300;
			var x=(screen.width/2)-(w/2);
			var y=(screen.height/2)-(h/2)+$(window).scrollTop();
            $("#popup_pembinaan").jqxWindow({
				theme: theme, resizable: false, position: { x: x, y: y},
                width: w,
                height: h,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
            });
            $("#popup_pembinaan").jqxWindow('open');
			$.get("<?php echo base_url();?>index.php/spkp_pjas_f2/add_pembinaan/{id}" , function(response) {
				$("#popup_pembinaan_content").html("<div>"+response+"</div>");
			});
		});
    });
    
    function edit_pembinaan(id_sdmi){
		$("#popup_pembinaan_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
	    var offset = $("#jqxgridpembinaan").offset();
		var w=500; var h=300;
		var x=(screen.width/2)-(w/2);
		var y=(screen.height/2)-(h/2)+$(window).scrollTop();
        $("#popup_pembinaan").jqxWindow({
			theme: theme, resizable: false, position: { x: x, y: y},
            width: w,
            height: h,
			isModal: true, autoOpen: false, modalOpacity: 0.2
        });
        $("#popup_pembinaan").jqxWindow('open');
		$.get("<?php echo base_url();?>index.php/spkp_pjas_f2/edit_pembinaan/"+id_sdmi , function(response) {
			$("#popup_pembinaan_content").html("<div>"+response+"</div>");
		});
	}

    function dodel_pembinaan(urut,id_sdmi){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_pjas_f2/dodel_pembinaan/"+id_sdmi,
				success: function(response){
					 if(response=="1"){
						 $('#refreshdatabuttonpembinaan').click();
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

	function close_pembinaan_dialog(){
		$("#popup_pembinaan").jqxWindow("close");
	}
</script>
<div id="popup_pembinaan" style="display:none"><div id="popup_pembinaan_title">pembinaan</div><div id="popup_pembinaan_content">{popup_pembinaan}</div></div>
<div>
	<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
		<input style="padding: 5px;" value=" Refresh Data" id="refreshdatabuttonpembinaan" type="button" />
        <?php
        if($add_permission || $id==$this->session->userdata('id')){
            ?>
            <input style="padding: 5px;" value=" Tambah " id="btnTambahpembinaan" type="button" />
            <?php
        }
        ?><div style="margin: 2px;" id="jqxgridpembinaan"></div>
	</div>
</div>