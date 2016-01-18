<div style="padding:10px">
<div class="title">Group Roles</div>
<div class="clear">&nbsp;</div>
<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert" id="alert">
<div align=right onClick="$('#alert').hide('fold',1000);" style="color:red;font-weight:bold">X</div>
<?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>

<?php echo $this->session->flashdata('notification')?><br />
	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="tbl">
		<thead>
			<tr>
				<th class=tbl_head width=5% align=center style="font-size:11px" rowspan=2>No</font></th>
				<th class=tbl_head width=40% style="font-size:11px" rowspan=2>Level</th>
				<th class=tbl_head width=25% style="font-size:11px" colspan=5>Total Privilege</th>
				<th class=tbl_head width=5% align=center style="font-size:11px" rowspan=2>Detail</th>
			</tr>
			<tr>
				<th class=tbl_head width=5% style="font-size:11px">Modules</th>
				<th class=tbl_head width=5% style="font-size:11px">Show</th>
				<th class=tbl_head width=5% style="font-size:11px">Add</th>
				<th class=tbl_head width=5% style="font-size:11px">Edit</th>
				<th class=tbl_head width=5% style="font-size:11px">Delete</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($query as $row):?>
			<tr onMouseOver="bgColor='#EEEEEE'" onmouseout="bgColor='#FFFFFF'" bgcolor="#FFFFFF">
				<td class=tbl_list align=center><?php echo $start++?>&nbsp;</td>
				<td class=tbl_list><?php echo ucfirst($row->level) ?>&nbsp;</td>
				<td class=tbl_list align="right"><?php echo ucfirst($row->total) ?></td>
				<td class=tbl_list align="right"><?php echo ucfirst($row->total_show) ?></td>
				<td class=tbl_list align="right"><?php echo ucfirst($row->total_add) ?></td>
				<td class=tbl_list align="right"><?php echo ucfirst($row->total_edit) ?></td>
				<td class=tbl_list align="right"><?php echo ucfirst($row->total_del) ?></td>
				<td class=tbl_list align=center><a href="<?php echo base_url()?>index.php/admin_role/detail/<?php echo $row->level?>" title="Ubah"><img src="<?php echo base_url()?>media/images/16_edit.gif" /></a></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>