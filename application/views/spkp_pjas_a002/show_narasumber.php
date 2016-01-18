<script type="text/javascript">
    $(document).ready(function(){
       $('#refreshdatabutton,#btnTambah').jqxButton({ height: 25, theme: theme });
      
       var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
            { name: 'urut'},
            { name: 'id', type: 'number' },
            { name: 'id_narasumber', type: 'number' },
            { name: 'nama', type: 'string' },
            { name: 'materi',  type: 'string' }
        ],
		url: "<?php echo base_url(); ?>index.php/spkp_pjas_a002/json_narasumber/{id}",
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
        
        $("#jqxgrid").jqxGrid({
			width: '99%',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: true, pagesizeoptions: ['10', '25', '50', '100', '200'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: 'Proses', align: 'center', columntype: 'none', filtertype: 'none', sortable: false, width: 55, cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                     if({add_permission}==true || dataRecord.id=='<?php echo $this->session->userdata('id')?>'){
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel_narasumber("+dataRecord.urut+","+dataRecord.id+","+dataRecord.id_narasumber+")'></a>  <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit_narasumber("+dataRecord.id+","+dataRecord.id_narasumber+");'></a></div>";
                     }else{
                        return "<div style='text-align: center;padding:3px'>&nbsp;</div>";
                     }
                }
                },
                { text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				{ text: 'Nama', datafield: 'nama', filtertype: 'textbox',  width: 300 },
                { text: 'Materi Yang Disampaikan', datafield: 'materi', filtertype: 'textbox', width: 700 }
            ]
		});
        
		$('#clearfilteringbutton').click(function () {
			$("#jqxgrid").jqxGrid('clearfilters');
		});
        
        $('#refreshdatabutton').click(function () {
			$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
		});
        
        $("#btnBack").click(function(){
           window.location.href = "<?php echo base_url(); ?>spkp_pjas_a002"; 
        });
        
        $('#btnTambah').click(function(){
			$("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			var w=600; var h=300;
			var x=(screen.width/2)-(w/2);
			var y=(screen.height/2)-(h/2)+$(window).scrollTop();
            $("#popup").jqxWindow({
				theme: theme, resizable: false, position: { x: x, y: y },
                width: w,
                height: h,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
            });
            $("#popup").jqxWindow('open');
			$.get("<?php echo base_url();?>index.php/spkp_pjas_a002/add_narasumber" , function(response) {
				$("#popup_content").html("<div>"+response+"</div>");
			});
		});
    });
    
    function edit_narasumber(id,id_narasumber){
		$("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
	    var offset = $("#jqxgrid").offset();
		var w=600; var h=300;
		var x=(screen.width/2)-(w/2);
		var y=(screen.height/2)-(h/2)+$(window).scrollTop();
        $("#popup").jqxWindow({
			theme: theme, resizable: false, position: { x: x, y: y},
            width: w,
            height: h,
			isModal: true, autoOpen: false, modalOpacity: 0.2
        });
        $("#popup").jqxWindow('open');
		$.get("<?php echo base_url();?>index.php/spkp_pjas_a002/edit_narasumber/"+id+"/"+id_narasumber , function(response) {
			$("#popup_content").html("<div>"+response+"</div>");
		});
	}

	function save_edit_narasumber_dialog(content){
	   	$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a002/doedit_narasumber",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_dialog();
					 $('#refreshdatabutton').click();
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
    
    function save_add_narasumber_dialog(content){
		$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a002/doadd_narasumber/{id}",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_dialog();
					 $('#refreshdatabutton').click();
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
    
    function dodel_narasumber(urut,id,id_narasumber){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_pjas_a002/dodel_narasumber/"+id+"/"+id_narasumber,
				success: function(response){
					 if(response=="1"){
						 $('#refreshdatabutton').click();
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
<div id="popup" style="display:none"><div id="popup_title">Narasumber</div><div id="popup_content">{popup}</div></div>
<div>
	<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
		<input style="padding: 5px;" value=" Refresh Data" id="refreshdatabutton" type="button" />
        <?php
        if($add_permission || $id==$this->session->userdata('id')){
            ?>
            <input style="padding: 5px;" value=" Tambah " id="btnTambah" type="button" />
            <?php
        }
        ?>
        <div style="margin: 2px;" id="jqxgrid"></div>
	</div>
	<br>
	<br>
	<br>
</div>