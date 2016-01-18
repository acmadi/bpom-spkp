<script>
$(function(){
	$('#bar_datapjas').click();
	$('#btn_tambah, #clearfilteringbutton, #refreshdatabutton').jqxButton({ height: 25, theme: theme });
	
	
	var source={
	datatype:"json",
	type:"POST",
	datafields:[
		{name:'urut'},
		{name:'id', type:'number'},
		{name:'ttd_nama', type:'string'},
		{name:'ttd_nip', type:'string'},
		{name:'ttd_tmpt', type:'string'},
		{name:'ttd_tgl', type:'date'},
		{name:'id_balai', type:'number'},
		{name:'nama_balai', type:'string'},
		{name:'kegiatan_nama', type:'string'},
		{name:'kegiatan_tgl', type:'date'},
		{name:'kegiatan_tmpt', type:'string'},
		{name:'kegiatan_penyelenggara', type:'string'}
	],
	url: "<?php echo base_url(); ?>spkp_pjas_a007b/json_kegiatan/",
		cache: false,
		updaterow: function (rowid, rowdata, commit){
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
	
	var cellsrenderer = function (row, column, value) {
		var output1 = value.substr(0,8);
		var output2 = value.substr(8,6);
		var output3 = value.substr(14,1);
		var output4 = value.substr(15,3);
		return output1 + " " + output2 + " " + output3 + " " + output4;
	}
	
	var dataadapter = new $.jqx.dataAdapter(source, {
		loadError: function(xhr, status, error){
			alert(error);
		}
	});
		
	$("#jqxgrid").jqxGrid(
	{		
		width: '100%',
		selectionmode: 'singlerow',
		source: dataadapter, theme: theme, columnsresize: true, showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100', '200'],
		showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
		rendergridrows: function(obj)
		{
			return obj.data;    
		},
		columns: [
			{ text: '#', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
				 var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
				 if({add_permission}==true){
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel("+dataRecord.urut+","+dataRecord.id+")'></a>  <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit("+dataRecord.id+");'></a></div>";
                     }else{
                        return "<div style='text-align: center;padding:3px'>&nbsp;</div>";
                     }
				}
			},
			//Kolom No otomatis menampilkan filed 'urut' hasil query crud->jqxGrid, gunakan format ini untuk mencegah error filter data
			{ text: 'No', align: 'center', filtertype: 'none', width: '3%', cellsrenderer: function (row) {
				 var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
				 return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
			 }
			},
			// END
			{ text: 'Balai', datafield: 'nama_balai', columntype: 'list', filtertype: 'list', width: '15%' },
			{ text: 'Tanggal', datafield: 'kegiatan_tgl', columntype: 'date', filtertype: 'date', cellsformat: 'yyyy/MM/dd', width: '8%' },
			{ text: 'Kegiatan', datafield: 'kegiatan_nama', columntype: 'textbox', filtertype: 'textbox', width: '20%' },
			{ text: 'Tempat', datafield: 'kegiatan_tempat', columntype: 'textbox', filtertype: 'textbox', width: '15%' },
			{ text: 'Penyelenggara', datafield: 'kegiatan_penyelenggara', columntype: 'textbox', filtertype: 'textbox', width: '15%' },
			{ text: 'Tanggal TTD', datafield: 'ttd_tgl', columntype: 'date', filtertype: 'date', cellsformat: 'yyyy/MM/dd', width: '8%' }	,
			{ text: 'Penanggung Jawab', datafield: 'ttd_nama', columntype: 'textbox', filtertype: 'textbox', width: '15%' },
			{ text: 'NIP (Penanggung Jawab)', datafield: 'ttd_nip', columntype: 'textbox', filtertype: 'textbox', width: '15%', cellsrenderer: cellsrenderer },
			{ text: 'Tempat TTD', datafield: 'ttd_tmpt', columntype: 'textbox', filtertype: 'textbox', width: '15%' }
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
		var w=600; var h=450;
		var x=(screen.width/2)-(w/2);
		var y=(screen.height/2)-(h/2)+$(window).scrollTop();
		$("#popup").jqxWindow({
			theme: theme, resizable: true, position: { x: x, y: y},
			width: w,
			height: h,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_pjas_a007b/add" , function(response) {
			$("#popup_content").html("<div>"+response+"</div>");
		});
	});
});

	function edit(id){
		window.location.href="<?php echo base_url();?>spkp_pjas_a007b/edit/"+id;
	}
	
	function dodel(urut,id){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_pjas_a007b/dodel/"+id,
				success: function(response){
					 if(response=="1"){
						 $('#clearfilteringbutton').click();
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
<div id="popup" style="display:none"><div id="popup_title">A007b Narasumber Pembinaan Keamanan Pangan Komunitas Sekolah</div><div id="popup_content">{popup}</div></div>
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