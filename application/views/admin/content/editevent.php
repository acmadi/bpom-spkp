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

		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '<?php echo base_url()?>plugins/js/tinymce/jscripts/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			content_css : "<?php echo base_url()?>application/views/<?php echo $this->template->template?>/css/css-rte.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "<?php echo base_url()?>js/tinymce/examples/lists/template_list.js",
			external_link_list_url : "<?php echo base_url()?>js/tinymce/examples/lists/link_list.js",
			external_image_list_url : "<?php echo base_url()?>js/tinymce/examples/lists/image_list.js",
			media_external_list_url : "<?php echo base_url()?>js/tinymce/examples/lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});

		new AjaxUpload($('#linkimages'), {
			action: '<?php echo base_url()?>index.php/admin_content/douploadimages/{file_id}/event',
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
				if(response==="success"){
					$('#linkimages').attr("src", "<?php echo base_url()?>media/images/event/{file_id}/"+file);
					$('#links').val("<?php echo base_url()?>media/images/event/{file_id}/"+file);
					$('#linkimages_alert').html('<div align=right onClick="$(\'#linkimages_alert\').hide(\'fold\',500);" style="color:red;font-weight:bold">X</div><br>Upload Image OK<br>Please copy image url above');
				} else{
					$('#linkimages_alert').html('<div align=right onClick="$(\'#linkimages_alert\').hide(\'fold\',500);" style="color:red;font-weight:bold">X</div><br>'+response);
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
<form action="<?php echo base_url()?>index.php/admin_content/doeditevent/file_id/{file_id}/id/{id}" method="POST" name="frmFiles">
	<button type="submit" class=btn>Simpan</button>
	<button type="reset" class=btn>Ulang</button>
	<button type="button" class=btn onclick="document.location.href='<?php echo base_url()?>index.php/admin_content/editevent/file_id/{file_id}';">Kembali</button>
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
						<td>Time Start/End</td>
						<td>:</td>
						<td><input type="text" name="dtime" id="dtime" value="{dtime}" class="input" size="10"> - <input type="text" name="dtime_end" id="dtime_end" value="{dtime_end}" class="input" size="10"></td>
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
					<?php 
					foreach($lang as $row):
						eval("\$content= (isset(\$content_".$row['kode'].") ? \$content_".$row['kode']." : '');");
					?>
						<tr>
							<td colspan="3">Content <b><?php echo $row['lang']?></b></td>
						</tr>
						<tr>
							<td colspan="3" style="background:white"><textarea name="content_<?php echo $row['kode']?>" cols="120" rows="50"  class="tinymce"><?php echo $content?></textarea></td>
						</tr>
					<?php endforeach;?>
					<tr>
						<td rowspan="3">Upload files/images</td>
						<td rowspan="3">:</td>
						<td><img src="<?php echo $linktmp?>" id='linkimages' style='border:1px solid #999999'></td>
					</tr>
					<tr>
						<td><input class=input type="text" size="80" name="links" id="links" readonly/></td>
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
	<button type="button" class=btn onclick="document.location.href='<?php echo base_url()?>index.php/admin_content/editevent/file_id/{file_id}';">Kembali</button>
</form>
