<script type="text/javascript">
    $(document).ready(function(){
		$("button,submit,reset").jqxInput({ theme: 'fresh', height: '28px', width: '100px' }); 
        
        if('{action}'=='add'){
            $("input[name='id']").jqxMaskedInput({ theme: theme, height: '24px', width: '75px', mask: '### ####' });
            $("input[name='id']").on('change', function(){
                var val = $(this).val();
                if(val=='___ ____'){
                    $("input[name='idb']").val("");
                }else{
                    var split = val.split(' ');
                    if(parseInt(split[0])>0 && parseInt(split[1])>0){
                        $("input[name='idb']").val(val);
                    }else{
                        $("input[name='idb']").val('');
                    }
                }
            });
            $("input[name='tipe']").jqxInput({ theme: 'fresh', height: '28px', width: '50px'}); 
            $("input[name='tipe']").on('close', function(){
                var str = $(this).val();
                $(this).val(str.toUpperCase());
            });
        }
		
        $("input[name='judul']").jqxInput({ theme: 'fresh', height: '28px', width: '450px' }); 
        $("input[name='pengarang']").jqxInput({ theme: 'fresh', height: '28px', width: '450px' }); 
        $("input[name='penerbit']").jqxInput({ theme: 'fresh', height: '28px', width: '450px' }); 
        $("input[name='tempat_simpan']").jqxInput({ theme: 'fresh', height: '28px', width: '350px' }); 
        $("input[name='lama']").jqxInput({ theme: 'fresh', height: '28px', width: '350px' }); 
        $("input[name='tentang']").jqxInput({ theme: 'fresh', height: '28px', width: '450px' }); 
        $("input[name='ket']").jqxInput({ theme: 'fresh', height: '28px', width: '20px' }); 
        $("input[name='tahun_terbit']").jqxInput({ theme: 'fresh', height: '28px', width: '45px' }); 
        $("input[name='tempat']").jqxInput({ theme: 'fresh', height: '28px', width: '200px' }); 
        
        $("[name='btn_simpan']").click(function(){
			$("#uploaddiv").hide();
			$.ajax({ 
				type: "POST",
				cache: false,
				url: "<?php echo base_url()?>spkp_manajemen_dokumen_eksternal/do{action}/{id}/{no}",
				data: $("#frmData").serialize(),
				success: function(response){
					 if(response=="1"){
						$.notific8('Notification', {
						  life: 5000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
                        $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
                        close_dialog();
					 }else if(response=='0'){
					   $("#uploadloader").show("fade");
						$.notific8('Notification', {
						  life: 5000,
						  message: 'Duplicate Column No',
						  heading: 'Saving data FAIL',
						  theme: 'red2'
						});
					 }else{
						$("#uploadloader").show("fade");
						$.notific8('Notification', {
						  life: 5000,
						  message: response,
						  heading: 'Saving data FAIL',
						  theme: 'red2'
						});
					 }
					$("#uploadloader").hide();
					$("#uploaddiv").show("fade");
				}
			 }); 		
		});

	});
</script>
<div id="uploadloader" style='display:none;text-align:center'><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>uploading<br><br><br><br></div>
<div id="uploaddiv" style="padding:5px;text-align:center">
<form method="POST" id="frmData">
	<button type="button" name="btn_simpan"> Simpan </button>
	<button type="reset"> Ulang </button>
	<button type="button" onCLick="close_dialog();"> Batal </button>
	<br />
	<br />
	<table width='100%' border="0" cellpadding="0" cellspacing="8" align="center">
		<tr>
			<td>
                <table width='100%' border="0" cellpadding="3" cellspacing="2" style="color: black;font-size: 12px;">
					<tr>
						<td width='18%'>No (*)</td>
						<td>:</td>
						<td>
                            <?php
                            if($action=='edit'){
                                echo $id." ".$no." ".$tipe;
                            }else{
                                ?>
                                <input type="text" size="8" name="id" style="padding: 2px;" value="<?php 
								if(set_value('id')=="" && isset($id)){
								 	echo $id;
								}else{
									echo  set_value('id');
								}
								 ?>"/>
                                 <input type="text" size="8" name="idb" style="display: none;"/>
                                 <input type="text" size="10" name="tipe" style="padding: 2px;" value="<?php 
								if(set_value('tipe')=="" && isset($tipe)){
								 	echo $tipe;
								}else{
									echo  set_value('tipe');
								}
								 ?>"/>
                                <?php
                            }
                            ?>
						</td>
					</tr>
					<tr>
						<td>Judul (*)</td>
						<td>:</td>
						<td><input type="text" size="400" name="judul" style="padding: 2px;" value="<?php 
								if(set_value('judul')=="" && isset($judul)){
								 	echo $judul;
								}else{
									echo  set_value('judul');
								}
								 ?>"/>
						</td>
					</tr>
                    <tr>
						<td>Pengarang (*)</td>
						<td>:</td>
						<td><input type="text" size="250" name="pengarang" style="padding: 2px;" value="<?php 
								if(set_value('pengarang')=="" && isset($pengarang)){
								 	echo $pengarang;
								}else{
									echo  set_value('pengarang');
								}
								 ?>"/>
						</td>
					</tr>
                    <tr>
						<td>Penerbit (*)</td>
						<td>:</td>
						<td><input type="text" size="250" name="penerbit" style="padding: 2px;" value="<?php 
								if(set_value('penerbit')=="" && isset($penerbit)){
								 	echo $penerbit;
								}else{
									echo  set_value('penerbit');
								}
								 ?>"/>
						</td>
					</tr>
                    <tr>
						<td>Tentang</td>
						<td>:</td>
						<td><input type="text" size="250" name="tentang" style="padding: 2px;" value="<?php 
								if(set_value('tentang')=="" && isset($tentang)){
								 	echo $tentang;
								}else{
									echo  set_value('tentang');
								}
								 ?>"/>
						</td>
					</tr>
                    <tr>
						<td>Keterangan</td>
						<td>:</td>
						<td><input type="text" size="5" name="ket" style="padding: 2px;" value="<?php 
								if(set_value('ket')=="" && isset($ket)){
								 	echo $ket;
								}else{
									echo  set_value('ket');
								}
								 ?>"/>
						</td>
					</tr>
                    <tr>
						<td>Tahun Terbit</td>
						<td>:</td>
						<td><input type="text" size="4" name="tahun_terbit" style="padding: 2px;" value="<?php 
								if(set_value('tahun_terbit')=="" && isset($tahun_terbit)){
								 	echo $tahun_terbit;
								}else{
									echo  set_value('tahun_terbit');
								}
								 ?>"/>
						</td>
					</tr>
                    <tr>
						<td>Tempat Terbit</td>
						<td>:</td>
						<td><input type="text" size="50" name="tempat" style="padding: 2px;" value="<?php 
								if(set_value('tempat')=="" && isset($tempat)){
								 	echo $tempat;
								}else{
									echo  set_value('tempat');
								}
								 ?>"/>
						</td>
					</tr>
                    <tr>
						<td>Tempat Penyimpanan</td>
						<td>:</td>
						<td><input type="text" size="100" name="tempat_simpan" style="padding: 2px;" value="<?php 
								if(set_value('tempat_simpan')=="" && isset($tempat_simpan)){
								 	echo $tempat_simpan;
								}else{
									echo  set_value('tempat_simpan');
								}
								 ?>"/>
						</td>
					</tr>
                    <tr>
						<td>Lama</td>
						<td>:</td>
						<td><input type="text" size="50" name="lama" style="padding: 2px;" value="<?php 
								if(set_value('lama')=="" && isset($lama)){
								 	echo $lama;
								}else{
									echo  set_value('lama');
								}
								 ?>"/>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
</div>