<script>
	$(function(){
		$('#aksinasional')
		$('#btn_tambah_target, #clearfilteringbutton_target, #refreshdatabutton_target, #printbutton_target, #excelbutton_target').jqxButton({ height: 25, theme: theme });

	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'urut'},
			{ name: 'id', type: 'number' },
            { name: 'id_target', type: 'number' },
			{ name: 'nama', type: 'string' },
            { name: 'alamat', type: 'string' },
            { name: 'target', type: 'string' },
            { name: 'produk', type: 'string' },
            { name: 'jumlah',  type: 'number' }
        ],
		url: "<?php echo base_url(); ?>spkp_pjas_f01/json_target/{id}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgrid_target").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid_target").jqxGrid('updatebounddata', 'sort');
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
     
		$("#jqxgrid_target").jqxGrid(
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
				{ text: '#', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_target").jqxGrid('getrowdata', row);
					 if({add_permission}==true || dataRecord.uploader=='<?php echo $this->session->userdata('id')?>'){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel_target("+dataRecord.urut+","+dataRecord.id+","+dataRecord.id_target+");'></a> <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit_target("+dataRecord.id+","+dataRecord.id_target+");'></a></div>";
					 }
                 }
                },
				//Kolom No otomatis menampilkan filed 'urut' hasil query crud->jqxGrid, gunakan format ini untuk mencegah error filter data
				{ text: 'No', align: 'center', filtertype: 'none', width: '5%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid_target").jqxGrid('getrowdata', row);
                     return "<div style='padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				// END
				{ text: 'Nama', datafield: 'nama', columntype: 'textbox', filtertype: 'teboxxt', width: '31%' },
			    { text: 'Alamat', datafield: 'alamat', columntype: 'textbox', filtertype: 'textbox', width: '15%' },
                { text: 'Target', datafield: 'target', columntype: 'textbox', filtertype: 'textbox', width: '15%' },
				{ text: 'Produk', datafield: 'produk', columntype: 'textbox', filtertype: 'textbox', width: '20%' },
				{ text: 'Jumlah', datafield: 'jumlah', filtertype: 'textbox', columntype: 'textbox', width: '10%' }
            ]
		});
        
		$('#clearfilteringbutton_target').click(function () {
			$("#jqxgrid_target").jqxGrid('clearfilters');
		});
        
 		$('#refreshdatabutton_target').click(function () {
			$("#jqxgrid_target").jqxGrid('updatebounddata', 'cells');
		});

	   $('#btn_tambah_target').click(function(){
			$("#popup_content_target").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			var w=400; var h=300;
			var x=(screen.width/2)-(w/2);
			var y=(screen.height/2)-(h/2)+$(window).scrollTop();
			$("#popup_target").jqxWindow({
				theme: theme, resizable: true, position: { x: x, y: y},
                width: w,
                height: h,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup_target").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_pjas_f01/add_target/{id}" , function(response) {
				$("#popup_content_target").html("<div>"+response+"</div>");
			});
		});

		$('#printbutton_target').click(function () {
  			$("#popup_content_target").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");

			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgrid_target").jqxGrid('getfilterinformation');
			k=0;
			for (i = 0; i < filter.length; i++) {
				var filters = filter[i].filter.getfilters();
				var datafield = filter[i].filtercolumn;
				for (j = 0; j < filters.length; j++) {
					if(filters[j].type=='datefilter'){
						var now = new Date(filters[j].value);
						var thn = now.getFullYear();
						var bln = now.getMonth()+1;
						var tgl = now.getDate();
						var jam = now.getHours();
						var menit = now.getMinutes();
						var detik = now.getSeconds();

						if(bln<10) bln = "0"+bln;
						if(tgl<10) tgl = "0"+tgl;
						if(jam<10) jam = "0"+jam;
						if(menit<10) menit = "0"+menit;
						if(detik<10) detik = "0"+detik;
						var value = thn+"/"+bln+"/"+tgl+" "+jam+":"+menit+":"+detik;
					}else{
						var value = filters[j].value;
					}
					var condition = filters[j].condition;
					var operator = filters[j].operator;
					datastring +='&filtervalue'+k+'=' + value + '&filtercondition'+k+'=' + condition + '&filterdatafield'+k+'=' + datafield+ '&filteroperator'+k+'='+ operator;
					k++;
				}
				datastring +='&'+datafield+'operator=and';
			}
			//END - Collecting filter information into querystring

			//Creating html view
			$.ajax({ 
				type: "POST",
				data: datastring+'&filterscount='+k,
				url: "<?php echo base_url();?>spkp_pjas_f01/html_target/"+id,
				success: function(response){
					$("#popup_content_target").html(response);
				}
			 }); 		

			var offset = $(this).offset();
			$("#popup_target").jqxWindow({
				theme: theme, resizable: true, position: { x: 100, y: 100},
				width: 900,
				height: 500,
				isModal: true, autoOpen: false, cancelButton: $("#Cancel"), modalOpacity: 0.2
			});
			$("#popup_target").jqxWindow('open');
			//END - Creating html view
		});
	});

	function edit_target(id,id_target){
		$("#popup_content_target").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		var offset = $("#jqxgrid_target").offset();
		var w=400; var h=300;
		var x=(screen.width/2)-(w/2);
		var y=(screen.height/2)-(h/2)+$(window).scrollTop();
		$("#popup_target").jqxWindow({
			theme: theme, resizable: true, position: { x: x, y: y},
			width: w,
			height: h,
		isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup_target").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_pjas_f01/edit_target/{id}/"+id_target , function(response) {
			$("#popup_content_target").html("<div>"+response+"</div>");
		});
	}
	
	function save_edit_peserta_dialog(content){
	   	$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_f01/doedit_target",
			data: content,
			success: function(response){
				 if(response=="1sss"){
					 close_peserta_dialog();
					 $('#refreshdatabutton_target').click();
					 $.notific8('Notification', {
					  life: 5000,
					  message: 'Save data succesfully.',
					  heading: 'Saving data',
					  theme: 'lime'
					});
				 }else{
					 $.notific8('Notification', {
					  life: 5000,
					  message: response,
					  heading: 'Saving data FAIL',
					  theme: 'red'
					});
				 }
			}
		 }); 		
	}
	
	function dodel_target(urut,id,id_target){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_pjas_f01/dodel_target/{id}/"+id_target,
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
	
	function close_dialog_target(s){
		$("#popup_target").jqxWindow('close');
		if(s==1){
			$("#jqxgrid_target").jqxGrid('updatebounddata', 'cells');
		}
	}
</script>
<div id="popup_target" style="display:none"><div id="popup_title_target">Target</div><div id="popup_content_target">{popup}</div></div>
<div>
	<div style="width:100%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
        <?php if($add_permission){?><input style="padding: 5px;" value="Tambah" id="btn_tambah_target" type="button"/><?php } ?>
		<input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbutton_target" type="button" />
		<input style="padding: 5px;" value=" Refresh Data " id="refreshdatabutton_target" type="button" />
		<input style="padding: 5px;" value=" Print " id="printbutton_target" type="button" />
        <div id="jqxgrid_target"></div>
	</div>
</div>