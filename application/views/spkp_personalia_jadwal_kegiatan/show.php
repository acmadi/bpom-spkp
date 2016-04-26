<script>
	$(function(){
       $("#bar_personalia").addClass("active open");
       $("#jadwal_kegiatan").addClass("active");
       $('#jqxTabs').jqxTabs({ width: '100%', height:'1020px', position: 'top', theme: theme });
       $("input[type='button']").jqxButton({ height: 28, theme: theme });
      
       var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
            { name: 'urut'},
            { name: 'id', type: 'number' },
			{ name: 'nip', type: 'string' },
			{ name: 'nama',  type: 'string' },
            { name: 'JADWAL',  type: 'string' },
        ],
		url: "<?php echo base_url(); ?>spkp_personalia_jadwal_kegiatan/json_jadwal/{thn}/{bln}",
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
        pagesize: 50,
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
		var cutibersama = [ {cutibersama} ];
		var liburnasional = [ {liburnasional} ];
		var holiday = [ {holiday} ];

        $("#jqxgrid").jqxGrid({		
			width: '100%',
			selectionmode: 'singlerow',enabletooltips: true,
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: true, pagesizeoptions: ['50', '100', '200'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: '#', align: 'center', columntype: 'none', filtertype: 'none', sortable: false, width: '26', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                     return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit("+dataRecord.id+");'></a></div>";
                 }
                },
                { text: 'No', align: 'center', filtertype: 'none', width: '26', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				{ text: 'Nama', align: 'center', datafield: 'nama', filtertype: 'textbox', width: '130' },
				<?php for($i=1;$i<=$tgl_limit;$i++){ ?>
                { text: '<?php echo $i?>', filtertype: 'none', cellalign:'center', align:'center', width: '{tgl_width}',columngroup: 'Tanggal', cellsrenderer: function (row) {
					 var I = '<?php echo ($i<10 ? "0".$i:$i)?>';
				     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
					 if(jQuery.inArray( '<?php echo $i?>', cutibersama )>-1){
						return "<div style='width:100%;height:100%;background:#ffffff;color:333333;padding-top:6px;text-align:center;font-size:10px'>cb</div>";
					 }
					 else if(jQuery.inArray( '<?php echo $i?>', liburnasional )>-1){
						return "<div style='width:100%;height:100%;background:#ffffff;color:333333;padding-top:6px;text-align:center;font-size:10px'>#</div>";
					 }
					 else if(jQuery.inArray( '<?php echo $i?>', holiday )>-1){
						return "<div style='width:100%;height:100%;background:#ffffff;color:333333;padding-top:6px;text-align:center;font-size:10px'>X</div>";
					 }
					 else{
						 if(dataRecord.JADWAL){
							var tglx = new Array();
							tgl = (dataRecord.JADWAL).split(",");

							for (i = 0; i < tgl.length; i++) {
								tmp = (tgl[i]).split("__");
								x = tmp[0].split("-");
								tglx[x[2]]=tmp;
							}

							if(tglx[I]){
								if(tglx[I][2]=="-" && tglx[I][1]!=""){
									kode = tglx[I][1];
								}else{
									kode = tglx[I][2];
								}
								return "<div style='width:100%;height:100%;background:"+tglx[I][3]+";color:"+tglx[I][4]+";padding-top:6px;text-align:center;font-size:10px'>"+kode+"</div>";
							}else{
								return "<div style='width:100%;height:100%;background:#ffff;color:black;padding-top:6px;text-align:center;font-size:10px'>&nbsp;</div>";
							}
						 }else{
							return "<div style='width:100%;height:100%;background:#ffff;color:black;padding-top:6px;text-align:center;font-size:10px'>&nbsp;</div>";
						 }
					 }
                 }
				},
				<?php } ?>
            ],
			columngroups: 
                [
                  { text: 'Tanggal', align: 'center', name: 'Tanggal' }
				],
			rendertoolbar: function (toolbar) {
				var me = this;
				var container = $("<div style='margin: 5px;'></div>");
				var thn = $("<span style='float: left; margin-top: 5px; margin-right: 4px;'>&nbsp;&nbsp;Tahun: </span>");
				var thninput = $("<select class='jqx-input jqx-widget-content jqx-rc-all' id='filter_thn' name='filter_thn' style='height: 23px; float: left; width: 80px;' >{option_thn}</select>");
				var bln = $("<span style='float: left; margin-top: 5px; margin-right: 4px;'>&nbsp;&nbsp;Bulan: </span>");
				var blninput = $("<select class='jqx-input jqx-widget-content jqx-rc-all' id='filter_thn' name='filter_bln' style='height: 23px; float: left; width: 80px;' >{option_bln}</select>");

				toolbar.append(container);
				container.append(thn);
				container.append(thninput);
				container.append(bln);
				container.append(blninput);
				thninput.change(function(){
					window.location.href="<?php echo base_url(); ?>spkp_personalia_jadwal_kegiatan/index/"+thninput.val()+"/"+blninput.val();
				});
				blninput.change(function(){
					window.location.href="<?php echo base_url(); ?>spkp_personalia_jadwal_kegiatan/index/"+thninput.val()+"/"+blninput.val();
				});
			}
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
						var value = thn+"-"+bln+"-"+tgl;
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
				url: "<?php echo base_url();?>spkp_personalia_jadwal_kegiatan/html/{thn}/{bln}",
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
						var value = thn+"-"+bln+"-"+tgl;
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
				url: "<?php echo base_url();?>spkp_personalia_jadwal_kegiatan/excel/{thn}/{bln}",
				success: function(response){
					//Download excel file response
					window.open("<?php echo base_url();?>spkp_loader/"+response);
				}
			 }); 		
			//END - Creating excel file
		});

	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
            { name: 'urut'},
            { name: 'id', type: 'string' },
			{ name: 'thn', type: 'number' },
			{ name: 'kegiatan',  type: 'string' },
			{ name: 'keterangan',  type: 'string' },
			{ name: 'kode',  type: 'string' },
			{ name: 'bgcolor',  type: 'string' },
			{ name: 'fontcolor',  type: 'string' },
			{ name: 'status_show',  type: 'string' }
        ],
		url: "<?php echo base_url(); ?>spkp_personalia_jadwal_kegiatan/json_kegiatan/{thn}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgridKegiatan").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgridKegiatan").jqxGrid('updatebounddata', 'sort');
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

        $("#jqxgridKegiatan").jqxGrid({		
			width: '100%',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100', '200'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: 'Detail', align: 'center', columntype: 'none', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgridKegiatan").jqxGrid('getrowdata', row);
                     return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='cbedit("+dataRecord.id+");'></a> <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='cbdel("+dataRecord.id+");'></a></div>";
                 }
                },
				{ text: 'No', datafield: 'urut', align: 'center', columntype: 'none', filtertype: 'none',  width: '4%', cellsalign: 'center' },
				{ text: 'Tahun', datafield: 'thn', filtertype: 'list', columntype: 'dropdownlist', cellsalign: 'center', width: '8%' },
                { text: 'Kode', datafield: 'kode', filtertype: 'list', columntype: 'dropdownlist', width: '5%', align: 'center',cellsalign: 'center', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgridKegiatan").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;height:100%;background:#"+dataRecord.bgcolor+";color:"+dataRecord.fontcolor+";padding-top:6px;text-align:center;font-size:10px'>"+dataRecord.kode+"</div>";
                 }
                },
                { text: 'Kegiatan', datafield: 'kegiatan', filtertype: 'textbox', width: '20%'},
                { text: 'Keterangan', datafield: 'keterangan', filtertype: 'textbox', width: '29%'},
                { text: 'Bg Color', datafield: 'bgcolor', filtertype: 'list', columntype: 'dropdownlist', width: '10%', align: 'center',cellsalign: 'center'},
                { text: 'Font Color', datafield: 'fontcolor', filtertype: 'list', columntype: 'dropdownlist', width: '10%', align: 'center',cellsalign: 'center'},
                { text: 'Status', datafield: 'status_show', filtertype: 'list', columntype: 'dropdownlist', width: '10%', align: 'center',cellsalign: 'center'}
            ]
		});
        
		$('#cb_clearfilteringbutton').click(function () {
			$("#jqxgridKegiatan").jqxGrid('clearfilters');
		});
        
        $('#cb_refreshdatabutton').click(function () {
			$("#jqxgridKegiatan").jqxGrid('updatebounddata', 'cells');
		});

		$('#cb_addkegiatan').click(function () {
			$("#popupkegiatan_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			$("#popupkegiatan").jqxWindow({
				theme: theme, resizable: true, position: { x: offset.left + 80, y: offset.top-60},
                width: 700,
                height: 500,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popupkegiatan").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_personalia_jadwal_kegiatan/add_kegiatan/{thn}" , function(response) {
				$("#popupkegiatan_content").html("<div>"+response+"</div>");
			});
		});
        
        $('#cb_printbutton').click(function () {
  			$("#popupkegiatan_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");

			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgridKegiatan").jqxGrid('getfilterinformation');
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
						var value = thn+"-"+bln+"-"+tgl;
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
				url: "<?php echo base_url();?>spkp_personalia_jadwal_kegiatan/html_kegiatan/{thn}",
				success: function(response){
					$("#popupkegiatan_content").html(response);
				}
			 }); 		

			var offset = $(this).offset();
			$("#popupkegiatan").jqxWindow({
				theme: theme, resizable: true, position: { x: 200, y: offset.top},
				width: 900,
				height: 500,
				isModal: true, autoOpen: false, cancelButton: $("#Cancel"), modalOpacity: 0.2
			});
			$("#popupkegiatan").jqxWindow('open');
			//END - Creating html view
		});
        
        $('#cb_excelbutton').click(function () {
			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgridKegiatan").jqxGrid('getfilterinformation');
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
						var value = thn+"-"+bln+"-"+tgl;
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
				url: "<?php echo base_url();?>spkp_personalia_jadwal_kegiatan/excel_kegiatan/{thn}",
				success: function(response){
					//Download excel file response
					window.open("<?php echo base_url();?>spkp_loader/"+response);
				}
			 }); 		
			//END - Creating excel file
		});

	});

	function edit(id){
		$("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		var offset = $("#jqxgrid").offset();
		$("#popup").jqxWindow({
			theme: theme, resizable: true, position: { x: offset.left + 80, y: 20},
			width: 700,
			height: 600,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_personalia_jadwal_kegiatan/detail/{thn}/{bln}/"+id , function(response) {
			$("#popup_content").html("<div>"+response+"</div>");
		});
	}

	function cbedit(id){
		$("#popupkegiatan_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		var offset = $("#jqxgridKegiatan").offset();
		$("#popupkegiatan").jqxWindow({
			theme: theme, resizable: true, position: { x: offset.left + 80, y: offset.top-60},
			width: 700,
			height: 500,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popupkegiatan").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_personalia_jadwal_kegiatan/edit_kegiatan/"+id , function(response) {
			$("#popupkegiatan_content").html("<div>"+response+"</div>");
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
				url: "<?php echo base_url()?>spkp_personalia_jadwal_kegiatan/dodelete_kegiatan/"+id,
				success: function(response){
					res = response.split("_");
					 if(res[0]=="OK"){
						 $.notific8('Notification', {
						  life: 5000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
						$("#jqxgridKegiatan").jqxGrid('updatebounddata', 'cells');
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

	function close_kegiatan(){
		$("#popupkegiatan").jqxWindow("close");
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
<div id="popupkegiatan" style="display:none"><div id="popupkegiatan_title">{title}</div><div id="popupkegiatan_content">{popupkegiatan}</div></div>
<div id="jqxTabs">
    <ul>
        <li>Jadwal Kegiatan</li>
        <li>Daftar Kegiatan</li>
    </ul>
    <div style="padding: 2px;">
		<div>
			<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
				<input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbutton" type="button" />
				<input style="padding: 5px;" value=" Refresh Data " id="refreshdatabutton" type="button" />
				<div id="jqxgrid"></div>
			</div>
		</div>
	</div>
    <div style="padding: 2px;">
		<div>
			<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
				<input style="padding: 5px;" value=" Tambah Kegiatan " id="cb_addkegiatan" type="button" />
				<input style="padding: 5px;" value=" Clear Filter " id="cb_clearfilteringbutton" type="button" />
				<input style="padding: 5px;" value=" Refresh Data " id="cb_refreshdatabutton" type="button" />
				<div id="jqxgridKegiatan"></div>
			</div>
		</div>
	</div>
</div>