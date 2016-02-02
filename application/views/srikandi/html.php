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
<div style="padding:6px;position:fixed;width:100%;left:865px">
	<table cellpadding='2' cellspacing='1' border='0' style='background:#CFCFCF;border:1px solid #CFCFCF;border-radius:4px;'>
	<tr>
		<td align="right" id="td_proses" style="color:white;">
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
			<td>Judul</td>
            <td>Deskripsi</td>
			<td>Status</td>
			<td>File</td>
			<td>Tanggal</td>
        </tr>
		<?php
    	$i=0;
        if(is_array($Rows)){
		foreach($Rows as $key=>$val){
			$i++;
			?>
		<tr>
			<td><?php echo $i ?></td>
			<td><?php echo $val['judul'] ?></td>
			<td><?php echo $val['deskripsi'] ?></td>
			<td><?php echo $val['prioritas'] ?></td>
			<td><?php echo $val['filename'] ?></td>
            <td><?php echo $val['waktu_update'] ?></td>
        </tr>
		<?php }}?>
		</thead>
	</table>
</div>