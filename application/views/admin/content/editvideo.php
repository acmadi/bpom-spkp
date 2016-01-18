<script type="text/javascript">
	$(function() {

		$("#dtime").datepicker({
				changeMonth: true,
				changeYear: true
			});
		$("#dtime_end").datepicker({
				changeMonth: true,
				changeYear: true
			});
		$("#preview").click(function(){
			var x = $("textarea[name='content']").val();
			$("#video_frame").html(x);
		});
		$("#hide").click(function(){
			$("#video_frame").html("");
		});

		new AjaxUpload($('#thumb_linkimages'), {
			action: '<?php echo base_url()?>index.php/admin_content/douploadimages/{file_id}/video',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				$('#thumb_linkimages_alert').show('fold',500);
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
					$('#thumb_linkimages_alert').html('<div align=right onClick="$(\'#thumb_linkimages_alert\').hide(\'fold\',500);" style="color:red;font-weight:bold">X</div><br>Only JPG, PNG or GIF files are allowed');
					return false;
				}
				$('#thumb_linkimages_alert').show('fold',500);
				$('#thumb_linkimages_alert').html('Uploading image...');
			},
			onComplete: function(file, response){
				stat = response.substr(0,7)
				filename = response.substr(10)
				if(stat==="success"){
					$('#thumb_linkimages').attr("src", "<?php echo base_url()?>media/images/video/{file_id}/"+filename);
					$('#links').val("<?php echo base_url()?>media/images/video/{file_id}/"+filename);
					$('#thumb_linkimages_alert').html('<div align=right onClick="$(\'#thumb_linkimages_alert\').hide(\'fold\',500);" style="color:red;font-weight:bold">X</div><br>Upload Image OK');
				} else{
					$('#thumb_linkimages_alert').html('<div align=right onClick="$(\'#thumb_linkimages_alert\').hide(\'fold\',500);" style="color:red;font-weight:bold">X</div><br>'+response);
				}
			}
		});
	});
</script>

<div class="title">Event &raquo; {filename}</div>
<div class="clear">&nbsp;</div>
<?php if($this->session->flashdata('alert_form')!=""){ ?>
<div class="alert" id="alert">
<div align=right onClick="$('#alert').hide('fold',1000);" style="color:red;font-weight:bold">X</div>
<?php echo $this->session->flashdata('alert_form')?>
</div>
<?php } ?>
<div class="clear">&nbsp;</div>
<form action="<?php echo base_url()?>index.php/admin_content/doeditvideo/file_id/{file_id}/id/{id}" method="POST" name="frmFiles">
	<button type="submit" class=btn>Simpan</button>
	<button type="reset" class=btn>Ulang</button>
	<button type="button" class=btn onclick="document.location.href='<?php echo base_url()?>index.php/admin_content/editvideo/file_id/{file_id}';">Kembali</button>
	<br />
	<br />
	<table border="0" cellpadding="0" cellspacing="8" class="panel">
		<tr>
			<td>

				<table border="0" cellpadding="3" cellspacing="2">
					<?php 
					foreach($lang as $row):
						eval("\$title_content= (isset(\$title_content_".$row['kode'].") ? \$title_content_".$row['kode']." : '');");
					?>
						<tr>
							<td>Title <b><?php echo $row['lang']?></b></td>
							<td>:</td>
							<td><input class=input type="text" size="50" name="title_content_<?php echo $row['kode']?>" value="<?php echo $title_content?>" /></td>
						</tr>
					<?php endforeach;?>
					<tr>
						<td>Author</td>
						<td>:</td>
						<td>{author}</td>
					</tr>
					<tr>
						<td>Hits</td>
						<td>:</td>
						<td>{hits}</td>
					</tr>
					<tr>
						<td>Publish/Unpublish</td>
						<td>:</td>
						<td><input class=input type="checkbox" name="published" value="1" <?php if($published) echo "checked"; ?>></td>
					</tr>
					<tr>
						<td>Thumbnail</td>
						<td>:</td>
						<td><img src="<?php echo $links?>" id='thumb_linkimages' style='border:1px solid #999999' width="250"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><div class="alert" id="thumb_linkimages_alert" style='display:none;float:left'></div></td>
						<input class=input type="hidden" size="80" name="links" id="links" value="<?php echo $links1?>" readonly/>
					</tr>
					<?php 
					foreach($lang as $row):
						eval("\$headline= (isset(\$headline_".$row['kode'].") ? \$headline_".$row['kode']." : '');");
					?>
						<tr>
							<td>Headline <b><?php echo $row['lang']?></b></td>
							<td>:</td>
							<td><textarea name="headline_<?php echo $row['kode']?>" class=input rows=5 cols=80><?php echo $headline?></textarea></td>
						</tr>
					<?php endforeach;?>
					<tr>
						<td>Embed Code</td>
						<td>:</td>
						<td><textarea name="content" class=input rows=10 cols=80><?php echo $content?></textarea></td>
					</tr>
					<tr>
						<td colspan=2>&nbsp;</td>
						<td>
							<input type="button" name="preview" class=btn value="Preview" id="preview">
							<input type="button" name="hide" class=btn value="Hide" id="hide">
							<br><br>
							<div id="video_frame"></div>
						</td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
	<br />
	<button type="submit" class=btn>Simpan</button>
	<button type="reset" class=btn>Ulang</button>
	<button type="button" class=btn onclick="document.location.href='<?php echo base_url()?>index.php/admin_content/editvideo/file_id/{file_id}';">Kembali</button>
</form>
