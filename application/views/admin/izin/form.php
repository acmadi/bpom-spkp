<div style="padding:5px;text-align:center">
<form method="POST" id="frmData">
	<button type="button" class=btn onClick="save_{action}_dialog($('#frmData').serialize());">Simpan</button>
	<button type="reset"  class=btn>Ulang</button>
	<button type="button" class=btn onClick="close_dialog();">Batal</button>
	<br />
	<br />
	<table border="0" cellpadding="0" cellspacing="8" class="panel" align="center">
		<tr>
			<td>

				<table border="0" cellpadding="3" cellspacing="2">
					<tr>
						<td>ID Izin</td>
						<td>:</td>
						<td><?php if($action=="add"){ ?>
								{auto-number}
							<?php }else{?>
								<input class=input type="text" size="5" name="id_izin" readonly value="<?php 
								if(set_value('id_izin')=="" && isset($id_izin)){
								 	echo $id_izin;
								}else{
									echo  set_value('id_izin');
								}
								?>"/>
							<?php }?>
						</td>
					</tr>
					<tr>
						<td>Nama</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="nama" value="<?php 
								if(set_value('nama')=="" && isset($nama)){
								 	echo $nama;
								}else{
									echo  set_value('nama');
								}
								 ?>"/>
						</td>
					</tr>
                    <tr>
						<td>Jenis</td>
						<td>:</td>
						<td>
                            <?php
                                $c1="";
                                $c2="";
                                if(isset($jenis)){
                                    if($jenis=="DAERAH"){
                                        $c1 = "checked";
                                        $c2="";
                                    }elseif($jenis=="PUSAT"){
                                        $c2 = "checked";
                                        $c1="";
                                    }
                                }
                                
                            ?>
                            <input name="jenis" type="radio" value="DAERAH" <?php echo $c1; ?>/>DAERAH
                            <input name="jenis" type="radio" value="PUSAT" <?php echo $c2; ?>/>PUSAT
						</td>
					</tr>
					<tr>
						<td colspan="3" height="30"></td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
</form>
</div>