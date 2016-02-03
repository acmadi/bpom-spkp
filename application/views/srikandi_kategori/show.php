<script> 
	function close_dialog_kategori(s){
		$("#popup_upload").jqxWindow('close');
		myFunction();
		if(s==1){
			myFunction();
		}
	}
	function deletekategori(idkategori){
			$.get("<?php echo base_url();?>srikandi_kategori/dodel/"+idkategori, function(response) {
				$.notific8('Notification', {
				  	life: 5000,
				  	message: 'Delete data succesfully.',
					heading: 'Delete data',
				  	theme: 'lime2'
				});
				myFunction();
			});
	}
	function tambahsubkategori(subkategori){
			var subdit = document.getElementById("filter_subdit").value;
			$("#popup_content_sub").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			$("#popup_subketegori").jqxWindow({
                width: 700,
                height: 440,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup_subketegori").jqxWindow('open');
			$.get("<?php echo base_url();?>srikandi_kategori/add_sub_kategori/"+subkategori+"/"+subdit , function(response) {
				$("#popup_content_sub").html("<div>"+response+"</div>");
			});
	}
	function myFunction() {
    var x = document.getElementById("filter_subdit").value;
    	$.get("<?php echo base_url();?>srikandi_kategori/timeline_comment/"+x, function(response) {
			$("#timeline-kategori").html(response);
		});
	}
	$(function(){
		$("#bar_informasidankajian").click();
		$('#btn_tambah_kategori, #btn_hapus').jqxButton({ height: 25, theme: theme });
		myFunction();
		$('#btn_tambah_kategori').click(function(){
			var subdit = document.getElementById("filter_subdit").value;
			if(subdit=="0"){
				alert("Silahkan pilih Subdit terlebih dahulu");
			}else{
				$("#popup_content_upload").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
				var offset = $(this).offset();
				$("#popup_upload").jqxWindow({
					theme: theme, resizable: true, position: { x: offset.left + 135, y: offset.top},
	                width: 700,
	                height: 440,
	    			isModal: true, autoOpen: false, modalOpacity: 0.2
				});
	            $("#popup_upload").jqxWindow('open');
				$.get("<?php echo base_url();?>srikandi_kategori/add_kategori/"+subdit , function(response) {
					$("#popup_content_upload").html("<div>"+response+"</div>");
				});
			}
			});
     });
</script>
<div class="row-fluid">
   <div class="span12">
	   <h3 class="page-title">
		 {title}
	   </h3>
   </div>
</div>
<div id="popup_upload" style="display:none"><div id="popup_title_upload">Tambah Kategori</div><div id="popup_content_upload">{popup}</div></div>
<div id="popup_subketegori" style="display:none"><div id="popup_title_subkategori">Tambah Sub Kategori</div><div id="popup_content_sub">{popup}</div></div>
<div>
	<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
        <?php if($add_permission){?>
        	<input style="padding: 5px;" value=" Tambah Kategori Utama" id="btn_tambah_kategori" type="button"/>
        	<!--<input style="padding: 5px;" value=" Hapus Kajian " id="btn_hapus" type="button"/>-->
        <?php } ?>
	</div>
	<table bgcolor="#ebe7e0" width="100%">
	<tr bgcolor="#ebe7e0">
		<td bgcolor="#ebe7e0">
        <span style='float: left; position:relative; margin-top: 5px; margin-right: 4px;background-color:#ebe7e0;' >Pilih Subdit: </span>
        <div style='float: left;position:relative;width:500px;background-color:#ebe7e0;'><select onchange="myFunction()" class='jqx-input jqx-widget-content jqx-rc-all' id='filter_subdit' name='filter_subdit' style='height: 23px; float: left; width: 450px;' >{option_subdit}</select></div>
    	</td>
    </tr>
    </table> 
	<div style="background-color:#ffffff;">
        {menu_tree}
    	<div id="timeline-kategori"></div>
	</div>
      
<br>
<br>
<br>
</div>