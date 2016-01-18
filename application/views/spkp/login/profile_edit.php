<script type="text/javascript">
	$(document).ready(function(){
		$("#tabs").tabs();
        $("#birthdate,#tgl_ijin").datepicker({
          dateFormat: "yy-mm-dd",
		  yearRange: '1960:2013',
          changeMonth: true,
          changeYear: true
        }); 

		$("select[name='kode_provinsi']").change(function() {
			$("select[name='kode_kota']").html("<option>-</option>");
			$.get("<?php echo base_url();?>index.php/ske/kota/" + $("select[name='kode_provinsi']").val()+"/0",{}, function(response) {
				var data = eval(response);

				$("select[name='kode_kota']").html(data.kota);

			}, "json");
		});
		$("select[name='kode_provinsi']").change();

		$("[name='username']").keyup(function(){
			$("[name='username']").change();
		});

		$("[name='nama_perusahaan']").change(function(){
			var illegalChars = /\W/; 
			var nama_perusahaan = $("[name='nama_perusahaan']").val().replace(/ /g,'');
			
			$("[name='nama_perusahaan']").val(nama_perusahaan);
			if(illegalChars.test(nama_perusahaan)){
				 $("#perusahaan_info").html("Maaf anda menggunakan karakter ilegal");
				 $("#perusahaan_info").css("color","red");
			}else{
				if(nama_perusahaan.length>=3){
					$.ajax({ 
						type: "GET",
						url: "<?php echo base_url()?>index.php/ske/check_perusahaan/"+nama_perusahaan,
						success: function(response){
							var res = response.split("__");
							 $("#perusahaan_info").html(res[1]);
							 if(res[0]=="1") $("#perusahaan_info").css("color","green");
							 else $("#perusahaan_info").css("color","red");
						}
					 }); 		
				}else{
					 $("#perusahaan_info").html("Nama Perusahaan minimal 3 karakter");
					 $("#perusahaan_info").css("color","red");
				}
			}
		});

		$("[name='nama_perusahaan']").keyup(function(){
			$("[name='nama_perusahaan']").change();
		});


		$('#btn_save').click(function(){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/ske/profile_doedit",
				data: $('#frmUsers').serialize(),
				success: function(response){
					 if(response=="1"){
						 $.notific8('Notification', {
						  life: 3000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
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

		$('#btn_save_perusahaan').click(function(){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/ske/profile_doperusahaan",
				data: $('#frmPerusahaan').serialize(),
				success: function(response){
					 if(response=="1"){
						 $.notific8('Notification', {
						  life: 3000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
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

		$('#btn_save_pswd').click(function(){
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/ske/profile_dopasswd",
				data: $('#frmUsersPswd').serialize(),
				success: function(response){
					 if(response=="1"){
						 $.notific8('Notification', {
						  life: 3000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
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
<style type="text/css">
.white {
    background: white;
}

</style>
<div style="width:99%;background-color:#F6F6F6;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #F9F9F9;height:40px">
	<table width='100%' cellpadding=0 cellspacing=0 height='100%'>
		<tr valign="middle">
			<td style='background:#FFFFFF;-moz-border-radius:5px 0px 0px 5px;border-radius:5px 0px 0px 5px;padding-left:5px;font-size:15px;color:#585858;font-weight:bold' width='50%'>
				. {title} :: <?php echo $username; ?>
			</td>
			<td style='background:#EDEDED;-moz-border-radius:0px 5px 5px 0px;border-radius:0px 5px 5px 0px;text-align:right;padding-right:20px'>
			</td>
		</tr>
	</table>
</div>
<div style="width:99%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
<div id="tabs" style="min-height:400px">
	<ul>
		<li id="tabs1"><a href="#tabs-1">Data Pengguna</a></li>
		<li id="tabs2"><a id="a_tabs2" href="#tabs-2">Data Perusahaan</a></li>
		<li id="tabs3"><a id="a_tabs3" href="#tabs-3">Ubah Password</a></li>
		<li id="tabs4"><a id="a_tabs4" href="#tabs-4">Setting</a></li>
	</ul>
	<div id="tabs-1">
	<form method="POST" name="frmUsers" id="frmUsers">
		<table width='60%' cellpadding='6' cellspacing='2' border='0' style="border: 1px solid rgb(204,209,205);background: rgb(244,244,244);">
		<tr>
			<td colspan="3" align="right">
					<button class='btn' id='btn_save' type='button'>Simpan</button>
					<button class='btn' id='btn_reset' type='reset'>Reset</button>
			</td>
		</tr>
		<tr>
			<td width='18%'>Email</td>
			<td width='1%'>:</td>
			<td class="white">
			<?php
				if(set_value('email')=="" && isset($email)) $email = $email; else $email = $_POST['email'];
			?>
				<input type="text" size="40" class="input" name="email" value="<?php echo $email ?>"/> <span style="color: red;">*)</span>
			</td>
		</tr>
		<tr>
			<td width='18%'>Nama Lengkap</td>
			<td width='1%'>:</td>
			<td class="white">
				<input type="text" size="60" class="input" name="nama" value="<?php echo $nama; ?>"/>
				<span style="color: red;">*)</span>
			</td>
		</tr>
		<tr>
			<td width='18%'>Jabatan</td>
			<td width='1%'>:</td>
			<td class="white">
				<input type="text" size="30" class="input" name="jabatan" value="<?php echo $jabatan; ?>"/>
				<span style="color: red;">*)</span>
			</td>
		</tr>
		<tr>
			<td width='18%'>Gender</td>
			<td width='1%'>:</td>
			<td class="white">
				<select size="1" class="input" name="gendre">
				<option value="L" <?php if($gendre=='L') echo "selected";?>>Male</option>
				<option value="P" <?php if($gendre=='P') echo "selected";?>>Female</option>
				</select>
			</td>
		</tr>
		<tr>
			<td width='18%'>Tgl Lahir</td>
			<td width='1%'>:</td>
			<td class="white">
				<input type="text" size="10" class="input" id="birthdate" name="birthdate" readonly value="<?php echo $birthdate; ?>"/>
				<img src="<?php echo base_url(); ?>plugins/js/jquery-ui-1.10.1.custom/development-bundle/demos/datepicker/images/calendar.gif"/>
			</td>
		</tr>
		<tr>
			<td width='18%'>Tempat Lahir</td>
			<td width='1%'>:</td>
			<td class="white">
			<input type="text" size="20" class="input" name="birthplace" value="<?php echo $birthplace; ?>"/>
			</td>
		</tr>
		<tr>
			<td width='18%'>Nomor SIK</td>
			<td width='1%'>:</td>
			<td class="white">
				<input type="text" size="40" class="input" name="nomor_sik" value="<?php echo $nomor_sik; ?>"/>
				<span style="color: red;">*)</span>
			</td>
		</tr>
		
		<tr>
			<td width='18%'>Alamat</td>
			<td width='1%'>:</td>
			<td class="white">
			<textarea cols="40" rows="3" wrap="virtual" maxlength="100" class="input" name="address"><?php echo $address; ?></textarea>
			</td>
		</tr>
		
		<tr>
			<td width='18%'>No Telepon</td>
			<td width='1%'>:</td>
			<td class="white">
				<input type="text" size="20" class="input" name="phone_number" value="<?php echo $phone_number; ?>"/>
				<span style="color: red;">*)</span>
			</td>
		</tr>
		<tr>
			<td width='18%'>Mobile</td>
			<td width='1%'>:</td>
			<td class="white">
			<input type="text" size="20" class="input" name="mobile" value="<?php echo $mobile; ?>"/>
			</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
		</table>
	</form>
	</div>
	<div id="tabs-2">
	<form method="POST" name="frmPerusahaan" id="frmPerusahaan">
		<table width='60%' cellpadding='6' cellspacing='2' border='0' style="border: 1px solid rgb(204,209,205);background: rgb(244,244,244);">
		<tr>
			<td colspan="3" align="right">
					<button class='btn' id='btn_save_perusahaan' type='button'>Simpan Data Perusahaan</button>
					<button class='btn' id='btn_reset_perusahaan' type='reset'>Reset</button>
			</td>
		</tr>
		<tr>
			<td width='18%'>Nama Perusahaan</td>
			<td width='1%'>:</td>
			<td class="white">
				<input type="text" size="40" class="input" name="nama_perusahaan" value="<?php echo $nama_perusahaan; ?>"/>
				<span style="color: red;" id="perusahaan_info">&nbsp; min 3 karakter *) </span>
			</td>
		</tr>
		<tr>
			<td width='18%'>Alamat</td>
			<td width='1%'>:</td>
			<td class="white">
				<textarea cols="40" rows="3" wrap="virtual" maxlength="100" class="input" name="alamat"><?php echo $alamat; ?></textarea>
				<span style="color: red;">*)</span>
			</td>
		</tr>
		<tr>
			<td width='18%'>Provinsi / Kota</td>
			<td width='1%'>:</td>
			<td class="white">{provinsi_option} / 
				<select name="kode_kota" id="kode_kota" class="input">
				</select>
				<span style="color: red;">*)</span>
			</td>
		</tr>
		<tr>
			<td width='18%'>Kode POS</td>
			<td width='1%'>:</td>
			<td class="white">
				<input type="text" size="10" class="input" name="kode_pos" value="<?php echo $kode_pos; ?>"/>
				<span style="color: red;">*)</span>
			</td>
		</tr>
		<tr>
			<td width='18%'>Telpon</td>
			<td width='1%'>:</td>
			<td class="white">
				<input type="text" size="20" class="input" name="tlp" value="<?php echo $tlp; ?>"/>
				<span style="color: red;">*)</span>
			</td>
		</tr>
		<tr>
			<td width='18%'>Faksimili</td>
			<td width='1%'>:</td>
			<td class="white">
				<input type="text" size="20" class="input" name="faksimili" value="<?php echo $faksimili; ?>"/>
			</td>
		</tr>
		<tr>
			<td width='18%'>Jenis Usaha</td>
			<td width='1%'>:</td>
			<td class="white">
				{jenis_industri_option}
				<span style="color: red;">*)</span>
			</td>
		</tr>
		<tr>
			<td width='18%'>Tgl. Ijin</td>
			<td width='1%'>:</td>
			<td class="white">
				<input type="text" size="10" class="input" name="tgl_ijin" id="tgl_ijin" readonly value="<?php echo $tgl_ijin; ?>"/>
				<img src="<?php echo base_url(); ?>plugins/js/jquery-ui-1.10.1.custom/development-bundle/demos/datepicker/images/calendar.gif"/>
			</td>
		</tr>
		<tr>
			<td width='18%'>NPWP</td>
			<td width='1%'>:</td>
			<td class="white">
				<input type="text" size="30" class="input" name="npwp" value="<?php echo $npwp; ?>"/>
				<span style="color: red;">*)</span>
			</td>
		</tr>
		<tr>
			<td width='18%'> Alamat NPWP</td>
			<td width='1%'>:</td>
			<td class="white">
				<textarea cols="40" rows="3" wrap="virtual" maxlength="100" class="input" name="npwp_alamat"><?php echo $npwp_alamat; ?></textarea>
				<span style="color: red;">*)</span>
			</td>
		</tr>
		<tr>
			<td width='18%'>API</td>
			<td width='1%'>:</td>
			<td class="white">
				<input type="text" size="30" class="input" name="api" value="<?php echo $api; ?>"/>
			</td>
		</tr>
		 <tr>
			<td width='18%'> Alamat Gudang</td>
			<td width='1%'>:</td>
			<td class="white">
			<textarea cols="40" rows="3" wrap="virtual" maxlength="100" class="input" name="gudang_alamat"><?php echo $gudang_alamat; ?></textarea>
			</td>
		</tr>
	   <tr>
			<td width='18%'>Tlp. Gudang</td>
			<td width='1%'>:</td>
			<td class="white">
				<input type="text" size="20" class="input" name="gudang_tlp" value="<?php echo $gudang_tlp; ?>"/>
			</td>
		</tr>
	</table>
	</form>
	</div>
	<div id="tabs-3">
	<form method="POST" name="frmUsers" id="frmUsersPswd">
		<table width='60%' cellpadding='6' cellspacing='2' border='0' style="border: 1px solid rgb(204,209,205);background: rgb(244,244,244);">
		<tr>
			<td colspan="3" align="right">
					<button class='btn' id='btn_save_pswd' type='button'>Ubah Password</button>
					<button class='btn' id='btn_reset_pswd' type='reset'>Reset</button>
			</td>
		</tr>
		<tr>
			<td width='18%'>Password</td>
			<td width='1%'>:</td>
			<td class="white">
				<input type="password" size="20" class="input" name="password"/>
				<span style="color: red;">&nbsp; min 5 karakter</span>
			</td>
		</tr>
		<tr>
			<td width='18%'>Konfirmasi Password</td>
			<td width='1%'>:</td>
			<td class="white">
				<input type="password" size="20" class="input" name="passconf"/>
			</td>
		</tr>
	</table>
	</form>
	</div>
	<div id="tabs-4">
	<form method="POST" name="frmUsers" id="frmSetting">
		<table width='60%' cellpadding='6' cellspacing='2' border='0' style="border: 1px solid rgb(204,209,205);background: rgb(244,244,244);">
		<tr>
			<td colspan="3" align="right">
					<button class='btn' id='btn_save_setting' type='button'>Simpan Setting</button>
					<button class='btn' id='btn_reset_setting' type='reset'>Reset</button>
			</td>
		</tr>
		<tr>
			<td width='18%'>Username</td>
			<td width='1%'>:</td>
			<td class="white">{username}</td>
		</tr>
	</table>
	</form>
	</div>
</div>
