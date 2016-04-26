<script>
	$(function(){
        $("#bar_perpustakaan").addClass("active open");
        $("#galeri").addClass("active");
	   
	   $('#btn_tambah').click(function(){
			$("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			var w=750; var h=250;
			var x=(screen.width/2)-(w/2);
			var y=(screen.height/2)-(h/2)+$(window).scrollTop();
			$("#popup").jqxWindow({
				theme: theme, resizable: true, position: { x: x, y: y},
                width: w,
                height: h,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_gallery/add", function(response) {
				$("#popup_content").html("<div>"+response+"</div>");
			});
		});
				

	$("div[id^='btnedit']").click(function(){
		var id= $(this).attr('id').split("__");
		//confirm('Hapus dokumen ini?'+id);
			$("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			var w=750; var h=250;
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
				url: "<?php echo base_url()?>index.php/spkp_gallery/dodel/"+id[1],
				success: function(response){
					 if(response=="1"){
						 $('#clearfilteringbutton').click();
						 $.notific8('Notification', {
						  life: 5000,
						  message: 'Delete data succesfully.',
						  heading: 'Delete data',
						  theme: 'lime'
						});
						
					window.location.href = "<?php echo base_url();?>spkp_gallery";
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
<script type="text/javascript" src="<?php echo base_url()?>plugins/js/jPlayer/jquery.jplayer.min.js"></script>

<div id="popup" style="display:none"><div id="popup_title">{title}</div><div id="popup_content">{popup}</div></div>
<div class="row-fluid">
   <div class="span12">
	   <h3 class="page-title">
		{title}
	   </h3>
   </div>
</div>
<?php if($add_permission2==true){ ?>
<form method="POST" form="<?php base_url() ?>spkp_gallery" style='float:right'>
	<select name="publishing" id="publishing" style="height:25px;padding:2px;" onchange="this.form.submit()">
		<option value='1' <?php echo(isset($publishing) && $publishing==1 ? "selected":"") ?>>Published</option>
		<option value='0' <?php echo(isset($publishing) && $publishing==0 ? "selected":"") ?>>Unpublished</option>
	</select>
</form>
<?php } ?>
<input style="padding: 5px; height: 27px;" value=" Tambah Kegiatan " id="btn_tambah" type="button" role="button" class="jqx-rc-all jqx-rc-all-arctic jqx-button jqx-button-arctic jqx-widget jqx-widget-arctic jqx-fill-state-normal jqx-fill-state-normal-arctic" aria-disabled="false"><br/><br/>
<div class="row-fluid">
	<?php foreach($get_data as $val): ?>
		<div class="dokumentasi-grid dg-large dg-medium dg-small">
			<?php if($val->filename != "NULL" || $val->filename != ""){ ?>
				<div class="dg-img" style="background-image: url(<?php echo base_url();?>public/files/spkp_gallery/<?php echo $val->id;?>/<?php echo $val->filename;?>); background-size: cover; -webkit-transform: scale(1, 1) perspective(10000px) rotateX(0deg); opacity: 1; background-position: 50% 49%; background-repeat: no-repeat no-repeat;width:200px;height:150px">
				<?php }else{ ?>
				<div class="dg-img" style="background-image: url(<?php echo base_url();?>media/images/smily-user-icon.jpg); background-size: cover; -webkit-transform: scale(1, 1) perspective(10000px) rotateX(0deg); opacity: 1; background-position: 50% 49%; background-repeat: no-repeat no-repeat;">
				<?php } ?></div>
			<a href="<?php echo base_url()?>spkp_gallery/show/<?php echo $val->id;?>">
				<div class="dg-desc left10">
					<div class="dg-title"><?php echo substr($val->judul,0,50);?>....</div>	
					<div class="dg-content"><?php echo substr($val->keterangan,0,121);?>....</div>	
				</div>
			</a>
				<?php if($add_permission){?>
					<div style="background:#999999;padding:4px;position:relative;float:right;top:0;cursor:pointer" id="btnedit__<?php echo $val->id;?>">
						<i class="icon-edit-sign" style="color:#FFFFFF;font-size:25px;position:relative;" title="Tambah Galeri"></i>				
					</div>
					<div style="background:#999999;padding:4px;position:relative;float:right;top:0;cursor:pointer;margin-right:2px" id="btndelete__<?php echo $val->id;?>">
						<i class="icon-trash" style="color:#FFFFFF;font-size:25px;position:relative;" title="Hapus Galeri"></i>				
					</div>
				<?php } ?>
				</div>
			<?php endforeach; ?>
		</div>
</div>