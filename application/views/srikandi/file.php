
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
		<td><button  class="btn btn-mini btn-primary" onclick="edit_upload(<?php echo $rows->id_srikandi;?>)"><i class="icon-pencil"></i>  Edit</button> 
		<a  href="#modalDownloadFile<?php echo $rows->id_srikandi;?>" data-toggle="modal"><button  class="btn btn-mini btn-primary"><i class="icon-file"></i>  Download</button></td>
		<td><?php echo $no++; ?></td>
		<td><?php echo $rows->filename; ?> </td>
		<td><?php echo date("d-m-Y H:i:s",$rows->update); ?></td>
	</tr>
	<?php
		} 
	}
	?>
</table>
<?php
if (isset($data_file)){
    foreach($data_file as $rowss){
        ?>
        <div id="modalDownloadFile<?php echo $id=$rowss->id_srikandi?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Download File</h3>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo site_url('master/edit_barang')?>">
                <div class="modal-body">
                	<?php
                		echo "<b>Judul : ".$rowss->judul."<br/>Deskripsi : ".$rowss->deskripsi."<br/> Nama File :".$rowss->filename."</b><br/>";
                	?>
                    <p align="center"><a href="<?php echo base_url()?>srikandi/dodownload/<?php echo $rowss->id_srikandi; ?>" target="_blank"><button class="btn btn-large btn-danger" type="button" name="btn_download"> Download </button></a></p>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                </div>
            </form>
        </div>
    <?php }
}
?>
<script type="text/javascript">
	function edit_upload(id){
		$("#popup_content_upload").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		var offset = $("#jqxgrid_upload").offset();
		$("#popup_upload").jqxWindow({
			width: 700,
			height: 440,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup_upload").jqxWindow('open');
		$.get("<?php echo base_url();?>srikandi/edit_upload/"+id , function(response) {
			$("#popup_content_upload").html("<div>"+response+"</div>");
		});
	}
</script>
