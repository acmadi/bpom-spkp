<script type="text/javascript">
    $(document).ready(function(){
        $("textarea").jqxInput({  height: '100px', width: '95%'});
    });
</script>
<br/><br/>
<div class="widget orange">
		<div class="widget-title">
			<h4><i class="icon-list-alt"></i> Detail Infromasi Kajian </h4>
		</div>
		<div class="widget-body">
			<table >
			<?php
		    $no=1;
			    if(isset($detail_upload)){
			        foreach($detail_upload as $row){
		     ?>
				<tr>
					<td>Judul</td>
					<td>:</td>
					<td><?php echo $row->judul; ?></td>
				</tr>
				<tr>
					<td>SubDit</td>
					<td>:</td>
					<td><?php echo $row->judul; ?></td>
				</tr>
				<tr>
					<td>Kategori</td>
					<td>:</td>
					<td><?php echo $row->kategori; ?></td>
				</tr>
				<tr>
					<td>Prioritas</td>
					<td>:</td>
					<td><?php echo $row->prioritas; ?></td>
				</tr>
				<tr>
					<td>Deskripsi</td>
					<td>:</td>
					<td><?php echo $row->deskripsi; ?></td>
				</tr>
				<?php
					} 
				}
				?>
			</table>
		</div>
	</div>

<div class="widget green">
		<div class="widget-title">
			<h4><i class="icon-upload"></i> File Informasi Kajian </h4>
		</div>
		<div class="widget-body">
			<table class="table table-hover">
				<tr>
					<th>Aksi</th>
					<th>Nomor</th>
					<th>Nama File</th>
					<th>Tanggal Upload</th>
				</tr>
				<?php
		    		$no=1;
			 	   if(isset($detail_upload)){
			        foreach($data_detailupload as $rows){
		     ?>
				<tr>
					<td><a class="btn btn-mini" href="#modalEditBarang<?php echo $rows->id_srikandi;?>" data-toggle="modal"><i class="icon-pencil"></i> Edit</a> | 
					<a class="btn btn-mini" href="#modalEditBarang<?php echo $rows->id_srikandi;?>" data-toggle="modal"><i class="icon-file"></i> Download</a></td>
					<td><?php echo $no++; ?></td>
					<td><?php echo $rows->filename; ?> </td>
					<td><?php echo date("d-m-Y",strtotime($rows->update)); ?></td>
				</tr>
				<?php
					} 
				}
				?>

			</table>
		</div>
	</div>
	<p align="right"><a href="#modalAddBarang<?php echo $id_srikandi;?>" data-toggle="modal"><button class="btn btn-success" type="button"><i class="icon-upload"></i>Upload</button></a></p>
	<table class="table">
	    <thead><tr><th>Komentar</th></tr></thead>
	    <tbody id="fillgrid">
	    
	    </tbody>
	    
	<tr>
		<td>
			<form class="form-inline" role="form" id="frmadd" action="<?php echo base_url() ?>srikandi/komentar" method="POST">
			<textarea name="komentar_detail" id="komentarid"></textarea>
			<input type="hidden" name="id_srikandi" value="<?php echo $id_srikandi; ?>">
			<input type="submit" class="btn btn-primary" value="Kirim">
			</form>
		</td>
	</tr>
	<tfoot></tfoot>
	</table>

<script>
$(document).ready(function (){
        //fillgrid();
        // add data
        $("#frmadd").submit(function (e){
            e.preventDefault();
            var url = $(this).attr('action');
            var data = $(this).serialize();
            $.ajax({
                url:url,
                type:'POST',
                data:data
            }).done(function (data){
                $("#response").html(data);
                 document.getElementById("komentarid").innerHTML= '';
                 //fillgrid();
            });
        });
    
    
    var idsrikandi  = <?php echo $id_srikandi; ?>;
    function fillgrid(){
        $.ajax({
            url:'<?php echo base_url() ?>srikandi//detail/idsrikandi',
            type:'GET'
        }).done(function (data){
            $("#fillgrid").html(data);
            
        });
    }
    
});
</script>