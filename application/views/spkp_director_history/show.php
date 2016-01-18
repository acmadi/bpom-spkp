<script>
	$(function(){
       $("#bar_profile").click();
       $('#refreshdatabutton, #printbutton, #excelbutton').jqxButton({ height: 25, theme: theme });
      
       var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
            { name: 'urut'},
            { name: 'id', type: 'number' },
            { name: 'image', type: 'string' },
			{ name: 'nip', type: 'string' },
			{ name: 'nama',  type: 'string' },
            { name: 'gelar',  type: 'string' },
            { name: 'gendre',  type: 'string' },
            { name: 'nama_agama',  type: 'string' },
            { name: 'tgl_mulai',  type: 'date' },
            { name: 'tgl_sampai',  type: 'date' },
            { name: 'masa_jabatan',  type: 'date' },
            { name: 'jabatan',  type: 'string' },
            { name: 'golongan',  type: 'string' },
            { name: 'birthdate',  type: 'date' },
            { name: 'birthplace',  type: 'string' },
            { name: 'mobile',  type: 'string' },
        ],
		url: "<?php echo base_url(); ?>index.php/spkp_director_history/json_director",
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
			return "<div style='padding:4px'>"+output1 + " " + output2 + " " + output3 + " " + output4+"</div>";
		}
        
        $("#jqxgrid").jqxGrid({		
			width: '100%',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: true, pagesizeoptions: ['10', '25', '50', '100', '200'],
			showfilterrow: false, filterable: false, sortable: true, autoheight: true, pageable: false, virtualmode: true, editable: false,rowsheight: 80,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: 'Detail', align: 'center', columntype: 'none', filtertype: 'none', sortable: false, width: 55, cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                     return "<div style='text-align: center;padding-top:30px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit("+dataRecord.id+");'></a></div>";
                 }
                },
                { text: 'Poto', align: 'center', datafield: 'image', width: 80, cellsrenderer: function (row, column, value) {
                    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                    if(dataRecord.image==null){
                        return '<img width="80" src="<?php echo base_url(); ?>media/images/smily-user-icon.jpg"/>';
                    }else{
                        return '<img width="80" src="<?php echo base_url(); ?>media/images/director/'+dataRecord.image+'">';
                    }
                 }
				},
                { text: 'Nama / NIP', align: 'center', columntype: 'none', filtertype: 'none', sortable: false, width: 220, cellsrenderer: function (row) {
					var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
					var nip = dataRecord.nip;
					var nama = dataRecord.nama;

					var nip1 = nip.substr(0,8);
					var nip2 = nip.substr(8,6);
					var nip3 = nip.substr(14,1);
					var nip4 = nip.substr(15,3);
                    return "<div style='padding:4px'>"+nama+ "<br>" +nip1 + " " + nip2 + " " + nip3 + " " + nip4+"</div>";
                 }
                },
                { text: 'Gelar', datafield: 'gelar', filtertype: 'textbox', width: 80, align: 'center', cellsalign: 'center' },
                { text: 'Pangkat', filtertype: 'textbox', width: 150, align: 'center', cellsalign: 'center', cellsrenderer: function(row){
                    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                    return "<div style='padding:4px;text-align: center'>" + dataRecord.jabatan + "</br>" + dataRecord.golongan + "</div>";
                  }
                },
                { text: 'Masa Jabatan', filtertype: 'textbox', width: 130, align: 'center', cellsalign: 'center', cellsrenderer: function(row){
                    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                    return "<div style='padding:4px;text-align: center'>" + dataRecord.masa_jabatan+ "</div>";
                  }
                },
                { text: 'Kelamin', datafield: 'gendre', filtertype: 'list', width: 65, align: 'center', cellsalign: 'center' },
                { text: 'Agama', datafield: 'nama_agama', filtertype: 'textbox', width: 90, align: 'center', cellsalign: 'center' },
                { text: 'Tanggal Lahir', datafield: 'birthdate', columntype: 'date', filtertype: 'date', cellsformat: 'yyyy-MM-dd', width: 100, align: 'center', cellsalign: 'center' },
                { text: 'Tempat Lahir', datafield: 'birthplace', filtertype: 'textbox', width: 120, align: 'center', cellsalign: 'center' }
            ]
		});
        
        $('#refreshdatabutton').click(function () {
			$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
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
				url: "<?php echo base_url();?>spkp_director_history/html",
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
				url: "<?php echo base_url();?>spkp_director_history/excel",
				success: function(response){
					//Download excel file response
					window.open("<?php echo base_url();?>spkp_loader/"+response);
				}
			 }); 		
			//END - Creating excel file
		});
    });

	function edit(id){
		window.location.href = "<?php echo base_url(); ?>spkp_director_history/edit/"+id;
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
<div style="padding:8px">
	<div style="width:98%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
		<input style="padding: 5px;" value=" Refresh Data " id="refreshdatabutton" type="button" />
		<input style="padding: 5px;" value=" Print " id="printbutton" type="button" />
		<input style="padding: 5px;" value=" Excel " id="excelbutton" type="button" />
        <div style="margin: 2px;" id="jqxgrid"></div>
	</div>
	<br>
	<br>
	<br>
</div>