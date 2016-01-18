<script type="text/javascript">
	$(function() {
		function indicator(){
			$('#alert').show('fold',500);
			$('#alert').html('Saving data....');
		}

		$(function(){

			new AjaxUpload($('#linkimages'), {
				action: '<?php echo base_url()?>index.php/admin_content/douploadimages/{file_id}/gallery',
				name: 'uploadfile',
				onSubmit: function(file, ext){
					$('#linkimages_alert').show('fold',500);
					 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
						$('#linkimages_alert').html('<div align=right onClick="$(\'#linkimages_alert\').hide(\'fold\',500);" style="color:red;font-weight:bold">X</div><br>Only JPG, PNG or GIF files are allowed');
						return false;
					}
					$('#linkimages_alert').show('fold',500);
					$('#linkimages_alert').html('Uploading image...');
				},
				onComplete: function(file, response){
					stat = response.substr(0,7)
					filename = response.substr(10)
					if(stat==="success"){
						$('#linkimages').attr("src", "<?php echo base_url()?>media/images/gallery/{file_id}/"+filename);
						$('#links').val("<?php echo base_url()?>media/images/gallery/{file_id}/"+filename);
						$('#linkimages_alert').html('<div align=right onClick="$(\'#linkimages_alert\').hide(\'fold\',500);" style="color:red;font-weight:bold">X</div><br>Upload Image OK');
					} else{
						$('#linkimages_alert').html('<div align=right onClick="$(\'#linkimages_alert\').hide(\'fold\',500);" style="color:red;font-weight:bold">X</div><br>'+response);
					}
				}
			});
		});
	});
</script>

<div class="title">Gallery &raquo; {filename}</div>
<div class="clear">&nbsp;</div>
<div class="alert" id="alert" <?php if($this->session->flashdata('alert_form')=="") echo "style='display:none;'" ?>>
<div align=right onClick="$('#alert').hide('fold',1000);" style="color:red;font-weight:bold">X</div>
<?php echo $this->session->flashdata('alert_form')?>
</div>
<div class="clear">&nbsp;</div>
<form action="<?php echo base_url()?>index.php/admin_content/doeditgallery/file_id/{file_id}/id/{id}" method="POST" name="frmFiles" enctype="multipart/form-data">
	<button type="submit" class=btn>Simpan</button>
	<button type="reset" class=btn>Ulang</button>
	<button type="button" class=btn onclick="document.location.href='<?php echo base_url()?>index.php/admin_content/editgallery/file_id/{file_id}';">Kembali</button>
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
					<?php 
					foreach($lang as $row):
						eval("\$headline= (isset(\$headline_".$row['kode'].") ? \$headline_".$row['kode']." : '');");
					?>
						<tr>
							<td>Description / Link</td>
							<td>:</td>
							<td><input class=input type="text" size="50" name="headline_<?php echo $row['kode']?>" value="<?php echo $headline?>"/></td>
						</tr>
					<?php endforeach;?>
					<tr>
						<td>Author</td>
						<td>:</td>
						<td>{author}</td>
					</tr>
					<tr>
						<td>Time</td>
						<td>:</td>
						<td>{dtime}</td>
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
						<td rowspan="3">File</td>
						<td rowspan="3">:</td>
						<td><img src="<?php echo $linktmp?>" id='linkimages' style='border:1px solid #999999'></td>
					</tr>
					<tr>
						<td><input class=input type="text" size="50" name="links" id="links" value="<?php echo $links?>" readonly/></td>
					</tr>
					<tr>
						<td><div class="alert" id="linkimages_alert" style='display:none;'></div></td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
	<br />
	<button type="submit" class=btn>Simpan</button>
	<button type="reset" class=btn>Ulang</button>
	<button type="button" class=btn onclick="document.location.href='<?php echo base_url()?>index.php/admin_content/editgallery/file_id/{file_id}';">Kembali</button>
</form>
