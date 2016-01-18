<script type="text/javascript">
    $(document).ready(function(){
       $('#refreshdatabuttonpetugas, #btnTambahpetugas').jqxButton({ height: 25, theme: theme });
      
       var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
            { name: 'urut'},
            { name: 'id', type: 'number' },
            { name: 'id_petugas', type: 'number' },
            { name: 'nama', type: 'string' }
        ],
		url: "<?php echo base_url(); ?>index.php/spkp_pjas_a007b/json_petugas/{id}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgridpetugas").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgridpetugas").jqxGrid('updatebounddata', 'sort');
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
        
        $("#jqxgridpetugas").jqxGrid({		
			width: '99%',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true, showtoolbar: true, pagesizeoptions: ['10', '25', '50', '100', '200'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: 'Proses', align: 'center', columntype: 'none', filtertype: 'none', sortable: false, width: 55, cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgridpetugas").jqxGrid('getrowdata', row);
                     if({add_permission}==true){
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel_petugas("+dataRecord.urut+","+dataRecord.id_petugas+")'></a></div>";
                     }else{
                        return "<div style='text-align: center;padding:3px'>&nbsp;</div>";
                     }
                }
                },
                { text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgridpetugas").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				{ text: 'Nama Petugas', datafield: 'nama', filtertype: 'textbox',  width: '30%' }
            ]
		});
        
		$('#clearfilteringbuttonpetugas').click(function () {
			$("#jqxgridpetugas").jqxGrid('clearfilters');
		});
        
        $('#refreshdatabuttonpetugas').click(function () {
			$("#jqxgridpetugas").jqxGrid('updatebounddata', 'cells');
		});
        
        $('#btnTambahpetugas').click(function(){
			$("#popup_petugas_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			var w=400; var h=200;
			var x=(screen.width/2)-(w/2);
			var y=(screen.height/2)-(h/2)+$(window).scrollTop();
            $("#popup_petugas").jqxWindow({
				theme: theme, resizable: false, position: { x: x, y: y},
                width: w,
                height: h,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
            });
            $("#popup_petugas").jqxWindow('open');
			$.get("<?php echo base_url();?>index.php/spkp_pjas_a007b/add_petugas/{id}" , function(response) {
				$("#popup_petugas_content").html("<div>"+response+"</div>");
			});
		});
    });

    function dodel_petugas(urut,id_petugas){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_pjas_a007b/dodel_petugas/"+id_petugas,
				success: function(response){
					 if(response=="1"){
						 $('#refreshdatabuttonpetugas').click();
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

	function close_petugas_dialog(){
		$("#popup_petugas").jqxWindow("close");
	}
</script>
<div id="popup_petugas" style="display:none"><div id="popup_petugas_title">Petugas</div><div id="popup_petugas_content">{popup_petugas}</div></div>
<div>
	<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
		<?php
        if($add_permission || $id==$this->session->userdata('id')){
            ?>
            <input style="padding: 5px;" value=" Tambah " id="btnTambahpetugas" type="button" />
            <?php
        }
        ?><input style="padding: 5px;" value=" Refresh Data" id="refreshdatabuttonpetugas" type="button" />
        <div style="margin: 2px;" id="jqxgridpetugas"></div>
	</div>
	<br>
	<br>
	<br>
</div>