<!--div class="title2">{title_form}</div-->
<div class="clear">&nbsp;</div>
<?php if($this->session->flashdata('alert')!="")
{ ?>
<div class="alert" id="alert">
<div align=right onClick="$('#alert').hide('slow');" style="color:red;font-weight:bold">X</div>
<?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>
<div class="clear">&nbsp;</div>
<?php if(validation_errors()==TRUE):?>	
<div class="alert" id="alert">
<div align=right onClick="$('#alert').hide('slow');" style="color:red;font-weight:bold">X</div>
<?php echo validation_errors();?>
</div>
<?php endif;?>
<div style="width:98%;height:25;background-color:#ffffff;-moz-border-radius:15px;border-radius:15px;padding:0 5 5 5;border:3px solid;border-color:#ffffff;">
	{button_atas}
</div><br>
<style>
	.panel2{
		background-color:#cacfdb;
	}
	.panel2 td{
		background-color:#9cb0e7;
		color:white;
		font-weight:bold;
		padding: 10 10 10 10;
	}
	.judul{
		text-align:center;
		font-weight:bold;
		background-color:#585858;
		color:white;
		font-size:12px;
	}
	.evaluasi td{
		background-color:#eeeeee;
	}
</style>
<script>
	$(document).ready(function(){
		$("#tabs").tabs();
		$('a.print-preview').printPreview();
	});
	function printPDF(){
		var x = window.open('<?php echo base_url()?>pdb_master_data_balai/print_pdf/<?php echo $databalai['id_balai']; ?>', 'cetak pdf','toolbar=0,menubar=0,resizable=0');
	}
</script>
<div style="width:98%;background-color:#ffffff;-moz-border-radius:15px;border-radius:15px;padding:5px;border:3px solid;border-color:#ebebeb;">
	<table border="0" cellpadding="3" cellspacing="0" class="panel2" width=60% style="border-top:4px solid white;border-right:4px solid white">
		<tr>
			<td width="20%">Id Balai</td>
			<td width="2%" align="center">:</td>
			<td style="background:white;color:#6e6e6e;" width="25%">
				<?php echo $databalai['id_balai']; ?>
			</td>
		</tr>
		<tr>
			<td width="20%">Nama Balai</td>
			<td width="2%" align="center">:</td>
			<td style="background:white;color:#6e6e6e;" width="25%">
				<?php echo $databalai['nama_balai']; ?>
			</td>
		</tr>
		<tr>
			<td width="20%" valign="top">Alamat</td>
			<td width="2%" align="center" valign="top">:</td>
			<td style="background:white;color:#6e6e6e;" width="25%">
				<?php echo $databalai['alamat']; ?>
			</td>
		</tr>
		<tr>
			<td width="20%">Propinsi</td>
			<td width="2%" align="center">:</td>
			<td style="background:white;color:#6e6e6e;" width="25%">
				<?php echo $databalai['nama_propinsi']; ?>
			</td>
		</tr>
		<tr>
			<td width="20%">Nama Kepala</td>
			<td width="2%" align="center">:</td>
			<td style="background:white;color:#6e6e6e;" width="25%">
				<?php echo $databalai['nama_kepala']; ?>
			</td>
		</tr>
	</table>
</div><br>
<div style="width:98%;height:25;background-color:#ffffff;-moz-border-radius:15px;border-radius:15px;padding:0 5 5 5;border:3px solid;border-color:#ffffff;">
	{button_atas}
</div>
<div id="datacetak" style="display:none;">
	<?php
	if(isset($content_print))
		echo $content_print;
	?>
	<br>
</div>