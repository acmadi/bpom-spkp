<script>
	$(function(){
      var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
            { name: 'urut'},
            { name: 'id', type: 'string' },
			{ name: 'tgl', type: 'date' },
			{ name: 'status', type: 'string' },
			{ name: 'keterangan',  type: 'string' },
        ],
		url: "<?php echo base_url(); ?>spkp_personalia_form_pegawai/json_cutibersama",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgridCB").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgridCB").jqxGrid('updatebounddata', 'sort');
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

		$("#jqxgridCB").jqxGrid({		
			width: '100%',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: true, pagesizeoptions: ['10', '25', '50', '100', '200'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: 'Detail', align: 'center', columntype: 'none', filtertype: 'none', sortable: false, width: '5%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgridCB").jqxGrid('getrowdata', row);
                     return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='cbedit("+dataRecord.id+");'></a> <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='cbdel("+dataRecord.urut+","+dataRecord.id+");'></a></div>";
                 }
                },
				{ text: 'No', datafield: 'urut', align: 'center', columntype: 'none', filtertype: 'none',  width: '5%', cellsalign: 'center' },
				{ text: 'Tanggal', datafield: 'tgl', columntype: 'date', filtertype: 'date', cellsalign: 'center', cellsformat: 'yyyy-MM-dd', width: '15%' },
                { text: 'Status', datafield: 'status', filtertype: 'list', width: '15%'},
                { text: 'Keterangan', datafield: 'keterangan', filtertype: 'textbox', width: '60%'}
            ]
		});
        
		$('#cb_clearfilteringbutton').click(function () {
			$("#jqxgridCB").jqxGrid('clearfilters');
		});
        
        $('#cb_refreshdatabutton').click(function () {
			$("#jqxgridCB").jqxGrid('updatebounddata', 'cells');
		});

		$('#cb_addcutibersama').click(function () {
			$("#popup_cuti_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $("#jqxgridCB").offset();
			$("#popup_cuti").jqxWindow({
				theme: theme, resizable: true, position: { x: offset.left + 140, y: offset.top},
                width: 570,
                height: 250,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup_cuti").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_personalia_form_pegawai/add_cuti_bersama" , function(response) {
				$("#popup_cuti_content").html("<div>"+response+"</div>");
			});
		});
    });

	function cbedit(id){
		$("#popup_cuti_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		var offset = $("#jqxgridCB").offset();
		$("#popup_cuti").jqxWindow({
			theme: theme, resizable: true, position: { x: offset.left + 140, y: offset.top},
			width: 570,
			height: 250,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup_cuti").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_personalia_form_pegawai/edit_cuti_bersama/"+id , function(response) {
			$("#popup_cuti_content").html("<div>"+response+"</div>");
		});
	}

	function cbdel(urut,id){
		if(confirm("Hapus data ini ("+urut+") ?")){
		    $("#uploaddiv").hide();
			$("#uploadloader").show("fade");
            $.ajax({ 
				type: "POST",
				cache: false,
				contentType: false,
				processData: false,
				url: "<?php echo base_url()?>spkp_personalia_form_pegawai/dodelete_cuti_bersama/"+id,
				success: function(response){
					 if(response=="1"){
						 $.notific8('Notification', {
						  life: 5000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
						$("#jqxgridCB").jqxGrid('updatebounddata', 'cells');
                        $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
					 }else{
						 $.notific8('Notification', {
						  life: 5000,
						  message: response,
						  heading: 'Saving data FAIL',
						  theme: 'red2'
						});
					 }
					$("#uploadloader").hide();
					$("#uploaddiv").show("fade");
				}
			 }); 
		}				 
	}

	function close_dialog(){
		$("#popup_cuti").jqxWindow("close");
	}
</script>
<div id="popup_cuti" style="display:none"><div id="popup_cuti_title">Hari Libur dan Cuti Bersama</div><div id="popup_cuti_content">{popup}</div></div>
		<div>
			<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
				<input style="padding: 5px;" value=" Tambah Hari Libur & Cuti Bersama " id="cb_addcutibersama" type="button" />
				<input style="padding: 5px;" value=" Clear Filter " id="cb_clearfilteringbutton" type="button" />
				<input style="padding: 5px;" value=" Refresh Data " id="cb_refreshdatabutton" type="button" />
				<div id="jqxgridCB"></div>
			</div>
		</div>