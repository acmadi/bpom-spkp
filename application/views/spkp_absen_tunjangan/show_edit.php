<script>
	$(function(){
       $("#bar_personalia").click();
       $("input[type='button']").jqxButton({ width:120, height: 28, theme: theme });
      
       var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'urut'},
            { name: 'id', type: 'number' },
			{ name: 'tgl', type: 'date' },
			{ name: 'jadwal_kerja',  type: 'string' },
            { name: 'jam_masuk',  type: 'string' },
            { name: 'jam_pulang',  type: 'string' },
            { name: 'scan_masuk',  type: 'string' },
            { name: 'scan_pulang',  type: 'string' },
            { name: 'terlambat',  type: 'string' },
            { name: 'potong_terlambat',  type: 'string' },
            { name: 'pulang_cepat',  type: 'string' },
            { name: 'potong_pc',  type: 'string' },
            { name: 'absen',  type: 'string' },
            { name: 'ket',  type: 'string' },
            { name: 'potong_sic',  type: 'string' },
            { name: 'potong_total',  type: 'string' }
        ],
		url: "<?php echo base_url(); ?>spkp_absen_tunjangan/json_absen/{id}/{thn}/{bln}",
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
        pagesize: 31,
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
        
        $("#jqxgrid").jqxGrid({		
			width: '100%',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: true, pagesizeoptions: ['31'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			rendertoolbar: function (toolbar) {
				var me = this;
				var container = $("<div style='margin: 5px;'></div>");
				var thn = $("<span style='float: left; margin-top: 5px; margin-right: 4px;'>&nbsp;&nbsp;Tahun: </span>");
				var thninput = $("<select class='jqx-input jqx-widget-content jqx-rc-all' id='filter_thn' name='filter_thn' style='height: 23px; float: left; width: 80px;' >{option_thn}</select>");
				var bln = $("<span style='float: left; margin-top: 5px; margin-right: 4px;'>&nbsp;&nbsp;Bulan: </span>");
				var blninput = $("<select class='jqx-input jqx-widget-content jqx-rc-all' id='filter_thn' name='filter_bln' style='height: 23px; float: left; width: 80px;' >{option_bln}</select>");
				var clearfiltering = $("<input class='jqx-button' style='border:1px solid #CCCCCC;height: 23px; float: left; width: 120px;' value=' Clear Filter' type='button' />");
				var refreshdata = $("<input  class='jqx-button' style='border:1px solid #CCCCCC;height: 23px; float: left; width: 120px;' value=' Refresh Data ' type='button' />");

				toolbar.append(container);
				container.append(thn);
				container.append(thninput);
				container.append(bln);
				container.append(blninput);
				container.append("<span style='float: left; margin-top: 5px; margin-right: 4px;'>&nbsp;&nbsp;</span>");
				container.append(clearfiltering);
				container.append("<span style='float: left; margin-top: 5px; margin-right: 4px;'>&nbsp;&nbsp;</span>");
				container.append(refreshdata);
				thninput.change(function(){
					window.location.href="<?php echo base_url(); ?>spkp_absen_tunjangan/edit/{id}/"+thninput.val()+"/"+blninput.val();
				});
				blninput.change(function(){
					window.location.href="<?php echo base_url(); ?>spkp_absen_tunjangan/edit/{id}/"+thninput.val()+"/"+blninput.val();
				});
				clearfiltering.click(function () {
					$("#jqxgrid").jqxGrid('clearfilters');
				});
				
				refreshdata.click(function () {
					$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
				});
				
			},
			columns: [
				//{ text: 'Edit', align: 'center', columntype: 'none', filtertype: 'none', sortable: false, width: 40, cellsrenderer: function (row) {
				//     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                //     return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit(\""+dataRecord.tgl+"\");'></a></div>";
                // }
                //},
				{ text: 'No', align: 'center', columntype: 'none', filtertype: 'none', sortable: false, width: 40, cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                     return "<div style='text-align: center;padding:3px'>"+dataRecord.urut+"</div>";
                 }
                },
                { text: 'Tanggal', datafield: 'tgl', columntype: 'date', filtertype: 'date', cellsformat: 'yyyy-MM-dd', width: 90},
				{ text: 'Jadwal Kerja', datafield: 'jadwal_kerja', filtertype: 'list', width: 80, cellsalign: 'center'},
                { text: 'Jam Masuk', datafield: 'jam_masuk', filtertype: 'list', width: 80, cellsalign: 'center'},
                { text: 'Jam Pulang', datafield: 'jam_pulang', filtertype: 'list', width: 80, cellsalign: 'center' },
                { text: 'Scan Masuk', datafield: 'scan_masuk', filtertype: 'textbox', width: 80 },
                { text: 'Scan Pulang', datafield: 'scan_pulang', width: 80 },
                { text: 'Terlambat', datafield: 'terlambat', width: 80 },
                { text: 'Potong Terlambat', datafield: 'potong_terlambat', width: 80 },
                { text: 'Pulang cepat', datafield: 'pulang_cepat', width: 80 },
                { text: 'Potong PC', datafield: 'potong_pc', width: 80 },
                { text: 'Absen', datafield: 'absen', width: 80 },
                { text: 'Ket', datafield: 'ket', width: 80 },
                { text: 'Potong S/C/I', datafield: 'potong_sic', width: 80 },
                { text: 'Total Potong', datafield: 'potong_total', width: 80 }
            ]
		});
        
        $('#printbutton').click(function () {
  			$("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");

			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&recordstartindex=0&";
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
				url: "<?php echo base_url();?>spkp_absen_tunjangan/html_tukin/{id}/{thn}/{bln}",
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
			var datastring="pagenum=0&pagesize=9999&groupscount=0&recordstartindex=0&";
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
            
			//Creating excel file
			$.ajax({ 
				type: "POST",
				data: datastring+'&filterscount='+k,
				url: "<?php echo base_url();?>spkp_absen_tunjangan/excel_tukin/{id}/{thn}/{bln}",
				success: function(response){
					//Download excel file response
					window.open("<?php echo base_url();?>spkp_loader/"+response);
				}
			 }); 		
			//END - Creating excel file
		});

        $('#backbutton').click(function () {
			window.location.href = "<?php echo base_url(); ?>spkp_absen_tunjangan/";
		});

	   $('#importbutton').click(function(){
			$("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			$("#popup").jqxWindow({
				theme: theme, resizable: true, position: { y: offset.top},
                width: 700,
                height: 300,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_absen_tunjangan/add/{id}/{thn}/{bln}" , function(response) {
				$("#popup_content").html("<div>"+response+"</div>");
			});
		});
   });

	function edit(tgl){
			$("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			$("#popup").jqxWindow({
				theme: theme, resizable: true,
                width: 700,
                height: 300,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_absen_tunjangan/edit/{id}/"+tgl , function(response) {
				$("#popup_content").html("<div>"+response+"</div>");
			});
	}

	function close_dialog(){
		$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
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
<div style="padding:8px">
        <div style="background: #F4F4F4;width:98%;padding:5px;text-align:right;border-bottom:2px solid white">
			<input style="padding: 5px;" value=" Import Excel" id="importbutton" type="button" />
			<input style="padding: 5px;display:none" value=" Print " id="printbutton" type="button" />
			<input style="padding: 5px;" value=" Download Excel " id="excelbutton" type="button" />
			<input style="padding: 5px;" value=" Kembali " id="backbutton" type="button" />
        </div>
        <div style="background:#EFEFEF;width:98%;padding:5px;">
			<div style="padding:5px;width:500px;background:#EFEFEF;">
				<table border='0' width='99%' cellpadding='5' cellspacing='5' style="font-size: 12px;color: black">
				<tr>
					<td rowspan="5" width="24%">
						<?php
						if($image==""){
							?>
							<img src="<?php echo base_url(); ?>media/images/smily-user-icon.jpg" width="150" height="150" style="border: 1px solid #404040;"/>
							<?php
						}else{
							?>
							<img src="<?php echo base_url(); ?>media/images/user/{image}" width="150" height="150" style="border: 1px solid #404040;"/>
							<?php
						}
						?>
					</td>
					<td width='25%'>NIP</td>
					<td>:</td>
					<td>{nip}</td>
				</tr>
				<tr>
					<td>Nama</td>
					<td>:</td>
					<td>{nama}</td>
				</tr>
				<tr>
					<td>Bulan</td>
					<td>:</td>
					<td>{thn} - {bln}</td>
				</tr>
				<tr>
					<td>Total Potongan</td>
					<td>:</td>
					<td><?php echo number_format($potong['potong_total'],2)?> %</td>
				</tr>
				<tr height="40">
					<td colspan="3">&nbsp;</td>
				</tr>
			</table>
		</div>
	</div>

	<div style="width:98%;padding:2px;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;border:3px solid #ebebeb;">
        <div id="jqxgrid"></div>
	</div>
	<br>
</div>