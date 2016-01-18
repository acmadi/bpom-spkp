<script>
$(function(){
    $("#bar_perpustakaan").click();
	$('#btn_tambah, #clearfilteringbutton, #refreshdatabutton, #back').jqxButton({ height: 25, theme: theme });
	
	var source={
	datatype:"json",
	type:"POST",
	datafields:[
		{name:'urut'},
		{name:'file_id', type:'number'},
		{name:'id', type:'number'},
		{name:'lang', type:'string'},
		{name:'title_content', type:'string'},
		{name:'publish', type:'string'},
		{name:'headline', type:'string'},
		{name:'author', type:'string'},
		{name:'waktu', type:'date'},
		{name:'waktu_kegiatan', type:'date'},
		{name:'hits', type:'number'},
		{name:'waktu_update', type:'date'}
	],
		url: "<?php echo base_url(); ?>spkp_gallery_video/json_content/{file_id}",
		cache: false,
		updaterow: function (rowid, rowdata, commit){},
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
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel("+dataRecord.file_id+","+dataRecord.id+")'></a>  <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit("+dataRecord.file_id+","+dataRecord.id+");'></a></div>";
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
			{ text: 'Judul', datafield: 'title_content', columntype: 'textbox', filtertype: 'textbox', width: '35%' },
			{ text: 'Publish', datafield: 'publish', columntype: 'list', filtertype: 'list', width: '8%'},
			{ text: 'Publisher', datafield: 'author', columntype: 'list', filtertype: 'list', width: '15%' },
			{ text: 'Tanggal Buat', datafield: 'waktu', columntype: 'date', filtertype: 'date', cellsformat:'yyyy/MM/dd HH:mm:ss', width: '15%' },
			{ text: 'Hits', datafield: 'hits', columntype: 'textbox', filtertype: 'textbox', width: '5%' },
			{ text: 'Update Terakhir', datafield: 'waktu_update', columntype: 'date', filtertype: 'date', cellsformat:'yyyy/MM/dd HH:mm:ss', width: '15%' }
		]
	});
	
	$('#clearfilteringbutton').click(function () {
		$("#jqxgrid").jqxGrid('clearfilters');
	});
        
	$('#refreshdatabutton').click(function () {
		$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
	});
		
	$('#btn_tambah').click(function(){
		$('#show_content').css('display','none');
		$('#judul').css('display','none');
		$('#divForm').show();
	});
	
	$('#back').click(function(){
		window.location.href="<?php echo base_url().'spkp_gallery_video'; ?>";
	});
});

function edit(file_id,id){
	window.location.href="<?php echo base_url()?>spkp_gallery_video/edit/{mod}/"+file_id+"/"+id;
}

function dodel(file_id,id){
	if(confirm("Anda yakin akan menghapus data ("+id+") ini?")){
		$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>spkp_gallery_video/dodel/{mod}/"+file_id+"/"+id,
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
 <?php if($action=="add"): ?>
 <div id="judul" class="row-fluid">
   <div class="span12">
	   <h3 class="page-title">
		 {title}
	   </h3>
   </div>
</div>
<?php endif; ?>
<div id="popup" style="display:none"><div id="popup_title">{title}</div><div id="popup_content">{popup}</div></div>
<div>
	<div id="show_content" style="width:100%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
        <?php if($add_permission){?><input style="padding: 5px;" value="Tambah" id="btn_tambah" type="button"/><?php } ?>
		<input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbutton" type="button" />
		<input style="padding: 5px;" value=" Refresh Data " id="refreshdatabutton" type="button" />
		<?php if($mod=='video'){?><input style="padding: 5px;" value=" Kembali " id="back" type="button" /><?php } ?> 
        <div id="jqxgrid"></div>
	</div>
	<div style="display: none;" id="divload"></div>
	<div style="display: none;" id="divForm">
	{form}
	</div>
</div>