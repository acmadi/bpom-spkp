<script>
	$(function(){
       $("#bar_personalia").click();
       $('#jqxTabs').jqxTabs({ width: '100%', height:'920px', position: 'top', theme: theme });
       $("input[type='button']").jqxButton({ height: 28, theme: theme });
      
       var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
            { name: 'urut'},
            { name: 'id', type: 'number' },
			{ name: 'nip', type: 'string' },
			{ name: 'nama',  type: 'string' },
            { name: 'gelar',  type: 'string' },
            { name: 'gendre',  type: 'string' },
            { name: 'birthdate',  type: 'date' },
            { name: 'birthplace',  type: 'string' },
            { name: 'mobile',  type: 'string' },
        ],
		url: "<?php echo base_url(); ?>spkp_personalia_cuti/json_user",
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
		var cellsrenderer = function (row, column, value) {
			var output1 = value.substr(0,8);
			var output2 = value.substr(8,6);
			var output3 = value.substr(14,1);
			var output4 = value.substr(15,3);
			return "<div style='text-align: center;padding:3px'>"+output1 + " " + output2 + " " + output3 + " " + output4+ "</div>";
		}
     
        $("#jqxgrid").jqxGrid({		
			width: '100%',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: true, pagesizeoptions: ['10', '25', '50', '100', '200'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: 'Detail', align: 'center', columntype: 'none', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                     return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit("+dataRecord.id+");'></a></div>";
                 }
                },
                { text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				{ text: 'Nama', datafield: 'nama', filtertype: 'textbox', width: '27%' },
				{ text: 'NIP', datafield: 'nip', filtertype: 'textbox',  width: '18%', cellsrenderer: cellsrenderer},
                { text: 'Golongan', datafield: 'gelar', filtertype: 'list', width: '8%' },
                { text: 'Sisa Cuti <?php echo (date('Y')-1)?>', filtertype: 'number', width: '12%', cellsalign: 'center' },
                { text: 'Sisa Cuti <?php echo (date('Y'))?>', filtertype: 'number', width: '12%', cellsalign: 'center' },
                { text: 'Sisa Cuti Gabungan', filtertype: 'number', width: '15%', cellsalign: 'center' }
            ]
		});
        
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
		url: "<?php echo base_url(); ?>spkp_personalia_cuti/json_cutibersama",
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
                     return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='cbedit("+dataRecord.id+");'></a> <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='cbdel("+dataRecord.id+");'></a></div>";
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
			$("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			$("#popup").jqxWindow({
				theme: theme, resizable: true, position: { x: offset.left + 80, y: offset.top},
                width: 700,
                height: 250,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_personalia_cuti/add" , function(response) {
				$("#popup_content").html("<div>"+response+"</div>");
			});
		});
        
		$('#clearfilteringbutton').click(function () {
			$("#jqxgrid").jqxGrid('clearfilters');
		});
        
        $('#refreshdatabutton').click(function () {
			$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
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
				url: "<?php echo base_url();?>spkp_personalia_cuti/html",
				success: function(response){
					$("#popup_content").html(response);
				}
			 }); 		

			var offset = $(this).offset();
			$("#popup").jqxWindow({
				theme: theme, resizable: true, position: { x: 200, y: offset.top},
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
				url: "<?php echo base_url();?>spkp_personalia_cuti/excel",
				success: function(response){
					//Download excel file response
					window.open("<?php echo base_url();?>spkp_loader/"+response);
				}
			 }); 		
			//END - Creating excel file
		});
	});

	function edit(id){
		window.location.href = "<?php echo base_url(); ?>spkp_personalia_cuti/detail/"+id;
	}

	function cbedit(id){
		$("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		var offset = $("#jqxgridCB").offset();
		$("#popup").jqxWindow({
			theme: theme, resizable: true, position: { x: offset.left + 80, y: offset.top},
			width: 700,
			height: 250,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_personalia_cuti/edit/"+id , function(response) {
			$("#popup_content").html("<div>"+response+"</div>");
		});
	}

	function cbdel(id){
		if(confirm('Hapus dokumen ini?')){
		
			$("#uploaddiv").hide();
			$("#uploadloader").show("fade");

			$.ajax({ 
				type: "POST",
				cache: false,
				contentType: false,
				processData: false,
				url: "<?php echo base_url()?>spkp_personalia_cuti/dodelete/"+id,
				success: function(response){
					res = response.split("_");
					 if(res[0]=="OK"){
						 $.notific8('Notification', {
						  life: 5000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
						$("#jqxgridCB").jqxGrid('updatebounddata', 'cells');
					 }else{
						 $.notific8('Notification', {
						  life: 5000,
						  message: res[1],
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
<div id="popup" style="display:none"><div id="popup_title">{title}</div><div id="popup_content">{popup}</div></div>
<div id="jqxTabs">
    <ul>
        <li>Cuti Pegawai</li>
        <li>Daftar Hari Libur & Cuti Bersama</li>
    </ul>
    <div style="padding: 2px;">
		<div>
			<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
				<input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbutton" type="button" />
				<input style="padding: 5px;" value=" Refresh Data " id="refreshdatabutton" type="button" />
				<input style="padding: 5px;" value=" Print " id="printbutton" type="button" />
				<input style="padding: 5px;" value=" Excel " id="excelbutton" type="button" />
				<div id="jqxgrid"></div>
			</div>
		</div>
	</div>
    <div style="padding: 2px;">
		<div>
			<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
				<input style="padding: 5px;" value=" Tambah Hari Libur & Cuti Bersama " id="cb_addcutibersama" type="button" />
				<input style="padding: 5px;" value=" Clear Filter " id="cb_clearfilteringbutton" type="button" />
				<input style="padding: 5px;" value=" Refresh Data " id="cb_refreshdatabutton" type="button" />
				<div id="jqxgridCB"></div>
			</div>
		</div>
	</div>
</div>