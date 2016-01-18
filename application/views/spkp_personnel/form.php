<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("#birthdate").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme, value: '{birthdate}'});
        $("#badan_tinggi").jqxNumberInput({ width: '50px', height: '20px', min: 100, theme: 'fresh', spinButtons: true, digits: 3, decimalDigits: 0, value: '{badan_tinggi}' });
        $("#badan_berat").jqxNumberInput({ width: '50px', height: '20px', min: 30, theme: 'fresh', spinButtons: true, digits: 3, decimalDigits: 0, value: '{badan_berat}' });
        $("input[name='nip']").jqxMaskedInput({ theme: theme, height: '24px', mask: '######## ###### # ###' });
        
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
    });
    
    function save_profile(){
        var data = new FormData();
		jQuery.each($('#filename')[0].files, function(i, file) {
			data.append('filename', file);
		});			
		data.append('nip', $('#nip').val());
        data.append('gelar', $('#gelar').val());
        data.append('nama', $('#nama').val());
        data.append('id_number', $('#id_number').val());
        data.append('birthdate', $('#birthdate').val());
        data.append('birthplace', $('#birthplace').val());
        data.append('gendre', $('#gendre').val());
        data.append('agama', $('#agama').val());
        data.append('kepercayaan', $('#kepercayaan').val());
        data.append('kawin', $('#kawin').val());
        data.append('phone_number', $('#phone_number').val());
        data.append('mobile', $('#mobile').val());
        data.append('email', $('#email').val());
        data.append('address', $('#address').val());
        data.append('propinsi', $('#propinsi').val());
        data.append('kota', $('#kota').val());
        data.append('kecamatan', $('#kecamatan').val());
        data.append('desa', $('#desa').val());
        data.append('badan_tinggi', $('#badan_tinggi').val());
        data.append('badan_berat', $('#badan_berat').val());
        data.append('badan_rambut', $('#badan_rambut').val());
        data.append('badan_muka', $('#badan_muka').val());
        data.append('badan_kulit', $('#badan_kulit').val());
        data.append('badan_khas', $('#badan_khas').val());
        data.append('badan_cacat', $('#badan_cacat').val());
        data.append('kegemaran', $('#kegemaran').val());
        
        $("#divFormProfile").hide();
        $("#divLoadProfile").css("display","block");
        $("#divLoadProfile").html("<div style='text-align:center;margin-top: 70px'><br><br><br><br><img src='<?php echo base_url();?>media/images/loaderB64.gif' alt='loading content.. '><br>loading</div>");
             
        $.ajax({
           type: "POST",
           cache: false,
		   contentType: false,
		   processData: false,
           url: "<?php echo base_url(); ?>spkp_personnel/doedit_profile/{id}",
           data: data,
           success: function(response){
                if(response=="1"){
                   $('#filename').val("");
                   $.notific8('Notification', {
    				   life: 5000,
    				   message: 'Save data succesfully.',
    				   heading: 'Saving data',
    				   theme: 'lime'
    			   });
                   
                   $("#divLoadProfile").css("display","none");
                   
                   $.ajax({
                     type: "POST",
                     url: "<?php echo base_url(); ?>spkp_personnel/load_form_profile/{id}",
                     success: function(response){
                        $("#divFormProfile").show();
                        $("#divFormProfile").html(response);
                     }
                   });
                }else{
                    $.notific8('Notification', {
					  life: 5000,
					  message: response,
                      heading: 'Saving data FAIL',
					  theme: 'red'
					});
                    
                    $("#divLoadProfile").css("display","none");
                    
                    $.ajax({
                     type: "POST",
                     url: "<?php echo base_url(); ?>spkp_personnel/load_form_profile/{id}",
                     success: function(response){
                        $("#divFormProfile").show();
                        $("#divFormProfile").html(response);
                     }
                   });
                }
           } 
        });
    }
    
    function upload_image(){
        $("#filename").click();
    }
    
    function back(){
        window.location.href = "<?php echo base_url(); ?>spkp_personnel";
    }
</script>
<div style="display: none;" id="divLoadProfile"></div>
<div id="divFormProfile" style="padding:8px">
        <form method="post" id="frmDataProfile">
        <div style="background: #F4F4F4;padding: 5px;text-align: right;">
            <span id="show-time" style="display: none;"></span>
            <span style="float: left;padding: 5px;display: none;color: green;" id="msg"></span>
            <button type="button" onclick="save_profile();">Simpan</button>
        	<button type="reset">Ulang</button>
            <button type="button" onclick="back()">Batal</button>
        </div>
        </br>
        <div style="position:relative;float:right;right:200px;border:15px solid #EFEFEF;top:50px">
    		<?php
    		if($image==""){
    			?>
    			<img src="<?php echo base_url(); ?>media/images/smily-user-icon.jpg" width="200" height="200" style="border: 1px solid #404040;cursor: pointer;" onclick="upload_image()"/>
    			<?php
    		}else{
    			?>
    			<img src="<?php echo base_url(); ?>media/images/user/{image}" width="200" height="200" style="border: 1px solid #404040;cursor: pointer;" onclick="upload_image()"/>
    			<?php
    		}
    		?>
	    </div>
		<table border='0' width='60%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
        <tr>
            <td width='14%'>NIP</td>
            <td width='3%' align='middle'>:</td>
            <td width='50%'>
                <input type="text" size="15" maxlength="20" name="nip" id="nip" value="{nip}" style="margin: 0;height: 30px;"/>
            </td>
        </tr>
        <tr>
            <td width='14%'>Gelar</td>
            <td width='3%' align='middle'>:</td>
            <td>
                <input type="text" size="15" maxlength="15" name="gelar" id="gelar" value="{gelar}" style="margin: 0;height: 30px;"/>
            </td>
        </tr>
        <tr>
            <td width='14%'>Nama</td>
            <td width='3%' align='middle'>:</td>
            <td>
                <input type="text" size="25" maxlength="100" name="nama" id="nama" value="{nama}" style="margin: 0;height: 30px;"/>
            </td>
        </tr>
        <tr>
           <td>ID/KTP/SIM</td>
           <td align='middle'>:</td>
           <td>
             <input class=input type="text" size="20" name="id_number" id="id_number" value="{id_number}" style="margin: 0;height: 30px;"/>
           </td>
        </tr>
        <tr>
            <td>Tanggal Lahir</td>
            <td align='middle'>:</td>
            <td>
              <div id='birthdate'></div>
            </td>
        </tr>
        <tr>
            <td>Tempat Lahir</td>
            <td align='middle'>:</td>
            <td>
               <input class=input type="text" size="30" maxlength="50" name="birthplace" id="birthplace" value="{birthplace}" style="margin: 0;height: 30px;"/>
            </td>
        </tr>
        <tr>
		     <td>Jenis Kelamin</td>
			 <td align='middle'>:</td>
			 <td>  
                <select size="1" class="input" name="gendre" id="gendre" style="width: 100px;margin: 0;">
                    <option value="L" <?php if($gendre=="L") echo "Selected"; ?>>Male</option>
                    <option value="P" <?php if($gendre=="P") echo "Selected"; ?>>Female</option>
                </select>
             </td>
		</tr>
        <tr>
          <td>Agama</td>
          <td align='middle'>:</td>
          <td>
                 <select size="1" class="input" name="agama" id="agama" style="width: 100px;margin: 0;">
                 <?php
                 $data_agama = $this->admin_users_model->get_all_agama();
                 foreach($data_agama as $row_agama){
                 ?>
                    <option value="<?php echo $row_agama->id_agama; ?>" <?php if($row_agama->id_agama==$agama) echo "Selected"; ?>><?php echo $row_agama->nama; ?></option>
                 <?php
                 }
                 ?>
                 </select>
           </td>
         </tr>
         <tr>
           <td>Kepercayaan</td>
           <td align='middle'>:</td>
           <td>
              <input class=input type="text" size="40" maxlength="40" name="kepercayaan" id="kepercayaan" value="{kepercayaan}" style="margin: 0;height: 30px;"/>
           </td>
         </tr>
         <tr>
           <td>Status Perkawinan</td>
           <td align='middle'>:</td>
           <td>
                  <select size="1" class="input" name="kawin" id="kawin" style="width: 120px;margin: 0;">
                  <?php
                  $data_kawin = $this->admin_users_model->get_all_status();
                  foreach($data_kawin as $row_kawin){
                  ?>
                    <option value="<?php echo $row_kawin->id_status; ?>" <?php if($row_kawin->id_status==$kawin) echo "Selected"; ?>><?php echo $row_kawin->nama; ?></option>
                  <?php
                  }
                  ?>
                  </select>
            </td>
          </tr>
        </table>
        <table border='0' width='100%' cellpadding='0' cellspacing='0'>
	    <tr valign="top">
		 <td>
			<table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black">
				  <tr>
					 <td colspan="3">
						<h3 class="page-title">
							Informasi Alamat
						</h3>
					 </td>
				  </tr>
				  <tr>
					 <td>Phone Number</td>
					 <td align='middle'>:</td>
					 <td>
						 <input class=input type="text" size="15" maxlength="20" name="phone_number" id="phone_number" value="{phone_number}" style="margin: 0;height: 30px;"/>
					 </td>
				  </tr>
				  <tr>
					  <td>Mobile</td>
					  <td align='middle'>:</td>
					  <td>
						 <input class=input type="text" size="15" maxlength="20" name="mobile" id="mobile" value="{mobile}" style="margin: 0;height: 30px;"/>
					  </td>
				  </tr>
				  <tr>
					  <td>Email</td>
					  <td align='middle'>:</td>
					  <td>
						 <input class=input type="text" size="30" maxlength="200" name="email" id="email" value="{email}" style="margin: 0;height: 30px;"/>
					  </td>
				  </tr>
				  <tr>
					  <td colspan="3">&nbsp;</td>
				  </tr>
				  <tr>
					  <td valign='top'>Alamat</td>
					  <td align='middle' valign='top'>:</td>
					  <td>
						  <textarea cols="45" rows="3" wrap="virtual" maxlength="100" class="input" name="address" id="address">{address}</textarea>
					  </td>
				  </tr>
				  <tr>
					  <td>Propinsi</td>
					  <td align='middle'>:</td>
					  <td>
						 <select size="1" class="input" name="propinsi" id="propinsi" style="width: 255px;margin: 0;">
						 <?php
						 $data_propinsi = $this->admin_users_model->get_all_propinsi();  
						 foreach($data_propinsi as $row_propinsi){
						 ?>
							  <option value="<?php echo $row_propinsi->id_propinsi; ?>" <?php if($row_propinsi->id_propinsi==$propinsi) echo "Selected"; ?>><?php echo $row_propinsi->id_propinsi." - ".$row_propinsi->nama_propinsi; ?></option>
						 <?php
						 }
						 ?>
						 </select>
					   </td>
				   </tr>
				   <tr>
					   <td>Kota</td>
					   <td align='middle'>:</td>
					   <td>
						  <select class='input' id='kota' name='kota' style="width: 255px;margin: 0;"><option>-</option></select>
					   </td>
				   </tr>
				   <tr>
					   <td>Kecamatan</td>
					   <td align='middle'>:</td>
					   <td>
						  <select class='input' id='kecamatan' name='kecamatan' style="width: 255px;margin: 0;"><option>-</option></select>
					   </td>
				   </tr>
				   <tr>
						<td>Desa</td>
						<td align='middle'>:</td>
						<td>
						  <select class='input' id='desa' name='desa' style="width: 255px;margin: 0;"><option>-</option></select>
						</td>
				   </tr>
			</table>
		</td>
		<td>
			<table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;display: none;">
				  <tr>
					 <td colspan="3">
						<h3 class="page-title">
							Informasi Lain
						</h3>
					 </td>
				  </tr>
				   <tr>
					   <td>Tinggi Badan (cm)</td>
					   <td align='middle'>:</td>
					   <td>
						  <div id='badan_tinggi'></div>
					   </td>
				   </tr>
				   <tr>
					   <td>Berat badan (kg)</td>
					   <td align='middle'>:</td>
					   <td>
						  <div id='badan_berat'></div>
					   </td>
					</tr>
					<tr>
						<td>Rambut</td>
						<td align='middle'>:</td>
						<td>
						   <input class=input type="text" size="30" maxlength="50" name="badan_rambut" id="badan_rambut" value="{badan_rambut}" style="margin: 0;height: 30px;"/>
						</td>
					</tr>
					<tr>
					   <td>Bentuk muka</td>
					   <td align='middle'>:</td>
					   <td>
						   <input class=input type="text" size="30" maxlength="50" name="badan_muka" id="badan_muka" value="{badan_muka}" style="margin: 0;height: 30px;"/>
					   </td>
					</tr>
					<tr>
					   <td>Warna kulit</td>
					   <td align='middle'>:</td>
					   <td>
						   <input class=input type="text" size="30" maxlength="50" name="badan_kulit" id="badan_kulit" value="{badan_kulit}" style="margin: 0;height: 30px;"/>
					   </td>
					</tr>
					<tr>
					   <td>Ciri-ciri khas</td>
					   <td align='middle'>:</td>
					   <td>
						   <input class=input type="text" size="30" maxlength="50" name="badan_khas" id="badan_khas" value="{badan_khas}" style="margin: 0;height: 30px;"/>
					   </td>
					</tr>
					<tr>
					   <td>Cacat Tubuh</td>
					   <td align='middle'>:</td>
					   <td>
						   <input class=input type="text" size="30" maxlength="50" name="badan_cacat" id="badan_cacat" value="{badan_cacat}" style="margin: 0;height: 30px;"/>
					   </td>
					 </tr>
					 <tr>
					   <td>Kegemaran (hobby)</td>
					   <td align='middle'>:</td>
					   <td>
						   <input class=input type="text" size="30" maxlength="50" name="kegemaran" id="kegemaran" value="{kegemaran}" style="margin: 0;height: 30px;"/>
					   </td>
					 </tr>
					 <tr>
						<td colspan="3" height="30">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="3">
							<input type="file" name="filename" id="filename" size="50" style="display: none;" onchange="save_profile()"/>
						</td>
					</tr>       
			</table>
		</td>
		</tr>
	</table>
    </form>
</div>
