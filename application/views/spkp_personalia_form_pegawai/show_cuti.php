<script>
	$(function(){
       var urut = 0;
       var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
            { name: 'urut'},
            { name: 'id', type: 'number' },
			{ name: 'nip', type: 'string' },
			{ name: 'nama',  type: 'string' },
            { name: 'hari_back',  type: 'number' },
            { name: 'hari_now',  type: 'number' },
            { name: 'cb_back',  type: 'number' },
            { name: 'cb_now',  type: 'number' }
        ],
		url: "<?php echo base_url(); ?>spkp_personalia_form_pegawai/json_user",
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
			source: dataadapter, theme: theme,columnsresize: true, showtoolbar: true, 
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
                     urut+=1;
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				{ text: 'Nama', datafield: 'nama', filtertype: 'textbox', width: '27%' },
				{ text: 'NIP', datafield: 'nip', filtertype: 'textbox',  width: '26%', cellsrenderer: cellsrenderer},
                { text: 'Sisa Cuti <?php echo (date('Y')-1)?>', datafield: 'hari_back', filtertype: 'none', width: '12%', cellsalign: 'center', cellsrenderer: function(row){
                    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                    var hari_back = dataRecord.hari_back;
                    var cb_back = dataRecord.cb_back;
                    
                    return "<div style='width:100%;padding-top:4px;text-align:center'>"+parseInt((12-cb_back)-hari_back)+"</div>";
                } },
                { text: 'Sisa Cuti <?php echo (date('Y'))?>', datafield: 'bln_back', filtertype: 'none', width: '12%', cellsalign: 'center', cellsrenderer: function(row){
                    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                    var hari_now = dataRecord.hari_now;
                    var cb_now = dataRecord.cb_now;
                                        
                    return "<div style='width:100%;padding-top:4px;text-align:center'>"+parseInt((12-cb_now)-hari_now)+"</div>";
                } },
                { text: 'Sisa Cuti Gabungan', datafield: 'thn_back', filtertype: 'none', width: '15%', cellsalign: 'center', cellsrenderer: function(row){
                    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                    var hari_back = dataRecord.hari_back;
                    var cb_back = dataRecord.cb_back;
                    
                    var sum_back = (12-cb_back)-hari_back;
                    
                    var hari_now = dataRecord.hari_now;
                    var cb_now = dataRecord.cb_now;
                    
                    var sum_now = (12-cb_now)-hari_now;
                    
                    return "<div style='width:100%;padding-top:4px;text-align:center'>"+parseInt(sum_back+sum_now)+"</div>";
                
                } }
            ]
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
				url: "<?php echo base_url();?>spkp_personalia_form_pegawai/html_cuti",
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
				url: "<?php echo base_url();?>spkp_personalia_form_pegawai/excel_cuti",
				success: function(response){
					//Download excel file response
					window.open("<?php echo base_url();?>spkp_loader/"+response);
				}
			 }); 		
			//END - Creating excel file
		});
	});

	function edit(id){
		window.location.href = "<?php echo base_url(); ?>spkp_personalia_form_pegawai/detail/"+id;
	}
</script>
<div>
    <div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
	   <input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbutton" type="button" />
	   <input style="padding: 5px;" value=" Refresh Data " id="refreshdatabutton" type="button" />
	   <input style="padding: 5px;" value=" Print " id="printbutton" type="button" />
	   <input style="padding: 5px;" value=" Excel " id="excelbutton" type="button" />
       <div id="jqxgrid"></div>
    </div>
</div>
