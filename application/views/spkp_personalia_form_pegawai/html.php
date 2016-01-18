<script type="text/javascript">
    $(document).ready(function(){
		$("#tabeldata").jqxInput({ theme: theme });
		$("button,submit,reset").jqxInput({ theme: 'fresh' });
		$('#btn_print').click(function () {
			wincetak = window.open("", "Cetak Dokumen", "width=1,height=1,scrollbars=no,menubar=no");
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
			<td width='3%'>No</td>
			<td width='9%' align='center'>Mulai Cuti</td>
			<td width='23%'>Jenis</td>
			<td width='20%'>Keperluan</td>
            <td width='10%'>Lama Cuti</td>
            <td width='10%' align='center'>Persetujuan</td>
			<td width='8%' align='center'>Kirim</td>
		</tr>
		<?php
		foreach($Rows as $key=>$val){?>
		<tr>
			<td><?php echo $val['urut'] ?></td>
			<td align='center'><?php echo $val['stat_tgl'] ?></td>
			<td><?php echo $val['keterangan'] ?></td>
			<td><?php echo $val['alasan'] ?></td>
            <?php
            if($val['kode']=='itm'){
                ?>
                <td align='center'>-</td>
                <?php
            }else{
                ?>
                <td align='center'><?php echo $val['jml']." ".$val['hitungan']; ?></td>
                <?php
            }
            ?>
            <td align='center'><?php echo $val['approve'] ?></td>
			<td align='center'><?php echo $val['STATUS'] ?></td>
		</tr>
		<?php } ?>
		</thead>
	</table>
</div>