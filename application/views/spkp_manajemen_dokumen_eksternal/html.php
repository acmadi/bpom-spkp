<script type="text/javascript">
    $(document).ready(function(){
		$("#tabeldata").jqxInput({ theme: theme });
		$("button,submit,reset").jqxInput({ theme: 'fresh' });
		$('#btn_print').click(function () {
			wincetak = window.open("", "Cetak Dokumen", "width=1,height=1,scrollbars=yes,menubar=no");
			wincetak.document.writeln($("#datacetak").html());
			wincetak.print();
		});
});
</script>
<div style="padding:6px;position:fixed;width:100%;left:865px">
	<table cellpadding='2' cellspacing='1' border='0' style='background:#CFCFCF;border:1px solid #CFCFCF;border-radius:4px;'>
	<tr>
		<td align="right" id="td_proses" style="color:white;">
			<button type="button" class=btn style="width:90px" id="btn_print">Print</button>
		</td>
	</tr>
	</table>
</div>
<div id="datacetak" style="padding:10px;padding-top:50px;text-align:center;border: 1px solid rgb(204,209,205);background: rgb(244,244,244);min-height:600px">
	<table id="tabeldata" cellpadding="2" cellspacing="2" width="100%" border='0'>
		<thead>
		<tr style="font-weight:bold">
            <td width='5%' align='center'>No</td>
			<td width='15%'>Nomor Buku</td>
			<td width='35%'>Judul</td>
			<td width='25%'>Pengarang</td>
			<td width='20%'>Penerbit</td>
        </tr>
		<?php
        $x=1;
		foreach($Rows as $key=>$val){?>
		<tr>
            <td valign='top' align='center'><?php echo $x; ?></td>
			<td valign='top'><?php echo $val['id']." ".$val['NO']." ".$val['tipe']; ?></td>
			<td valign='top'><?php echo $val['judul'] ?></td>
			<td valign='top'><?php echo $val['pengarang'] ?></td>
			<td valign='top'><?php echo $val['penerbit'] ?></td>
        </tr>
		<?php $x++; } ?>
		</thead>
	</table>
</div>