<script type="text/javascript">
    $(document).ready(function(){
       //$('#refreshdatabuttonkomposisi').jqxButton({ height: 25, theme: theme });
      
       var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
            { name: 'urut'},
            { name: 'id', type: 'number'},
            { name: 'jml_kepsek', type: 'number' },
            { name: 'jml_guru', type: 'number' },
            { name: 'jml_kantin', type: 'number' },
            { name: 'jml_pedagang', type: 'number' },
            { name: 'jml_komite', type: 'number' },
            { name: 'jml_siswa', type: 'number' },
            { name: 'jml_total', type: 'number' }
        ],
		url: "<?php echo base_url(); ?>index.php/spkp_pjas_a007b/json_komposisi/{id}",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgridkomposisi").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgridkomposisi").jqxGrid('updatebounddata', 'sort');
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
        
        $("#jqxgridkomposisi").jqxGrid({		
			width: '99%',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: false, showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100', '200'],
			showfilterrow: false, filterable: false, sortable: false, autoheight: true, pageable: false, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: 'Edit', align: 'center', columntype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
				     var dataRecord = $("#jqxgridkomposisi").jqxGrid('getrowdata', row);
                     if({add_permission}==true){
                        return "<div style='text-align: center;padding:3px'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>public/images/edt.gif' onclick='edit_komposisi("+dataRecord.id+")'></a></div>";
                     }else{
                        return "<div style='text-align: center;padding:3px'>&nbsp;</div>";
                     }
                }
                },
				{ text: 'Kepsek', datafield: 'jml_kepsek',  width: '14%', cellsalign:'center', align:'center' },
				{ text: 'Guru', datafield: 'jml_guru', width: '14%', cellsalign:'center', align:'center' },
				{ text: 'Pengelola Kantin', datafield: 'jml_kantin', width: '14%', cellsalign:'center', align:'center' },
				{ text: 'Pedagang PJAS', datafield: 'jml_pedagang', width: '14%', cellsalign:'center', align:'center' },
				{ text: 'Komite Sekolah', datafield: 'jml_komite', width: '14%', cellsalign:'center', align:'center' },
				{ text: 'Siswa', datafield: 'jml_siswa', width: '14%', cellsalign:'center', align:'center' },
				{ text: 'Jumlah Total', datafield: 'jml_total', width: '12%', cellsalign:'center', align:'center' }
            ]
		});
    });
	
	function edit_komposisi(id){
			$("#popup_komposisi_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			var w=300; var h=350;
			var x=(screen.width/2)-(w/2);
			var y=(screen.height/2)-(h/2)+$(window).scrollTop();
            $("#popup_komposisi").jqxWindow({
				theme: theme, resizable: false, position: { x: x, y: y},
                width: w,
                height: h,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
            });
            $("#popup_komposisi").jqxWindow('open');
			$.get("<?php echo base_url();?>index.php/spkp_pjas_a007b/edit_komposisi/"+id , function(response) {
				$("#popup_komposisi_content").html("<div>"+response+"</div>");
			});
		}

	function close_komposisi_dialog(){
		$("#popup_komposisi").jqxWindow("close");
	}
</script>
<div id="popup_komposisi" style="display:none"><div id="popup_komposisi_title">komposisi</div><div id="popup_komposisi_content">{popup_komposisi}</div></div>
<div style="border:1px solid #CDCDCD;">
	<h3 style="padding-left:10">Komposisi Peserta Komunitas Sekolah SD/MI</h3>
	<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px; border:3px solid #ebebeb;">
		<!--input style="padding: 5px;" value=" Refresh Data" id="refreshdatabuttonkomposisi" type="button" style="display:none;"/-->
        <div style="margin: 2px;" id="jqxgridkomposisi"></div>
	</div>
	<br>
	<br>
	<br>
</div>