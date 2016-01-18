<script type="text/javascript">
    $(document).ready(function(){
       $("button,submit,reset").jqxInput({ theme: 'fresh', height: '28px' }); 
       
       $('#propinsi').change(function(){
			$.get("<?php echo base_url()?>index.php/admin_user/select_kota/"+ $(this).val(), function(response) {
				var data = eval(response);

				$("#kota").html(data.kota);
				$('#kota').change();

			}, "json");

		});

		$('#kota').change(function(){
			$.get("<?php echo base_url()?>index.php/admin_user/select_kecamatan/"+ $(this).val(), function(response) {
				var data = eval(response);

				$("#kecamatan").html(data.kecamatan);
				$("#kecamatan").change();

			}, "json");

		});

		$('#kecamatan').change(function(){
			$.get("<?php echo base_url()?>index.php/admin_user/select_desa/"+ $(this).val(), function(response) {
				var data = eval(response);

				$("#desa").html(data.desa);

			}, "json");

		});
        
       <?php
       if($action=="add"){
         ?>
         $("#birthdate").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme });
         $("#badan_tinggi").jqxNumberInput({ width: '50px', height: '20px', min: 100, theme: 'fresh', spinButtons: true, digits: 3, decimalDigits: 0 });
         $("#badan_berat").jqxNumberInput({ width: '50px', height: '20px', min: 30, theme: 'fresh', spinButtons: true, digits: 3, decimalDigits: 0 });
       
         <?php
       }else{
         ?>
         $("#birthdate").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme, value: '{birthdate}'});
         $("#badan_tinggi").jqxNumberInput({ width: '50px', height: '20px', min: 100, theme: 'fresh', spinButtons: true, digits: 3, decimalDigits: 0, value: '{badan_tinggi}' });
         $("#badan_berat").jqxNumberInput({ width: '50px', height: '20px', min: 30, theme: 'fresh', spinButtons: true, digits: 3, decimalDigits: 0, value: '{badan_berat}' });
         
         <?php
       }
       ?>
       
       <?php if($action=="edit"){ ?>
			$.get("<?php echo base_url()?>index.php/admin_user/select_kota/{propinsi}/{kota}", function(response) {
				var data = eval(response);

				$("#kota").html(data.kota);

			}, "json");

			$.get("<?php echo base_url()?>index.php/admin_user/select_kecamatan/{kota}/{kecamatan}", function(response) {
				var data = eval(response);

				$("#kecamatan").html(data.kecamatan);

			}, "json");

			$.get("<?php echo base_url()?>index.php/admin_user/select_desa/{kecamatan}/{desa}", function(response) {
				var data = eval(response);

				$("#desa").html(data.desa);

			}, "json");
		<?php } ?>
       $("input[name='nip']").jqxMaskedInput({ theme: theme, height: '24px', mask: '######## ###### # ###' });
    });
</script>
<div style="padding:5px;text-align:center">
<form method="POST" id="frmData">
	<button type="button" onClick="save_{action}_dialog($('#frmData').serialize());">Simpan</button>
	<button type="reset">Ulang</button>
	<button type="button" onClick="close_dialog();">Batal</button>
	<br />
	<br />
	<table border="0" cellpadding="0" cellspacing="8" class="panel" align="center">
		<tr>
			<td>
                <table border="0" cellpadding="3" cellspacing="2">
					<?php
                    if($action=="add"){
                    ?>
                    <tr>
                        <td>Username</td>
                        <td>:</td>
                        <td>
                            <input class=input type="text" size="25" name="username" value=""/>
                        </td>
                    </tr>
                    <tr>
                        <td>Level</td>
                        <td>:</td>
                        <td>
                            <select size="1" class="input" name="level" style="width: 120px;">
                                <?php
                                $level = $this->admin_users_model->get_user_level();
                                foreach($level as $row_level){
                                ?>
                                    <option value="<?php echo $row_level->level; ?>"><?php echo $row_level->level; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td>:</td>
                        <td>
                            <input type="password" size="20" class="input" name="password"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Confirm Password</td>
                        <td>:</td>
                        <td>
                            <input type="password" size="20" class="input" name="password2"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Active</td>
                        <td>:</td>
                        <td>
                            <input type="checkbox" value="1" name="status_active" class="input"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <?php
                    }
                    ?>
                    <tr>
						<td>ID</td>
						<td>:</td>
						<td><?php if($action=="add"){ ?>
								{auto-number}
							<?php }else{?>
								<input class=input type="text" size="10" name="id" readonly value="<?php 
								if(set_value('id')=="" && isset($id)){
								 	echo $id;
								}else{
									echo  set_value('id');
								}
								?>"/>
							<?php }?>
						</td>
					</tr>
                    <tr>
                        <td>NIP</td>
                        <td>:</td>
                        <td>
                            <input class=input type="text" size="21" name="nip" value="<?php 
								if(set_value('nip')=="" && isset($nip)){
								 	echo $nip;
								}else{
									echo  set_value('nip');
								}
								 ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Gelar</td>
                        <td>:</td>
                        <td>
                            <input class=input type="text" size="15" name="gelar" value="<?php 
								if(set_value('gelar')=="" && isset($gelar)){
								 	echo $gelar;
								}else{
									echo  set_value('gelar');
								}
								 ?>"/>
                        </td>
                    </tr>
					<tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>
                            <input class=input type="text" size="30" name="nama" value="<?php 
								if(set_value('nama')=="" && isset($nama)){
								 	echo $nama;
								}else{
									echo  set_value('nama');
								}
								 ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>ID/KTP/SIM</td>
                        <td>:</td>
                        <td>
                            <input class=input type="text" size="20" name="id_number" value="<?php 
								if(set_value('id_number')=="" && isset($id_number)){
								 	echo $id_number;
								}else{
									echo  set_value('id_number');
								}
								 ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>:</td>
                        <td>
                            <div id='birthdate'></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Tempat Lahir</td>
                        <td>:</td>
                        <td>
                            <input class=input type="text" size="30" maxlength="50" name="birthplace" value="<?php 
								if(set_value('birthplace')=="" && isset($birthplace)){
								 	echo $birthplace;
								}else{
									echo  set_value('birthplace');
								}
								 ?>"/>
                        </td>
                    </tr>
                    <tr>
						<td>Jenis Kelamin</td>
						<td>:</td>
						<td>  
                            <select size="1" class="input" name="gendre" style="width: 100px;">
                                <?php
                                if(set_value('gendre')=="" && isset($gendre)){
                                    ?>
                                    <option value="L" <?php if($gendre=="L") echo "Selected"; ?>>Male</option>
                                    <option value="P" <?php if($gendre=="P") echo "Selected"; ?>>Female</option>
                                    <?php
                                }else{
                                    ?>
                                    <option value="L">Male</option>
                                    <option value="P">Female</option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
					</tr>
                    <tr>
                        <td>Agama</td>
                        <td>:</td>
                        <td>
                            <select size="1" class="input" name="agama" style="width: 100px;">
                            <?php
                            $data_agama = $this->admin_users_model->get_all_agama();
                               if(set_value('agama')=="" && isset($agama)){
                                    foreach($data_agama as $row_agama){
                                    ?>
                                        <option value="<?php echo $row_agama->id_agama; ?>" <?php if($row_agama->id_agama==$agama) echo "Selected"; ?>><?php echo $row_agama->nama; ?></option>
                                    <?php
                                    }
                                }else{
                                    foreach($data_agama as $row_agama){
                                    ?>
                                        <option value="<?php echo $row_agama->id_agama; ?>"><?php echo $row_agama->nama; ?></option>
                                    <?php
                                    }
                                }
                            ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Kepercayaan</td>
                        <td>:</td>
                        <td>
                            <input class=input type="text" size="40" maxlength="40" name="kepercayaan" value="<?php 
								if(set_value('kepercayaan')=="" && isset($kepercayaan)){
								 	echo $kepercayaan;
								}else{
									echo  set_value('kepercayaan');
								}
								 ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Status Perkawinan</td>
                        <td>:</td>
                        <td>
                            <select size="1" class="input" name="kawin" style="width: 110px;">
                            <?php
                            $data_kawin = $this->admin_users_model->get_all_status();
                            foreach($data_kawin as $row_kawin){
                                if(set_value('kawin')=="" && isset($kawin)){
                                    ?>
                                        <option value="<?php echo $row_kawin->id_status; ?>" <?php if($row_kawin->id_status==$kawin) echo "Selected"; ?>><?php echo $row_kawin->nama; ?></option>
                                    <?php
                                }else{
                                    ?>
                                        <option value="<?php echo $row_kawin->id_status; ?>"><?php echo $row_kawin->nama; ?></option>
                                    <?php
                                }
                            }
                            ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Phone Number</td>
                        <td>:</td>
                        <td>
                            <input class=input type="text" size="15" maxlength="20" name="phone_number" value="<?php 
								if(set_value('phone_number')=="" && isset($phone_number)){
								 	echo $phone_number;
								}else{
									echo  set_value('phone_number');
								}
								 ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Mobile</td>
                        <td>:</td>
                        <td>
                            <input class=input type="text" size="15" maxlength="20" name="mobile" value="<?php 
								if(set_value('mobile')=="" && isset($mobile)){
								 	echo $mobile;
								}else{
									echo  set_value('mobile');
								}
								 ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td>
                            <input class=input type="text" size="30" maxlength="200" name="email" value="<?php 
								if(set_value('email')=="" && isset($email)){
								 	echo $email;
								}else{
									echo  set_value('email');
								}
								 ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td valign='top'>Alamat</td>
                        <td valign='top'>:</td>
                        <td>
                            <?php
                            if(set_value('address')=="" && isset($address)){
							 	$val = $address;
							}else{
								$val = set_value('address');
							}
                            ?>
                            <textarea cols="45" rows="3" wrap="virtual" maxlength="100" class="input" name="address"><?php echo $val; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Propinsi</td>
                        <td>:</td>
                        <td>
                            <select size="1" class="input" name="propinsi" id="propinsi" style="width: 220px;">
                            <?php
                             $data_propinsi = $this->admin_users_model->get_all_propinsi();  
                                if(set_value('propinsi')=="" && isset($propinsi)){
                                   foreach($data_propinsi as $row_propinsi){
                                    ?>
                                        <option value="<?php echo $row_propinsi->id_propinsi; ?>" <?php if($row_propinsi->id_propinsi==$propinsi) echo "Selected"; ?>><?php echo $row_propinsi->id_propinsi." - ".$row_propinsi->nama_propinsi; ?></option>
                                    <?php
                                    }
                                }else{
                                    foreach($data_propinsi as $row_propinsi){
                                    ?>
                                        <option value="<?php echo $row_propinsi->id_propinsi; ?>"><?php echo $row_propinsi->id_propinsi." - ".$row_propinsi->nama_propinsi; ?></option>
                                    <?php
                                    }
                                }
                            ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Kota</td>
                        <td>:</td>
                        <td>
                            <select class='input' id='kota' name='kota' style="width: 220px;"><option>-</option></select>
                        </td>
                    </tr>
                    <tr>
                        <td>Kecamatan</td>
                        <td>:</td>
                        <td>
                            <select class='input' id='kecamatan' name='kecamatan' style="width: 220px;"><option>-</option></select>
                        </td>
                    </tr>
                    <tr>
                        <td>Desa</td>
                        <td>:</td>
                        <td>
                            <select class='input' id='desa' name='desa' style="width: 220px;"><option>-</option></select>
                        </td>
                    </tr>
                    <tr>
						<td colspan="3" height="30">&nbsp;</td>
					</tr>
                    <tr>
                        <td>Tinggi Badan (cm)</td>
                        <td>:</td>
                        <td>
                            <div id='badan_tinggi'></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Berat badan (kg)</td>
                        <td>:</td>
                        <td>
                            <div id='badan_berat'></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Rambut</td>
                        <td>:</td>
                        <td>
                            <input class=input type="text" size="30" maxlength="50" name="badan_rambut" value="<?php 
								if(set_value('badan_rambut')=="" && isset($badan_rambut)){
								 	echo $badan_rambut;
								}else{
									echo  set_value('badan_rambut');
								}
								 ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Bentuk muka</td>
                        <td>:</td>
                        <td>
                            <input class=input type="text" size="30" maxlength="50" name="badan_muka" value="<?php 
								if(set_value('badan_muka')=="" && isset($badan_muka)){
								 	echo $badan_muka;
								}else{
									echo  set_value('badan_muka');
								}
								 ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Warna kulit</td>
                        <td>:</td>
                        <td>
                            <input class=input type="text" size="30" maxlength="50" name="badan_kulit" value="<?php 
								if(set_value('badan_kulit')=="" && isset($badan_kulit)){
								 	echo $badan_kulit;
								}else{
									echo  set_value('badan_kulit');
								}
								 ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Ciri-ciri khas</td>
                        <td>:</td>
                        <td>
                            <input class=input type="text" size="30" maxlength="50" name="badan_khas" value="<?php 
								if(set_value('badan_khas')=="" && isset($badan_khas)){
								 	echo $badan_khas;
								}else{
									echo  set_value('badan_khas');
								}
								 ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Cacat Tubuh</td>
                        <td>:</td>
                        <td>
                            <input class=input type="text" size="30" maxlength="50" name="badan_cacat" value="<?php 
								if(set_value('badan_cacat')=="" && isset($badan_cacat)){
								 	echo $badan_cacat;
								}else{
									echo  set_value('badan_cacat');
								}
								 ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Kegemaran (hobby)</td>
                        <td>:</td>
                        <td>
                            <input class=input type="text" size="30" maxlength="50" name="kegemaran" value="<?php 
								if(set_value('kegemaran')=="" && isset($kegemaran)){
								 	echo $kegemaran;
								}else{
									echo  set_value('kegemaran');
								}
								 ?>"/>
                        </td>
                    </tr>
                    <tr>
						<td colspan="3" height="30">&nbsp;</td>
					</tr>
				</table>
            </td>
		</tr>
	</table>
</form>
</div>