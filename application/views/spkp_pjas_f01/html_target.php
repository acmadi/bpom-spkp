<script type="text/javascript">
    $(document).ready(function(){
		$("#tabeldataupload").jqxInput({ theme: theme });
		$("button,submit,reset").jqxInput({ theme: 'fresh' });
		$('#btn_print').click(function () {
			wincetak = window.open("", "Cetak Dokumen", "width=1,height=1,scrollbars=no,menubar=no");
			wincetak.document.writeln($("#datacetakupload").html());
			wincetak.print();
		});
});
</script>
<div style="padding:6px;position:fixed;width:100%;left:700px">
	<table cellpadding='2' cellspacing='1' border='0' style='background:#CFCFCF;border:1px solid #CFCFCF;border-radius:4px;'>
	<tr>
		<td align="center" id="td_proses" style="color:white;">
			<button type="button" class=btn style="width:90px" id="btn_print">Print</button>
		</td>
	</tr>
	</table>
</div>
<div id="datacetakupload" style="padding:10px;padding-top:50px;text-align:center;border: 1px solid rgb(204,209,205);background: rgb(244,244,244);min-height:600px">
	<table id="tabeldataupload" cellpadding="2" cellspacing="2" width="100%" border='0'>
		<thead>
		<tr style="font-weight:bold">
			<td>No</td>
			<td>Nama</td>
			<td>Alamat</td>
            <td>Target</td>
			<td>Produk</td>
			<td>Jumlah</td>
        </tr>
		<?php
        if(is_array($Rows)){
		foreach($Rows as $key=>$val){?>
		<tr>
			<td><?php echo $val['urut'] ?></td>
			<td><?php echo $val['nama'] ?></td>
			<td><?php echo $val['alamat'] ?></td>
            <td><?php echo $val['target'] ?></td>
			<td><?php echo $val['produk'] ?></td>
			<td><?php echo $val['jumlah'] ?></td>
        </tr>
		<?php }}?>
		</thead>
	</table>
</div>