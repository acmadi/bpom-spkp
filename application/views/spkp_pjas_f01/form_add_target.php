<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54' }); 
		$("input[name='nama']").jqxInput({ theme: 'fresh', height: '22px', width: '250px' });
		$("input[name='target']").jqxInput({ theme: 'fresh', height: '22px', width: '200px' }); 
		$("input[name='produk']").jqxInput({ theme: 'fresh', height: '22px', width: '250px' }); 
		$("input[name='jumlah']").jqxInput({ theme: 'fresh', height: '22px', width: '50px' }); 
		
		$(document).ready(function() {
		$("#jumlah").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ( $.inArray(event.keyCode,[46,8,9,27,13,190]) !== -1 ||
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
});

		$("[name='btn_simpan']").click(function(){
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url()?>spkp_pjas_f01/do{action}_target/{id}/<?php if($action=='edit'){echo $id_target;} ?>",
				data: $('#frmData').serialize(),
				success: function(response){
					 if(response=="1"){
						 $.notific8('Notification', {
						  life: 5000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
							close_dialog_target(1);
						}else{
						 $.notific8('Notification', {
						  life: 5000,
						  message: response,
						  heading: 'Saving data FAIL',
						  theme: 'red2'
						});
					}
				}
			 }); 		
		});
	});
</script>
<div style="display: none;" id="divLoad"></div>
<div id="divForm" style="padding:8px">
<form method="POST" id="frmData">
<div style="padding: 5px;text-align: center;">
	<button type="button" name="btn_simpan"> Simpan </button>
	<button type="reset"> Ulang </button>
	<button type="button" onCLick="close_dialog_target();"> Batal </button>
	</div>
                <table border="0" cellpadding="3" cellspacing="2" style="font-size: 12px;color: black;position:relative;float:left">
					<tr style="display: none;">
						<td width='10%'>ID</td>
						<td width='3%' align='middle'>:</td>
						<td>
							<input type="text" size="10" maxlength="15" name="id" value="<?php if(set_value('id')=="" && isset($id)){
										echo $id;
									}else{
										echo  set_value('id');
									}?>" readonly=""/>
						</td>
					</tr>
					<tr style="display: none;">
						<td width='10%'>ID Target</td>
						<td width='3%' align='middle'>:</td>
						<td>
						   <?php
						   if($action=="edit"){
							?>
							<input type="text" size="10" maxlength="15" name="id_target" value="<?php if(set_value('id_target')=="" && isset($id_target)){
										echo $id_target;
									}else{
										echo  set_value('id_target');
									}?>" readonly=""/>
							<?php
						   }
						   ?>
						</td>
					</tr>
                    <tr>
						<td>Nama</td>
						<td>:</td>
						<td><input type="text" size="50" name="nama" value="<?php 
								if(set_value('nama')=="" && isset($nama)){
								 	echo $nama;
								}else{
									echo  set_value('nama');
								}
								 ?>"/> *
						</td>
					</tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>
                            <textarea name="alamat" style="width: 250px; height= 200px;"><?php 
								if(set_value('alamat')=="" && isset($alamat)){
								 	echo $alamat;
								}else{
									echo  set_value('alamat');
								}
								 ?></textarea> *
                        </td>
                    </tr>
					<tr>
                        <td>Target</td>
                        <td>:</td>
                        <td>
                            <input type="text" size="80" maxlength="200" name="target" style="margin: 0;" value="<?php 
								if(set_value('target')=="" && isset($target)){
								 	echo $target;
								}else{
									echo  set_value('target');
								}
								 ?>"/>
                        </td>
                    </tr>
					<tr>
                        <td>Produk</td>
                        <td>:</td>
                        <td>
                            <input type="text" size="80" maxlength="200" name="produk" style="margin: 0;" value="<?php 
								if(set_value('produk')=="" && isset($produk)){
								 	echo $produk;
								}else{
									echo  set_value('produk');
								}
								 ?>"/>
                        </td>
                    </tr>
					<tr>
                        <td>Jumlah</td>
                        <td>:</td>
                        <td>
                            <input type="text" size="80" maxlength="200" id="jumlah" name="jumlah" style="margin: 0;" value="<?php 
								if(set_value('jumlah')=="" && isset($jumlah)){
								 	echo $jumlah;
								}else{
									echo  set_value('jumlah');
								}
								 ?>"/>
                        </td>
                    </tr>
				</table>
</form>
</div>