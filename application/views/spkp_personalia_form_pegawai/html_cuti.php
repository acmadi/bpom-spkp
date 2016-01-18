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
			<td width='30%'>Nama</td>
			<td width='20%' align='center'>NIP</td>
			<td width='10%' align='center'>Sisa Cuti <?php echo date('Y')-1; ?></td>
			<td width='10%' align='center'>Sisa Cuti <?php echo date('Y'); ?></td>
			<td width='10%' align='center'>Sisa Cuti Gabungan</td>
		</tr>
		<?php
        $x=0;
		foreach($Rows as $key=>$val){
		$x++;  
        ?>
		<tr>
			<td><?php echo $x; ?></td>
			<td><?php echo $val['nama'] ?></td>
			<td align='center'>
                <?php
                $frmt1 = substr($val['nip'],0,8);
                $frmt2 = substr($val['nip'],8,6);
                $frmt3 = substr($val['nip'],14,1);
                $frmt4 = substr($val['nip'],15,3);
                
                echo $frmt1." ".$frmt2." ".$frmt3." ".$frmt4;
                ?>
            </td>
			<td align='center'>
                <?php
                $hari_back = $val['hari_back'];
                $cb_back   = $val['cb_back'];
                
                echo (12-$cb_back)-$hari_back;
                ?>
            </td>
			<td align='center'>
                <?php
                $hari_now = $val['hari_now'];
                $cb_now   = $val['cb_now'];
                
                echo (12-$cb_now)-$hari_now;
                ?>
            </td>
			<td align='center'>
                <?php
                $hari_back = $val['hari_back'];
                $cb_back   = $val['cb_back'];
                
                $sum_back = (12-$cb_back)-$hari_back;
                
                $hari_now = $val['hari_now'];
                $cb_now   = $val['cb_now'];
                
                $sum_now = (12-$cb_now)-$hari_now;
                
                echo $sum_back+$sum_now;
                ?>
            </td>
		</tr>
		<?php 
        
        }
         ?>
		</thead>
	</table>
</div>