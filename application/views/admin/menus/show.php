<div style="padding:10px">
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jquery.dragndrop_2.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jquery.dragndrop.js"></script>
<script type="text/javascript">
$(function() {
    $("table[id^='menus_tbl']").tableDnD({
	    onDragClass: "tbl_head",
        onDrop: function(table, row) {
			var tmp = table.id.split("__");
			var rows = table.tBodies[0].rows;
			var debugStr = " ";
			for (var i=0; i<rows.length; i++) {
                debugStr += tmp[1]+"__"+i+"__"+rows[i].id+"|";
            }
			$("input[name='collector["+tmp[1]+"]']").val(debugStr);
        }
    });

	$("select[name=position]").change(function() {
		document.location.href='<?php  echo base_url()?>admin_menu/index/id_theme/{id_theme}/position/'+this.value;
	});

	$("select[name='id_theme']").change(function() {
		var act = '<?php echo base_url(); ?>index.php/admin_menu/index';
		if(jQuery.trim($("select[name='id_theme']").val()) !="") act += '/id_theme/' + jQuery.trim($("select[name='id_theme']").val());
		window.location= act;
		return false;
	});
});
</script>
<div class="title">Menus</div>
<div class="clear">&nbsp;</div>
<?php if($this->session->flashdata('alert_form')!=""){ ?>
<div class="alert" id="alert">
<div align=right onClick="$('#alert').hide('fold',1000);" style="color:red;font-weight:bold">X</div>
<?php echo $this->session->flashdata('alert_form')?>
</div>
<?php } ?>
<form action="<?php echo base_url()?>index.php/admin_menu/doorder/id_theme/{id_theme}" method="POST" name="frmFiles">
<table cellpadding="1" cellspacing="1" border="0" width="100%">
<tr>
	<td width="75%">
	<button type="submit" class=btn>Simpan Urutan</button>
	<button type="button" class=btn onclick="document.location.href='<?php echo base_url()?>index.php/admin_menu/add/id_theme/{id_theme}/position/{position}'">Tambah Menu Utama</button></td>
	<td align="right">Tentukan Posisi :
	<?php echo form_dropdown('position', $position_option, $position," class=input");?>
	</td>
	<td align="right">Themes : 
	<?php echo form_dropdown('id_theme', $theme_option, $id_theme," class=input");?></td>
</tr></table><br />
<?php echo $this->session->flashdata('notification')?><br />
	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="tbl" id="menus_tbl">
		<thead>
			<tr class="nodrop nodrag">
				<th class=tbl_head width=90% style="font-size:11px" colspan="3">Menu</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{menu_tree}</td>
			</tr>
		</tbody>
	</table>
	<br />
	<button type="submit" class=btn>Simpan Urutan</button>
	<button type="button" class=btn onclick="document.location.href='<?php echo base_url()?>index.php/admin_menu/add/id_theme/{id_theme}/position/{position}'">Tambah Menu Utama</button>
</form>
</div>