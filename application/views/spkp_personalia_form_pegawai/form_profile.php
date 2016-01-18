        <table width="100%" cellpadding="5" cellspacing="0" style="color: black;font-size: 12px;">
			<tr height="30" valign='top'>
				<td width="15%" rowspan="8" ><img src="<?php echo base_url()?>spkp/get_image_profile/{uid}" style="border:8px solid #EFEFEF"></td>
				<td width="15%">Nama</td>
				<td width="2%">:</td>
				<td>{nama}</td>
			</tr>
			<tr height="30">
				<td>NIP</td>
				<td>:</td>
				<td>{nip}</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
            <tr height="30">
				<td>Sisa Cuti <?php echo date('Y')-1; ?></td>
				<td align='center'>:</td>
				<td>{sisa_back}</td>
			</tr>
            <tr height="30">
				<td>Cuti yang diambil <?php echo date('Y')-1; ?></td>
				<td align='center'>:</td>
				<td>{taken_back}</td>
			</tr>
            <tr height="30">
				<td>Sisa Cuti <?php echo date('Y'); ?></td>
				<td align='center'>:</td>
				<td>{sisa_now}</td>
			</tr>
            <tr height="30">
				<td>Cuti yang diambil <?php echo date('Y'); ?></td>
				<td align='center'>:</td>
				<td>{taken_now}</td>
			</tr>
            <tr height="30">
				<td>Sisa Cuti Gabungan</td>
				<td align='center'>:</td>
				<td>{sisa_join}</td>
			</tr>
            <tr>
				<td colspan="3">&nbsp;</td>
			</tr>
		</table>