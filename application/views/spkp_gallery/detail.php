<link href="<?php echo base_url()?>plugins/js/fancybox/source/jquery.fancybox.css" type="text/css" rel="stylesheet">
<script type="text/javascript" language="javascript" src="<?php echo base_url();?>plugins/js/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<script>
	$(document).ready(function() {
	jQuery(".fancybox").fancybox();
	});
	$(function(){
       $("#bar_perpustakaan").click();
	   
	   $('div[id^="btnupload"]').click(function(){
	   var id= $(this).attr('id').split("__");
			$("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			var w=700; var h=275;
			var x=(screen.width/2)-(w/2);
			var y=(screen.height/2)-(h/2)+$(window).scrollTop();
			$("#popup").jqxWindow({
				theme: theme, resizable: true, position: { x: x, y: y},
                width: w,
                height: h,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_gallery/upload/"+id[1] , function(response) {
				$("#popup_content").html("<div>"+response+"</div>");
			});
		});
				

	$("div[id^='btnedit']").click(function(){
		var id= $(this).attr('id').split("__");
		//confirm('Hapus dokumen ini?'+id);
			$("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			var w=700; var h=275;
			var x=(screen.width/2)-(w/2);
			var y=(screen.height/2)-(h/2)+$(window).scrollTop();
			$("#popup").jqxWindow({
				theme: theme, resizable: true, position: { x: x, y: y},
                width: w,
                height: h,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_gallery/edit/"+id[1] , function(response) {
				$("#popup_content").html("<div>"+response+"</div>");
			});
	});	
	
	$("div[id^='btndelete']").click(function(){
		var id= $(this).attr('id').split("__");
		if(confirm("Anda yakin akan menghapus data ("+id[1]+") ini?")){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/spkp_gallery/dodelimg/"+id[1],
				success: function(response){
					 if(response=="1"){
						 $('#clearfilteringbutton').click();
						 $.notific8('Notification', {
						  life: 5000,
						  message: 'Delete data succesfully.',
						  heading: 'Delete data',
						  theme: 'lime'
						});						
					window.location.href = "<?php echo base_url();?>spkp_gallery/show/<?php echo $id;?>";
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
	});
});	

	
</script>
<div id="popup" style="display:none"><div id="popup_title">{title}</div><div id="popup_content">{popup}</div></div>

<div class="row-fluid">
   <div class="span12">
	   <h3 class="page-title">
		<a href="<?php echo base_url()?>spkp_gallery/">{title}</a> : : <?php echo $judul;?>
	   </h3>
   </div>
</div>
<?php if($add_permission2==true){ ?>
<form method="POST" form="<?php base_url() ?>spkp_gallery/show/{id}" style='float:right'>
	<select name="publishing" id="publishing" style="height:25px;padding:2px;" onchange="this.form.submit()">
		<option value='1' <?php echo(isset($publishing) && $publishing==1 ? "selected":"") ?>>Published</option>
		<option value='0' <?php echo(isset($publishing) && $publishing==0 ? "selected":"") ?>>Unpublished</option>
	</select>
</form>
<?php } ?>
<div class="row-fluid">	
					
	<div class="dokumentasi-grid-detail dg-xlarge">		
		<div style="background:#999999;padding:4px;position:relative;top:0;float:right;cursor:pointer" id="btnedit__<?php echo $id;?>">
			<i class="icon-edit-sign" style="color:#FFFFFF;font-size:25px;position:relative;" title="Ubah Foto"></i>
		</div>
		<div style="background:#999999;padding:4px;position:relative;top:0;float:right;margin-right:2px;cursor:pointer" id="btndelete__<?php echo $id;?>">
			<i class="icon-trash" style="color:#FFFFFF;font-size:25px;position:relative;" title="Hapus Foto"></i>				
		</div>
		<div style="background:#999999;padding:6.5px 5px;position:relative;top:0;float:right;margin-right:2px;cursor:pointer;color:#FFFFFF" title="Upload Foto" id="btnupload__<?php echo $id;?>">
			Upload Foto
		</div>
		
		
		
		<div class="dg-desc-detail pad10">	
			<div class="dg-content"><?php echo $keterangan;?></div>	
		</div>

		<div class="img-thumbnail-wrapper">
			<?php foreach($get_data_list as $rs): ?>				
			<div class="img-thumbnail" style="background-image: url(<?php echo base_url();?>public/files/spkp_gallery/<?php echo $rs->id_judul;?>/<?php echo $rs->filename;?>); background-size: cover; -webkit-transform: scale(1, 1) perspective(10000px) rotateX(0deg); opacity: 1; background-position: 50% 49%; background-repeat: no-repeat no-repeat;width:200px;height:150px">
				<div style="background:#fbbc11;padding:4px;position:relative;float:left;margin-right:2px;cursor:pointer" id="btndelete__<?php echo $rs->id;?>">
					<i class="icon-trash" style="color:#FFFFFF;font-size:25px;position:relative;" title="Hapus Foto"></i>				
				</div>				
				<a href="<?php echo base_url();?>public/files/spkp_gallery/<?php echo $rs->id_judul;?>/<?php echo $rs->filename;?>" rel="group" class="fancybox" title="<?php echo $rs->judul;?>">
				<div style="background:#fbbc11;padding:4px;position:relative;float:left;margin-right:2px;cursor:pointer" id="zoom">					
						<i class="icon-zoom-in" style="color:#FFFFFF;font-size:25px;position:relative;" title="Zoom In"></i>	
				</div>						
				</a>	
			
			</div>
			
			<?php endforeach; ?>
		</div>
	
	</div>		
			
</div>
<script  type="text/javascript">
	jQuery(document).ready(function() {
	});
</script>