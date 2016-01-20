<table class="table table-hover">
	<tr>
		<th>&nbsp;</th>
		<th>No</th>
		<th>Nama File</th>
		<th>Waktu Upload</th>
	</tr>
	<?php
	$no=1;
 	if(isset($data_file)){
        foreach($data_file as $rows){
 	?>
	<tr>
		<td><a class="btn btn-mini" href="#modalEditBarang<?php echo $rows->id_srikandi;?>" data-toggle="modal"><i class="icon-pencil"></i> Edit</a> | 
		<a class="btn btn-mini" href="#modalEditBarang<?php echo $rows->id_srikandi;?>" data-toggle="modal"><i class="icon-file"></i> Download</a></td>
		<td><?php echo $no++; ?></td>
		<td><?php echo $rows->filename; ?> </td>
		<td><?php echo date("d-m-Y H:i:s",$rows->update); ?></td>
	</tr>
	<?php
		} 
	}
	?>
</table>