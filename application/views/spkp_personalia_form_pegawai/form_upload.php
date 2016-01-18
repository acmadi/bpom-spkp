<script type="text/javascript">
    $(document).ready(function(){
       $('#btn_tambah_data, #clearfilteringbutton, #refreshdatabutton').jqxButton({ height: 25, theme: theme });

	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'urut'},
            { name: 'id', type: 'number' },
			{ name: 'id_doc', type: 'number' },
            { name: 'uploader', type: 'number' },
            { name: 'judul', type: 'string' },
            { name: 'filename', type: 'string' },
            { name: 'ket', type: 'string' },
            { name: 'waktu', type: 'date' }
        ],
		url: "<?php echo base_url(); ?>spkp_personalia_form_pegawai/json_cuti_dokumen/{id}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgrid_upload").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid_upload").jqxGrid('updatebounddata', 'sort');
		},
		root: 'Rows',
        pagesize: 5,
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
     
		$("#jqxgrid_upload").jqxGrid(
		{		
			width: '100%',
            height: '200px',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['5', '10', '15'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: false, pageable: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: '#', align: 'center', filtertype: 'none', sortable: false, width: '8%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_upload").jqxGrid('getrowdata', row);
                     if({add_permission}==true || dataRecord.uploader=='<?php echo $this->session->userdata('id')?>'){
                        return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit("+dataRecord.id_doc+");'></a> <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/download.gif' onclick='download("+dataRecord.id_doc+");'></a></div>";
					 }else{
                        return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/download.gif' onclick='download("+dataRecord.id_doc+");'></a></div>";
                     }
                    }
                },
				//Kolom No otomatis menampilkan filed 'urut' hasil query crud->jqxGrid, gunakan format ini untuk mencegah error filter data
				{ text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_upload").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				// END
                { text: 'Tanggal', datafield: 'waktu', columntype: 'date', filtertype: 'none', cellsformat: 'yyyy/MM/dd HH:mm:ss', width: '14%' },
				{ text: 'Judul', datafield: 'judul', columntype: 'textbox', filtertype: 'none', width: '26%' },
                { text: 'Filename', datafield: 'filename', columntype: 'textbox', filtertype: 'none',width: '25%' },
                { text: 'Keterangan', datafield: 'ket', columntype: 'textbox', filtertype: 'none', width: '23%' }
            ]
		});
        
		$('#clearfilteringbutton').click(function () {
			$("#jqxgrid_upload").jqxGrid('clearfilters');
		});
        
 		$('#refreshdatabutton').click(function () {
			$("#jqxgrid_upload").jqxGrid('updatebounddata', 'cells');
		});

	   $('#btn_tambah_data').click(function(){
			$("#popup_upload_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $("#jqxgrid_upload").offset();
			$("#popup_upload").jqxWindow({
				theme: theme, resizable: false, position: { x: 310, y: 250},
                width: 700,
                height: 220,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup_upload").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_personalia_form_pegawai/add_dokumen/{id}" , function(response) {
				$("#popup_upload_content").html("<div>"+response+"</div>");
			});
		});

    });
    
    function edit(id_doc){
		$("#popup_upload_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		var offset = $("#jqxgrid_upload").offset();
		$("#popup_upload").jqxWindow({
			theme: theme, resizable: true, position: { x: 310, y: 250},
			width: 700,
			height: 250,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup_upload").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_personalia_form_pegawai/edit_dokumen/{id}/"+id_doc , function(response) {
			$("#popup_upload_content").html("<div>"+response+"</div>");
		});
	}

	function download(id_doc){
		$("#popup_upload_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		var offset = $("#jqxgrid_upload").offset();
		$("#popup_upload").jqxWindow({
			theme: theme, resizable: true, position: { x: 360, y: 250},
			width: 600,
			height: 220,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup_upload").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_personalia_form_pegawai/download/{id}/"+id_doc , function(response) {
			$("#popup_upload_content").html("<div>"+response+"</div>");
		});
	}

	function close_dialog(){
		$("#popup_upload").jqxWindow('close');
	}
</script>
<div id="popup_upload" style="display:none"><div id="popup_upload_title">Upload Dokumen</div><div id="popup_upload_content"></div></div>
<div style="padding: 5px;">
    <table style="font-size: 14px;color: black;" cellpadding='2'>
        <tr>
            <td>Dokumen {keterangan}</td>
        </tr>
    </table>
</div>
</br>
<div style="padding: 5px;">
	<div>
	   <div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
			<?php if($add_permission){?><input style="padding: 5px;" value="Tambah" id="btn_tambah_data" type="button"/><?php } ?>
    		<input style="padding: 5px;display: none;" value=" Clear Filter " id="clearfilteringbutton" type="button" />
			<input style="padding: 5px;display: none;" value=" Refresh Data " id="refreshdatabutton" type="button" />
            <div id="jqxgrid_upload"></div>
	    </div>
	</div>
</div>