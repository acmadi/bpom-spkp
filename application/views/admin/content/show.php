<script type="text/javascript">
	$(function() {
		$("select[name='id_theme']").change(function() {
			var act = '<?php echo base_url(); ?>index.php/admin_content/index';
			if(jQuery.trim($("select[name='id_theme']").val()) !="") act += '/id_theme/' + jQuery.trim($("select[name='id_theme']").val());
			window.location= act;
			return false;
		});
	});
</script>
<div class="title">Content Manager</div>
<div class="clear">&nbsp;</div>
<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert" id="alert">
<div align=right onClick="$('#alert').hide('fold',1000);" style="color:red;font-weight:bold">X</div>
<?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>
<table cellpadding="1" cellspacing="1" border="0" width="100%">
<tr>
	<td>&nbsp;</td>
	<td align=right>Themes : <?php echo form_dropdown('id_theme', $theme_option, $id_theme," class=input");?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td align=right>
	<div class="paging">{start} - {end} dari {count} data 
	<?php if($page_count>1) { ?>|| Pindah halaman : <select class=input onchange="document.location.href='<?php echo base_url()?>index.php/admin_content/index/{segments}page/'+this.value+'.html';">';
		<?php for($i=1;$i<=$page_count;$i++): ?>
				<option value="<?php echo $i?>" <?php if($page==$i) echo "selected"; ?>><?php echo $i?></option>
		<?php endfor ?>
		</select> 
	<?php } ?>
	</div>
	</td>
</tr>
</table><br />
<?php echo $this->session->flashdata('notification')?><br />
	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="tbl">
		<thead>
			<tr>
				<th class=tbl_head width=5% align=center style="font-size:11px">NO</font></th>
				<th class=tbl_head width=5% align=center style="font-size:11px">ID</font></th>
				<th class=tbl_head width=40% style="font-size:11px">Filename</th>
				<th class=tbl_head width=40% style="font-size:11px">Controller</th>
				<th class=tbl_head width=5% align=center style="font-size:11px">Detail</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($query as $row):?>
			<tr onMouseOver="bgColor='#EEEEEE'" onmouseout="bgColor='#FFFFFF'">
				<td class=tbl_list align=center><?php echo $start++?>&nbsp;</td>
				<td class=tbl_list align=center><?php echo $row->id?>&nbsp;</td>
				<td class=tbl_list><?php echo $row->filename?>&nbsp;</td>
				<td class=tbl_list><?php echo $row->module?>&nbsp;</td>
				<td class=tbl_list align=center><a href="<?php echo base_url()?>index.php/admin_content/edit<?php echo $row->module?>/file_id/<?php echo $row->id?>" title="Ubah"><img src="<?php echo base_url()?>media/images/16_edit.gif" /></a></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<br />
