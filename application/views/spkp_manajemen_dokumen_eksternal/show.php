<script>
	$(function(){
	   $("#bar_manajemenmutu").addClass("active open");
       $("#qms_dokumen_eksternal").addClass("active");
       $('#btn_tambah, #clearfilteringbutton, #refreshdatabutton, #printbutton, #excelbutton').jqxButton({ height: 25, theme: theme });

       var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
            { name: 'urut'},
            { name: 'id', type: 'string' },
			{ name: 'NO', type: 'string' },
			{ name: 'tipe',  type: 'string' },
            { name: 'judul',  type: 'string' },
            { name: 'pengarang',  type: 'string' },
            { name: 'penerbit',  type: 'string' },
            { name: 'tempat',  type: 'string' },
            { name: 'lama',  type: 'string' }
        ],
		url: "<?php echo base_url(); ?>spkp_manajemen_dokumen_eksternal/json_dokumen",
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
             //   alert(data[0].TotalRows);	
			}
		}
		};		
		var dataadapter = new $.jqx.dataAdapter(source, {
			loadError: function(xhr, status, error){
				alert(error);
			}
		});
		
        $("#jqxgrid").jqxGrid({		
			width: '100%',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true, showtoolbar: true, 
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: '', align: 'center', columntype: 'none', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                     if({add_permission}==true){
					  	return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel("+dataRecord.urut+","+dataRecord.id+","+parseInt(dataRecord.NO)+")'></a> <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit("+dataRecord.id+","+parseInt(dataRecord.NO)+");'></a></div>";
					 }else{
					    return "<div style='width:100%;padding-top:2px;text-align:center'>&nbsp;</div>";
					 }
                 }
                },
                { text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				{ text: '', datafield: 'id', filtertype: 'textbox', width: '5%', cellsalign: 'center' },
				{ text: '', datafield: 'NO', filtertype: 'textbox', width: '5%', cellsalign: 'center' },
				{ text: '', datafield: 'tipe', filtertype: 'textbox', width: '5%', cellsalign: 'center' },
				{ text: 'Judul', datafield: 'judul', filtertype: 'textbox', width: '35%' },
				{ text: 'Pengarang', datafield: 'pengarang', filtertype: 'textbox', width: '21%' },
				{ text: 'Penerbit', datafield: 'penerbit', filtertype: 'textbox', width: '21%' }
			]
		});
        
        $('#clearfilteringbutton').click(function () {
			$("#jqxgrid").jqxGrid('clearfilters');
		});
        
        $('#refreshdatabutton').click(function () {
			$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
		});
        
        $('#btn_tambah').click(function () {
			$("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $("#jqxgrid").offset();
			$("#popup").jqxWindow({
				theme: theme, resizable: false, position: { x: offset.left + 140, y: 100},
                width: 625,
                height: 510,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_manajemen_dokumen_eksternal/add" , function(response) {
				$("#popup_content").html("<div>"+response+"</div>");
			});
		});
        
        $('#printbutton').click(function () {
  			$("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");

			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgrid").jqxGrid('getfilterinformation');
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
				url: "<?php echo base_url();?>spkp_manajemen_dokumen_eksternal/html",
				success: function(response){
					$("#popup_content").html(response);
				}
			 }); 		

			var offset = $(this).offset();
			$("#popup").jqxWindow({
				theme: theme, resizable: false, position: { x: 200, y: offset.top},
				width: 900,
				height: 500,
				isModal: true, autoOpen: false, cancelButton: $("#Cancel"), modalOpacity: 0.2
			});
			$("#popup").jqxWindow('open');
			//END - Creating html view
		});
        
        $('#excelbutton').click(function () {
			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgrid").jqxGrid('getfilterinformation');
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
				url: "<?php echo base_url();?>spkp_manajemen_dokumen_eksternal/excel",
				success: function(response){
					//Download excel file response
					window.open("<?php echo base_url();?>spkp_loader/"+response);
				}
			 }); 		
			//END - Creating excel file
		});
	});
    
    function edit(id,no){
		$("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		var offset = $("#jqxgrid").offset();
		$("#popup").jqxWindow({
			theme: theme, resizable: false, position: { x: offset.left + 140, y: 100},
            width: 625,
            height: 510,
    		isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_manajemen_dokumen_eksternal/edit/"+id+"/"+no , function(response) {
			$("#popup_content").html("<div>"+response+"</div>");
		});
	}
    
	function dodel(urut,id,no){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_manajemen_dokumen_eksternal/dodelete/"+id+"/"+no,
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
		$("#popup").jqxWindow('close');
	}
</script>
<div class="row-fluid">
   <div class="span12">
	   <h3 class="page-title">
		 QMS Dokumen Eksternal
	   </h3>
   </div>
</div>
<div id="popup" style="display:none"><div id="popup_title">QMS Dokumen Eksternal</div><div id="popup_content">{popup}</div></div>
<div>
    <div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
       <?php if($add_permission){?><input style="padding: 5px;" value=" Tambah " id="btn_tambah" type="button"/><?php } ?>
	   <input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbutton" type="button" />
	   <input style="padding: 5px;" value=" Refresh Data " id="refreshdatabutton" type="button" />
	   <input style="padding: 5px;" value=" Print " id="printbutton" type="button" />
	   <input style="padding: 5px;" value=" Excel " id="excelbutton" type="button" />
       <div id="jqxgrid"></div>
    </div>
</div>
