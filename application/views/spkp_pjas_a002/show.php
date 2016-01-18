<script>
	$(function(){
       $("#bar_datapjas").click();
       $('#btn_tambah, #refreshdatabutton, #clearfilteringbutton ').jqxButton({ height: 25, theme: theme });
      
       var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
            { name: 'urut'},
            { name: 'id', type: 'string' },
			{ name: 'judul', type: 'string' },
			{ name: 'tempat',  type: 'string' },
            { name: 'tanggal',  type: 'date' },
            { name: 'hasil',  type: 'string' },
            { name: 'penanggungjawab_nama',  type: 'string' },
            { name: 'penanggungjawab_nip',  type: 'string' },
            { name: 'tmpt',  type: 'string' }
        ],
		url: "<?php echo base_url(); ?>index.php/spkp_pjas_a002/json_judul",
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
			return output1 + " " + output2 + " " + output3 + " " + output4;
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
				{ text: 'Proses', align: 'center', columntype: 'none', filtertype: 'none', sortable: false, width: '5%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
					 return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='del("+dataRecord.id+")'></a> <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit("+dataRecord.id+");'></a></div>";
				}
                },
				
                { text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				{ text: 'Tanggal', datafield: 'tanggal', filtertype: 'date', columntype: 'date', cellsformat: 'yyyy-MM-dd', width: '10%', cellsalign: 'center' },
                { text: 'Kegiatan / Pemaparan Materi', datafield: 'judul', filtertype: 'textbox',  width: '20%'},
				{ text: 'Tempat', datafield: 'tempat', filtertype: 'textbox', width: '15%' },
                { text: 'Penanggung Jawab', datafield: 'penanggungjawab_nama', filtertype: 'textbox', width: '15%'},
                { text: 'NIP-Penanggung Jawab', datafield: 'penanggungjawab_nip', filtertype: 'textbox', width: '15%', cellsrenderer:cellsrenderer },
                { text: 'Tempat (Pembuatan Laporan)', datafield: 'tmpt', filtertype: 'textbox', width: '15%'}
            ]
		});
		
		$('#btn_tambah').click(function(){
			$("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			var w=650; var h=450;
			var x=(screen.width/2)-(w/2);
			var y=(screen.height/2)-(h/2)+$(window).scrollTop();
            $("#popup").jqxWindow({
				theme: theme, resizable: false, position: { x: x , y: y },
                width: w,
                height: h,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
            });
            $("#popup").jqxWindow('open');
			$.get("<?php echo base_url();?>index.php/spkp_pjas_a002/add" , function(response) {
				$("#popup_content").html("<div>"+response+"</div>");
			});
		});
        
		$('#clearfilteringbutton').click(function () {
			$("#jqxgrid").jqxGrid('clearfilters');
		});
        
        $('#refreshdatabutton').click(function () {
			$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
		});
	});

	function edit(id){
		window.location.href = "<?php echo base_url(); ?>spkp_pjas_a002/edit/"+id;
	}
	
	function del(id){
		if(confirm("Anda yakin akan menghapus data ("+id+") ini?")){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_pjas_a002/del/"+id,
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
<div id="popup" style="display:none;"><div id="popup_title">{title}</div><div id="popup_content">{popup}</div></div>
<div>
	<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
	<?php
        if($add_permission || $id==$this->session->userdata('id')){
            ?>
            <input style="padding: 5px;" value=" Tambah " id="btn_tambah" type="button" />
            <?php
        }
        ?>
	    <input style="padding: 5px;" value=" Clear Filter " id="clearfilteringbutton" type="button" />
		<input style="padding: 5px;" value=" Refresh Data " id="refreshdatabutton" type="button" />
        <div style="margin: 2px;" id="jqxgrid"></div>
	</div>
	<br>
	<br>
	<br>
</div>