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
	<table id="tabeldata" cellpadding="2" cellspacing="2" width="100%">
		<thead>
		<tr style="font-weight:bold">
			<td>No</td>
			<td>NIP</td>
			<td>Nama</td>
			<td>Gelar</td>
			<td>Jenis Kelamin</td>
			<td>Tanggal Lahir</td>
			<td>Tempat Lahir</td>
            <td>Telp</td>
        </tr>
		<?php
        if(is_array($Rows)){
		foreach($Rows as $key=>$val){?>
		<tr>
			<td><?php echo $val['urut'] ?></td>
			<td>
                <?php
                $str_1 = substr($val['nip'],0,8);
                $str_2 = substr($val['nip'],8,6);
                $str_3 = substr($val['nip'],14,1);
                $str_4 = substr($val['nip'],15,3);
                echo $str_1." ".$str_2." ".$str_3." ".$str_4;
                ?>
            </td>
			<td><?php echo $val['nama'] ?></td>
			<td><?php echo $val['gelar'] ?></td>
			<td><?php echo $val['gendre'] ?></td>
			<td><?php echo $val['birthdate'] ?></td>
            <td><?php echo $val['birthplace'] ?></td>
			<td><?php echo $val['mobile'] ?></td>
		</tr>
		<?php }} ?>
		</thead>
	</table>
</div>