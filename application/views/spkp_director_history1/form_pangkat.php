<script type="text/javascript">
    $(document).ready(function(){
       $('#clearfilteringbuttonPangkat, #refreshdatabuttonPangkat, #printbuttonPangkat, #excelbuttonPangkat, #btnBackPangkat, #btnTambahPangkat').jqxButton({ height: 25, theme: theme });
      
       var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
            { name: 'urut'},
            { name: 'id', type: 'number' },
            { name: 'id_golruang', type: 'number' },
            { name: 'subdit_ket', type: 'string' },
            { name: 'golongan', type: 'string' },
            { name: 'status',  type: 'string' },
            { name: 'sk_jb_tgl',  type: 'date' },
            { name: 'sk_jb_nomor',  type: 'string' },
            { name: 'sk_jb_pejabat',  type: 'string' },
            { name: 'tgl_mulai',  type: 'date' },
            { name: 'tgl_sampai',  type: 'date' }
        ],
		url: "<?php echo base_url(); ?>index.php/spkp_director_history/json_pangkat/{id}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgridPangkat").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgridPangkat").jqxGrid('updatebounddata', 'sort');
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
        
        $("#jqxgridPangkat").jqxGrid({		
			width: '100%',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: true, pagesizeoptions: ['10', '25', '50', '100', '200'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: 'Proses', align: 'center', columntype: 'none', filtertype: 'none', sortable: false, width: 55, cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgridPangkat").jqxGrid('getrowdata', row);
                     if({add_permission}==true || dataRecord.id=='<?php echo $this->session->userdata('id')?>'){
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel_pangkat("+dataRecord.urut+","+dataRecord.id+","+dataRecord.id_golruang+")'></a>  <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit_pangkat("+dataRecord.id+","+dataRecord.id_golruang+");'></a></div>";
                     }else{
                        return "<div style='text-align: center;padding:3px'>&nbsp;</div>";
                     }
                }
                },
                { text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgridPangkat").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				{ text: 'Subdit', datafield: 'subdit_ket', filtertype: 'textbox',  width: 180},
                { text: 'Status', datafield: 'status', filtertype: 'list',  width: 100, align: 'center', cellsalign: 'center'},
                { text: 'Tanggal Mulai', datafield: 'tgl_mulai', columntype: 'date', filtertype: 'date', cellsformat: 'yyyy-MM-dd', width: 100, align: 'center', cellsalign: 'center' },
                { text: 'Tanggal Akhir', datafield: 'tgl_sampai', columntype: 'date', filtertype: 'date', cellsformat: 'yyyy-MM-dd', width: 100, align: 'center', cellsalign: 'center' },
                { text: 'Golongan', datafield: 'golongan', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: 75 },
                { text: 'Tanggal SK', datafield: 'sk_jb_tgl', columntype: 'date', filtertype: 'date', cellsformat: 'yyyy-MM-dd', width: 100, align: 'center', cellsalign: 'center' },
                { text: 'Nomor SK', datafield: 'sk_jb_nomor', filtertype: 'textbox', width: 145 },
                { text: 'Pejabat', datafield: 'sk_jb_pejabat', filtertype: 'textbox', width: 190 }
            ]
		});
        
		$('#clearfilteringbuttonPangkat').click(function () {
			$("#jqxgridPangkat").jqxGrid('clearfilters');
		});
        
        $('#refreshdatabuttonPangkat').click(function () {
			$("#jqxgridPangkat").jqxGrid('updatebounddata', 'cells');
		});
        
        $("#btnBackPangkat").click(function(){
           window.location.href = "<?php echo base_url(); ?>spkp_director_history"; 
        });
        
        $('#btnTambahPangkat').click(function(){
			$("#popup_pangkat_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
            $("#popup_pangkat").jqxWindow({
				theme: theme, resizable: false, position: { x: 200, y: offset.top},
                width: 550,
                height: 480,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
            });
            $("#popup_pangkat").jqxWindow('open');
			$.get("<?php echo base_url();?>index.php/spkp_director_history/add_pangkat" , function(response) {
				$("#popup_pangkat_content").html("<div>"+response+"</div>");
			});
		});
        
        $('#printbuttonPangkat').click(function () {
  			$("#popup_pangkat_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");

			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgridPangkat").jqxGrid('getfilterinformation');
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
					datastring +='&filtervalue'+k+'=' + value + '&filtercondition'+k+'=' + condition + '&filterdatafield'+k+'=' + datafield+ '&filteroperator'+k+'='+ operator+'&'+datafield+'operator=and';
					k++;
				}
			}
			//END - Collecting filter information into querystring
            
            //Creating html view
			$.ajax({ 
				type: "POST",
				data: datastring+'&filterscount='+k,
				url: "<?php echo base_url();?>spkp_director_history/html_pangkat/{id}",
				success: function(response){
					$("#popup_pangkat_content").html(response);
				}
			 }); 		

			var offset = $(this).offset();
			$("#popup_pangkat").jqxWindow({
				theme: theme, resizable: true, position: { x: 200, y: offset.top},
				width: 900,
				height: 500,
				isModal: true, autoOpen: false, cancelButton: $("#Cancel"), modalOpacity: 0.2
			});
			$("#popup_pangkat").jqxWindow('open');
			//END - Creating html view
			
		});
        
        $('#excelbuttonPangkat').click(function () {
			//Collecting filter information into querystring
			var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
			var filter = $("#jqxgridPangkat").jqxGrid('getfilterinformation');
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
					datastring +='&filtervalue'+k+'=' + value + '&filtercondition'+k+'=' + condition + '&filterdatafield'+k+'=' + datafield+ '&filteroperator'+k+'='+ operator+'&'+datafield+'operator=and';
					k++;
				}
			}
			//END - Collecting filter information into querystring

			$.ajax({ 
				type: "POST",
				data: datastring+'&filterscount='+k,
				url: "<?php echo base_url();?>spkp_director_history/excel_pangkat/{id}",
				success: function(response){
				
					window.open("<?php echo base_url();?>spkp_loader/"+response);
				}
			 }); 		
			
		});
        
    });
    
    function edit_pangkat(id,id_golruang){
		$("#popup_pangkat_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
	    var offset = $(this).offset();
        $("#popup_pangkat").jqxWindow({
			theme: theme, resizable: false, position: { x: 200, y: 180},
            width: 550,
            height: 480,
			isModal: true, autoOpen: false, modalOpacity: 0.2,
        });
        $("#popup_pangkat").jqxWindow('open');
		$.get("<?php echo base_url();?>index.php/spkp_director_history/edit_pangkat/"+id+"/"+id_golruang , function(response) {
			$("#popup_pangkat_content").html("<div>"+response+"</div>");
		});
	}

	function save_edit_pangkat_dialog(content){
	   	$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_director_history/doedit_pangkat",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_pangkat_dialog();
					 $('#clearfilteringbuttonPangkat').click();
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
    
    function save_add_pangkat_dialog(content){
		$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_director_history/doadd_pangkat/{id}",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_pangkat_dialog();
					 $('#clearfilteringbuttonPangkat').click();
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
    
    function dodel_pangkat(urut,id,id_golruang){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_director_history/dodel_pangkat/"+id+"/"+id_golruang,
				success: function(response){
					 if(response=="1"){
						 $('#clearfilteringbuttonPangkat').click();
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

	function close_pangkat_dialog(){
		$("#popup_pangkat").jqxWindow("close");
	}
</script>
<div id="popup_pangkat" style="display:none"><div id="popup_pangkat_title">Pangkat</div><div id="popup_pangkat_content">{popup_pangkat}</div></div>
<div style="padding:8px">
	<div style="width:98%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
	    <input style="padding: 5px;" value=" Back" id="btnBackPangkat" type="button" />
        <input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbuttonPangkat" type="button" />
		<input style="padding: 5px;" value=" Refresh Data" id="refreshdatabuttonPangkat" type="button" />
        <?php
        if($add_permission || $id==$this->session->userdata('id')){
            ?>
            <input style="padding: 5px;" value=" Tambah " id="btnTambahPangkat" type="button" />
            <?php
        }
        ?>
        <input style="padding: 5px;" value=" Print " id="printbuttonPangkat" type="button" />
		<input style="padding: 5px;" value=" Excel " id="excelbuttonPangkat" type="button" />
        <div style="margin: 2px;" id="jqxgridPangkat"></div>
	</div>
	<br>
	<br>
	<br>
</div>