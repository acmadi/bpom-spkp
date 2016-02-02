<script type="text/javascript">
    $(document).ready(function(){
	   $("#bar_informasidankajian").click();

       $("textarea").jqxInput({  height: '100px', width: '95%'});

	   $('#btn_tambah_upload').click(function(){
			$("#popup_content_upload").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			var offset = $(this).offset();
			$("#popup_upload").jqxWindow({
				theme: theme, resizable: true, 
                width: 700,
                height: 300,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup_upload").jqxWindow('open');
			$.get("<?php echo base_url();?>srikandi/add_upload_rev/{id_srikandi}" , function(response) {
				$("#popup_content_upload").html("<div>"+response+"</div>");
			});
		});

	    $('#btn_hapus').click(function(){
			var values = new Array();	
			var	data = "";
			$.each($("input[name='kajian[]']:checked"), function() {
			  values.push($(this).val());		
			});
			
			if(values.length > 0){
				if(confirm('Hapus '+ values.length +' data kajian?')){
					$.post("<?php echo base_url().'srikandi/dodel_rev'; ?>", {data: values} ,  function(res) {
						alert(res);
	   					timeline_file();
					});
				}
			}else{
				alert('Silahkan Pilih Kajian Terlebih Dahulu');
			}
		});

	   timeline_comment();
	   timeline_file();
    });

	function close_dialog_upload(s){
		$("#popup_upload").jqxWindow('close');
		timeline_file();
	}

	function timeline_file(){
		$.get("<?php echo base_url();?>srikandi/timeline_file/{id_srikandi}" , function(response) {
			$("#timeline-file").html(response);
		});
	}

	function timeline_comment(){
		$.get("<?php echo base_url();?>srikandi/timeline_comment/{id_srikandi}" , function(response) {
			$("#timeline-comment").html(response);
		});
	}
</script>

<div id="popup_upload" style="display:none"><div id="popup_title_upload">Upload Data Revisi</div><div id="popup_content_upload">{popup}</div></div>

<div class="row-fluid">
   <div class="span12">
	   <h3 class="page-title">
		 {title}
	   </h3>
   </div>
</div>
<?php
if(isset($detail_upload)){
?>
	<div class="widget orange">
		<div class="widget-title">
			<h4><i class="icon-list-alt"></i> Detail Infromasi Kajian </h4>
		</div>
		<div class="widget-body">
			<table >
			
				<tr>
					<td width="32%">Judul</td>
					<td width="3%">:</td>
					<td width="65%" style="font-weight:bold"><?php echo $detail_upload['judul']; ?></td>
				</tr>
				<tr>
					<td>SubDit</td>
					<td>:</td>
					<td><?php echo $detail_upload['nama_subdit']; ?></td>
				</tr>
				<tr>
					<td>Kategori</td>
					<td>:</td>
					<td><?php echo $detail_upload['kategori']; ?></td>
				</tr>
				<tr>
					<td>Prioritas</td>
					<td>:</td>
					<td><?php echo $detail_upload['prioritas']; ?></td>
				</tr>
				<tr>
					<td>Deskripsi</td>
					<td>:</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3"><?php echo $detail_upload['deskripsi']; ?></td>
				</tr>
			</table>
		</div>
	</div>
<div style="position:relative;float:left;width:50%">
Upload oleh : <?php echo $detail_upload['username']?>, <?php echo date("d-m-Y H:i:s",$detail_upload['update']) ?>
</div>
<?php
}
?>
<p align="right">
	<a href="#" id="btn_tambah_upload" data-toggle="modal"><button class="btn btn-success" type="button"><i class="icon-upload"></i> Upload File Revisi </button></a>
	<button class="btn btn-danger" type="button" id="btn_hapus"><i class="icon-trash"></i> Hapus  </button>
	<a href="<?php echo base_url();?>srikandi"><button class="btn btn-warning" type="button"><i class="icon-circle-arrow-left"></i> Kembali  </button></a>
</p>

<div class="widget green">
		<div class="widget-title">
			<h4><i class="icon-file"></i> File Informasi Kajian </h4>
		</div>
		<div class="widget-body" id="timeline-file"></div>
	</div>
	<div class="widget purple">
		<div class="widget-title">
			<h4><i class="icon-comment"></i> Komentar </h4>
		</div>

		<div class="widget-body">


			 <div class="timeline-messages" id="timeline-comment"></div>


			<form class="form-inline" role="form" id="frmadd" action="<?php echo base_url() ?>srikandi/komentar" method="POST">
			<table class="table">
			<tr>
				<td>
					<textarea name="komentar_detail" id="komentarid"></textarea>
					<input type="hidden" name="id_srikandi" value="<?php echo $id_srikandi; ?>">
					<div style="padding-top:5px">
						<input type="submit" class="btn btn-danger" value="Kirim">
					</div>
				</td>
			</tr>
			<tfoot></tfoot>
			</table>
			</form>
		</div>
	</div>
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
                //$("#response").html(data);
                //document.getElementById("komentarid").innerHTML= '';
				timeline_comment();
				document.getElementById('komentarid').value = "";
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