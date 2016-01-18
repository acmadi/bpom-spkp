<script type="text/javascript">
    $(document).ready(function(){
		$("#tabeldatapangkat").jqxInput({ theme: theme });
		$("button,submit,reset").jqxInput({ theme: 'fresh' });
		$('#btn_print').click(function () {
			wincetak = window.open("", "Cetak Dokumen", "width=1,height=1,scrollbars=no,menubar=no");
			wincetak.document.writeln($("#datacetakpangkat").html());
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
<div id="datacetakpangkat" style="padding:10px;padding-top:50px;text-align:center;border: 1px solid rgb(204,209,205);background: rgb(244,244,244);min-height:600px">
	<table id="tabeldatapangkat" cellpadding="2" cellspacing="2" width="100%">
		<thead>
		<tr style="font-weight:bold">
			<td>No</td>
            <td>Subdit</td>
            <td align='center'>Status</td>
			<td align='center'>Tanggal Mulai</td>
            <td align='center'>Tanggal Akhir</td>
            <td align='center'>Golongan</td>
            <td align='center'>Tanggal SK</td>
			<td>Nomor SK</td>
			<td>Pejabat</td>
        </tr>
		<?php
        if(is_array($Rows)){
		foreach($Rows as $key=>$val){?>
		<tr>
			<td><?php echo $val['urut'] ?></td>
			<td><?php echo $val['subdit_ket'] ?></td>
            <td align='center'><?php echo $val['status'] ?></td>
            <td align='center'><?php echo $val['tgl_mulai'] ?></td>
            <td align='center'><?php echo $val['tgl_sampai'] ?></td>
			<td align='center'><?php echo $val['golongan'] ?></td>
			<td align='center'><?php echo $val['sk_jb_tgl'] ?></td>
			<td><?php echo $val['sk_jb_nomor'] ?></td>
            <td><?php echo $val['sk_jb_pejabat'] ?></td>
		</tr>
		<?php }} ?>
		</thead>
	</table>
</div>