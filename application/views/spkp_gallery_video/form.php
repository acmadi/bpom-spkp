<script src="<?php echo base_url()?>plugins/js/ckeditor/ckeditor.js"></script>
<style>
	.cke_textarea_inline
	{
		padding: 10px;
		height: 200px;
		overflow: auto;

		border: 1px solid gray;
		-webkit-appearance: textfield;
	}
</style>
<script type="text/javascript">
	$(function(){
		$('button, submit, reset').jqxButton({ height: 25, theme: theme });
		$("input[name='title_content_ina']").jqxInput({ theme: 'fresh', height: '22px', width: '300px' });
		$("input[name='title_content_en']").jqxInput({ theme: 'fresh', height: '22px', width: '300px'});
	});

function back(){
	window.location.href="<?php echo base_url()?>spkp_gallery_video/show_list";
}

function upload_image(){
	$('#links').click();
}

function save_dialog(){
	var data = new FormData();
	jQuery.each($('#links')[0].files, function(i, file) {
		data.append('links', file);
	});
	data.append('file_id', $('#file_id').val());
	data.append('id', $('#id').val());
	data.append('title_content_ina', $('#title_content_ina').val());
	data.append('title_content_en', $('#title_content_en').val());
	data.append('author', $('#author').val());
	data.append('getlink', $('#getlink').val());
	if(document.getElementById('published').checked){
		data.append('published', $('#published').val());
	}
	else{
		data.append('published', $('#published_hide').val());
	}
	data.append('content_ina', CKEDITOR.instances.content_ina.getData());
	data.append('content_en', CKEDITOR.instances.content_en.getData());
	
	$("#divfrmData").hide();
	$("#divLoad").css("display","block");
	$("#divLoad").html("<div style='text-align:center;margin-top: 70px'><br><br><br><br><img src='<?php echo base_url();?>media/images/loaderB64.gif' alt='loading content.. '><br>Uploading</div>");

$.ajax({
	   type: "POST",
	   cache: false,
	   contentType: false,
	   processData: false,
	   url: "<?php echo base_url(); ?>spkp_gallery_video/do{action}/{mod}/{file_id}/{id}",
	   data: data,
	   success: function(response){
			if(response=="1"){
			   $('#links').val("");
			   $.notific8('Notification', {
				   life: 5000,
				   message: 'Save data succesfully.',
				   heading: 'Saving data',
				   theme: 'lime'
			   });
			   
			   $("#divLoad").css("display","none");
			   
			   $.ajax({
                     type: "POST",
                     url: "<?php echo base_url(); ?>spkp_gallery_video/load_form/{mod}/{file_id}/{id}",
                     success: function(response){
                        $("#divfrmData").show();
                        $("#divfrmData").html(response);
                    }
				});
				
			}else{
				$.notific8('Notification', {
				  life: 5000,
				  message: response,
				  heading: 'Saving data FAIL',
				  theme: 'red'
				});
				$("#divLoad").css("display","none");
				
				$.ajax({
                     type: "POST",
                     url: "<?php echo base_url(); ?>spkp_gallery_video/load_form/{mod}/{file_id}/{id}",
                     success: function(response){
                        $("#divfrmData").show();
                        $("#divfrmData").html(response);
                    }
				});
			}
	   } 
	});
}
</script>
<div style="display: none;" id="divLoad"></div>
<div id="divfrmData">
	<div  style="height:850; padding:10px; border:1px solid #CDCDCD;">
		<form method="post" id="frmData">
			<div class="row-fluid">
			   <div class="span12">
				   <h3 class="page-title">
					 {title}
				   </h3>
			   </div>
			</div>
			<div style="background: #F4F4F4;padding: 5px;text-align: right;">
				<span id="show-time" style="display: none;"></span>
				<span style="float: right;padding: 5px;display: none;color: green;" id="msg"></span>
				<button type="button" onclick="save_dialog();">Simpan</button>
				<button type="reset">Ulang</button>
				<button type="button" onclick="back();">Kembali</button>
			</div>
			<br/>
			<table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
				<tr style="display: none;">
					<td width='40%'>ID</td>
					<td width='1%' align='middle'>:</td>
					<td>
						<input type="text" size="10" maxlength="15" name="file_id" id="file_id" value="<?php echo $file_id;?>"/>
						<input type="text" size="10" maxlength="15" name="id" id="id" value="<?php if($action=="add"){ echo $get_id+1; }else{echo $id;}?>"/>
					</td>
				</tr>
				<?php 
				foreach($lang as $row):
					eval("\$title_content= (isset(\$title_content_".$row['kode'].") ? \$title_content_".$row['kode']." : '');");?>
					<tr>
						<td><?php if($mod!='event'){echo 'Title ';}else{echo 'Nama Kegiatan - ';}  echo '<b>'.$row['lang']; ?></b></td>
						<td align='middle'>:</td>
						<td>
							<input class=input type="text" size="50" name="title_content_<?php echo $row['kode']?>" id="title_content_<?php echo $row['kode']?>" value="<?php echo $title_content?>" />
						</td>
					</tr>
				<?php endforeach;?>
				<tr height=30>
					<td>Publisher</td>
					<td align='middle'>:</td>
					<td>
						<input name="author" id="author" style="display:none" readonly="" value="<?php if(set_value('author')=="" && isset($author)){
							echo $author;
						}else{
							echo $this->session->userdata('username');
						}?>"/><?php if(set_value('author')=="" && isset($author)){
							echo $author;
						}else{
							echo $this->session->userdata('username');
						}?>
					</td>
				<tr height=30>
					<td>File </td>
					<td align='middle'>:</td>
					<td><?php if(set_value('links')=="" && isset($links)){
							echo $links;
						}else{
							echo 'No File Uploaded'; }?> - 
						<input type="file" name="links" id="links" size="50"/>
					</td>
				</tr>
				</tr>
				<tr height=30>
					<td>Hits</td>
					<td align='middle'>:</td>
					<td><?php if(set_value('hits')=="" && isset($hits)){
							echo $hits;
						}else{
							echo 0;
						}?>
					</td>
					</td> 
				</tr>
				<tr height=30>
					<td>Publish / Unpublish</td>
					<td align='middle'>:</td>
					<td>
						<input type="checkbox" size="80" maxlength="100" id="published" name="published" value=1 <?php if($published==1){ echo 'checked'; }?> />
						<input type="hidden" id="published_hide" name="published" value=0 />
					</td>
				</tr>
					<?php foreach($lang as $row):
						eval("\$content= (isset(\$content_".$row['kode'].") ? \$content_".$row['kode']." : '');");
					?>
						<tr>
							<td colspan="4">Content <b><?php echo $row['lang']?></b></td>
						</tr>
						<tr>
							<td colspan="4" style="background:white"><textarea id="content_<?php echo $row['kode']?>" name="content_<?php echo $row['kode']?>" ><?php echo $content?></textarea></td>
						</tr>
					<?php endforeach;?>
				<tr>
					<td colspan="4" style="display: none;">
						<input name="getlink" id="getlink" value="<?php if(set_value('links')=="" && isset($links)){
							echo $links;
						}else{
							echo 'none'; } ?>"/>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
<script>
	CKEDITOR.editorConfig = function( config ) {
		CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
	};
	CKEDITOR.inline( 'content_ina' );
	CKEDITOR.inline( 'content_en' );
</script>
