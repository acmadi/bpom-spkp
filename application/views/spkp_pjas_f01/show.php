<script type="text/javascript">
    $(document).ready(function(){
       $("#bar_datapjas").click();
	   $('#btn_tambah, #clearfilteringbutton, #refreshdatabutton').jqxButton({ height: 25, theme: theme });

	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'urut'},
			{ name: 'id', type: 'number' },
            { name: 'tanggal', type: 'string' },
			{ name: 'penanggungjawab_nama', type: 'string' },
            { name: 'penanggungjawab_nip', type: 'string' },
			{ name: 'tmpt', type: 'string' }
	    ],
		url: "<?php echo base_url(); ?>spkp_pjas_f01/json_sebar",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgrid").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid").jqxGrid('updatebounddata', 'sort');
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
     
		$("#jqxgrid").jqxGrid(
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
				     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                     if({add_permission}==true){
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel_sebar("+dataRecord.urut+","+dataRecord.id+")'></a>  <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit_sebar("+dataRecord.id+");'></a></div>";
                     }else{
                        return "<div style='text-align: center;padding:3px'>&nbsp;</div>";
                     }
				    }
                },
				//Kolom No otomatis menampilkan filed 'urut' hasil query crud->jqxGrid, gunakan format ini untuk mencegah error filter data
				{ text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				// END
                { text: 'Tanggal', datafield: 'tanggal', columntype: 'date', filtertype: 'date', width: '15%' },
                { text: 'Penanggung Jawab', datafield: 'penanggungjawab_nama', columntype: 'textbox', filtertype: 'textbox', width: '30%' },
                { text: 'NIP-Penanggung Jawab', datafield: 'penanggungjawab_nip', columntype: 'textbox', filtertype: 'textbox', width: '20%' },
                { text: 'Tempat (Pembuatan Laporan)', datafield: 'tmpt', columntype: 'textbox', filtertype: 'textbox', width: '25%' }
			]
		});
        
		$('#clearfilteringbutton').click(function () {
			$("#jqxgrid").jqxGrid('clearfilters');
		});
        
 		$('#refreshdatabutton').click(function () {
			$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
		});

	   $('#btn_tambah').click(function(){
			$("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			var w=500; var h=225;
			var x=(screen.width/2)-(w/2);
			var y=(screen.height/2)-(h/2)+$(window).scrollTop();
			$("#popup").jqxWindow({
				theme: theme, resizable: true, position: { x: x, y: y }, 
                width: w,
                height: h,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_pjas_f01/add_sebar" , function(response) {
				$("#popup_content").html("<div>"+response+"</div>");
			});
		});
    });
	
	function edit_sebar(id){
		window.location.href = "<?php echo base_url(); ?>spkp_pjas_f01/edit_sebar/"+id;
	}
    
    function dodel_sebar(urut,id){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_pjas_f01/dodel_sebar/"+id,
				success: function(response){
					 if(response=="1"){
						 $('#clearfilteringbutton').click();
                         $('#clearfilteringbutton_target').click();
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

	function close_dialog(){
		$("#popup").jqxWindow("close");
	}
</script>
<div class="row-fluid">
   <div class="span12">
	   <h3 class="page-title">
		 {title}
	   </h3>
   </div>
</div>

<div id="popup" style="display:none"><div id="popup_title">Kegiatan Penyebaran Produk</div><div id="popup_content">{popup}</div></div>
<div>
	<div style="width:100%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
        <?php if($add_permission){?><input style="padding: 5px;" value="Tambah" id="btn_tambah" type="button"/><?php } ?>
		<input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbutton" type="button" />
		<input style="padding: 5px;" value=" Refresh Data " id="refreshdatabutton" type="button" />
        <div id="jqxgrid"></div>
	</div>
	<br>
	<br>
	<br>
</div>