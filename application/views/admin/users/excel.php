<table cellpadding="0" cellspacing="0" border="0" style="border:1px solid #AAAAAA">
	<tdead>
		<tr style="font-weight:bold;background:#DDDDDD">
			<td align=center>NO</font></td>
			<td align=center>UID</font></td>
			<td align=center>Username</font></td>
			<td>Level</td>
			<td>Last Login | Las Activity</td>
			<td>Active | Online</td>
			<td>Full Name</td>
			<td>Display Name</td>
			<td>NIP</td>
			<td>Position</td>
            <td>Grade</td>
			<td>Gendre</td>
			<td>BirthDay</td>
			<td>Place Of Birth</td>
            <td>ID/KTP/SIM</td>
			<td>Address</td>
            <td>Phone Number</td>
			<td>Mobile</td>
			<td>Email</td>
		</tr>
	</tdead>
	<tbody>
	<?php 
	$start=1;
	foreach($query as $row):?>
		<tr style="background:#<?php if($start%2==0) echo "EEEEEE"; else echo "FFFFFF"?>">
			<td align=center><?php  echo $start++?>&nbsp;</td>
			<td align=center><?php  echo $row->id?>&nbsp;</td>
			<td><?php echo $row->username?>&nbsp;</td>
			<td><?php echo ucwords($row->level)?></td>
			<td align=center><?php  echo date("d-m-Y h:i:s",$row->last_login)?> | <?php  echo date("d-m-Y h:i:s",$row->last_active)?></td>
			<td align=center><?php  echo $row->status_active?> | <?php  echo $row->online?>&nbsp;</td>
			<td><?php  echo $row->name?>&nbsp;</td>
			<td><?php  echo $row->name_display?>&nbsp;</td>
			<td><?php  echo $row->nip?>&nbsp;</td>
			<td><?php  echo $row->position?>&nbsp;</td>
			<td><?php  echo $row->grade?>&nbsp;</td>
			<td><?php  echo $row->gendre?>&nbsp;</td>
			<td><?php  echo $row->birthdate?>&nbsp;</td>
			<td><?php  echo $row->birthplace?>&nbsp;</td>
			<td><?php  echo $row->id_number?>&nbsp;</td>
			<td><?php  echo $row->address?>&nbsp;</td>
			<td><?php  echo $row->phone_number?>&nbsp;</td>
			<td><?php  echo $row->mobile?>&nbsp;</td>
			<td><?php  echo $row->email?>&nbsp;</td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
