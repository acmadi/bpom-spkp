<script type="text/javascript">
    $(document).ready(function(){
       $('#refreshdatabuttonmateri, #btnTambahmateri').jqxButton({ height: 25, theme: theme });
      
       var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
            { name: 'urut'},
            { name: 'id', type: 'number' },
            { name: 'id_materi', type: 'number' },
            { name: 'materi', type: 'string' }
        ],
		url: "<?php echo base_url(); ?>index.php/spkp_pjas_a007b/json_materi/{id}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgridmateri").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgridmateri").jqxGrid('updatebounddata', 'sort');
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
        
        $("#jqxgridmateri").jqxGrid({		
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
				     var dataRecord = $("#jqxgridmateri").jqxGrid('getrowdata', row);
                     if({add_permission}==true){
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/del.gif' onclick='dodel_materi("+dataRecord.urut+","+dataRecord.id_materi+")'></a></div>";
                     }else{
                        return "<div style='text-align: center;padding:3px'>&nbsp;</div>";
                     }
                }
                },
                { text: 'No', align: 'center', filtertype: 'none', width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgridmateri").jqxGrid('getrowdata', row);
                     return "<div style='width:100%;padding-top:4px;text-align:center'>"+dataRecord.urut+"</div>";
                 }
                },
				{ text: 'Materi', datafield: 'materi', filtertype: 'textbox',  width: '30%' }
            ]
		});
        
		$('#clearfilteringbuttonmateri').click(function () {
			$("#jqxgridmateri").jqxGrid('clearfilters');
		});
        
        $('#refreshdatabuttonmateri').click(function () {
			$("#jqxgridmateri").jqxGrid('updatebounddata', 'cells');
		});
        
        $('#btnTambahmateri').click(function(){
			$("#popup_materi_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			var w=400; var h=200;
			var x=(screen.width/2)-(w/2);
			var y=(screen.height/2)-(h/2)+$(window).scrollTop();
            $("#popup_materi").jqxWindow({
				theme: theme, resizable: false, position: { x: x, y: y},
                width: w,
                height: h,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
            });
            $("#popup_materi").jqxWindow('open');
			$.get("<?php echo base_url();?>index.php/spkp_pjas_a007b/add_materi/{id}" , function(response) {
				$("#popup_materi_content").html("<div>"+response+"</div>");
			});
		});
    });

    function dodel_materi(urut,id_materi){
		if(confirm("Anda yakin akan menghapus data ("+urut+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_pjas_a007b/dodel_materi/"+id_materi,
				success: function(response){
					 if(response=="1"){
						 $('#refreshdatabuttonmateri').click();
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

	function close_materi_dialog(){
		$("#popup_materi").jqxWindow("close");
	}
</script>
<div id="popup_materi" style="display:none"><div id="popup_materi_title">Materi</div><div id="popup_materi_content">{popup_materi}</div></div>
<div>
	<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
		<?php
        if($add_permission || $id==$this->session->userdata('id')){
            ?>
            <input style="padding: 5px;" value=" Tambah " id="btnTambahmateri" type="button" />
            <?php
        }
        ?><input style="padding: 5px;" value=" Refresh Data" id="refreshdatabuttonmateri" type="button" />
        <div style="margin: 2px;" id="jqxgridmateri"></div>
	</div>
	<br>
	<br>
	<br>
</div>