<script type="text/javascript">
    $(document).ready(function(){
        $("#bar_personalia").click();
        $("#btnBatal").jqxInput({ theme: 'fresh', height: '29px', width: '54px', disabled:false});
        
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
            <button type="button" onclick="back()" id="btnBatal">Batal</button>
        </div>
        </br>
        <div style="position:relative;float:right;right:200px;border:15px solid #EFEFEF;top:50px">
    		<?php
    		if($image==""){
    			?>
    			<img src="<?php echo base_url(); ?>media/images/smily-user-icon.jpg" width="200" height="200" style="border: 1px solid #404040;"/>
    			<?php
    		}else{
    			?>
    			<img src="<?php echo base_url(); ?>media/images/user/{image}" width="200" height="200" style="border: 1px solid #404040;"/>
    			<?php
    		}
    		?>
	    </div>
		<table border='0' width='60%' cellpadding='7' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
        <tr>
            <td width='14%'>NIP</td>
            <td width='3%' align='middle'>:</td>
            <td width='50%'>
                <?php
                $str_1 = substr($nip,0,8);
                $str_2 = substr($nip,8,6);
                $str_3 = substr($nip,14,1);
                $str_4 = substr($nip,15,3);
                echo $str_1." ".$str_2." ".$str_3." ".$str_4;
                ?>
            </td>
        </tr>
        <tr>
            <td width='14%'>Gelar</td>
            <td width='3%' align='middle'>:</td>
            <td>
                {gelar}
            </td>
        </tr>
        <tr>
            <td width='14%'>Nama</td>
            <td width='3%' align='middle'>:</td>
            <td>
                {nama}
            </td>
        </tr>
        <tr>
           <td>ID/KTP/SIM</td>
           <td align='middle'>:</td>
           <td>
               {id_number}
           </td>
        </tr>
        <tr>
            <td>Tanggal Lahir</td>
            <td align='middle'>:</td>
            <td>
               {birthdate}
            </td>
        </tr>
        <tr>
            <td>Tempat Lahir</td>
            <td align='middle'>:</td>
            <td>
               {birthplace}
            </td>
        </tr>
        <tr>
		     <td>Jenis Kelamin</td>
			 <td align='middle'>:</td>
			 <td>  
                <?php
                if($gendre=="L"){
                    echo "Male";
                }else{
                    echo "Female";
                }
                ?>
             </td>
		</tr>
        <tr>
          <td>Agama</td>
          <td align='middle'>:</td>
          <td>
               <?php
               if($data_agama = $this->spkp_personnel_model->get_agama($agama)){
                echo $data_agama['nama'];
               }
               ?>
           </td>
         </tr>
         <tr>
           <td>Kepercayaan</td>
           <td align='middle'>:</td>
           <td>
              {kepercayaan}
           </td>
         </tr>
         <tr>
           <td>Status Perkawinan</td>
           <td align='middle'>:</td>
           <td>
                <?php
                if($data_kawin = $this->spkp_personnel_model->get_kawin($kawin)){
                    echo $data_kawin['nama'];
                }
                ?>  
            </td>
          </tr>
        </table>
        <table border='0' width='100%' cellpadding='0' cellspacing='0'>
	    <tr valign="top">
		 <td>
			<table border='0' width='100%' cellpadding='7' cellspacing='2' style="font-size: 12px;color: black">
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
						 {phone_number}
					 </td>
				  </tr>
				  <tr>
					  <td>Mobile</td>
					  <td align='middle'>:</td>
					  <td>
						 {mobile}
					  </td>
				  </tr>
				  <tr>
					  <td>Email</td>
					  <td align='middle'>:</td>
					  <td>
						 {email}
					  </td>
				  </tr>
				  <tr>
					  <td colspan="3">&nbsp;</td>
				  </tr>
				  <tr>
					  <td valign='top'>Alamat</td>
					  <td align='middle' valign='top'>:</td>
					  <td>
						  {address}
					  </td>
				  </tr>
				  <tr>
					  <td>Propinsi</td>
					  <td align='middle'>:</td>
					  <td>
						 <?php
                         if($data_propinsi = $this->spkp_personnel_model->get_propinsi($propinsi)){
                            echo $data_propinsi['nama_propinsi'];
                         }
                         
                         ?>
					   </td>
				   </tr>
				   <tr>
					   <td>Kota</td>
					   <td align='middle'>:</td>
					   <td>
						  <?php
                          if($data_kota = $this->spkp_personnel_model->get_kota($kota)){
                            echo $data_kota['nama_kota'];
                          }
                          ?>
					   </td>
				   </tr>
				   <tr>
					   <td>Kecamatan</td>
					   <td align='middle'>:</td>
					   <td>
						  <?php
                          if($data_kec = $this->spkp_personnel_model->get_kecamatan($kecamatan)){
                            echo $data_kec['nama_kecamatan'];
                          }
                          ?>
					   </td>
				   </tr>
				   <tr>
						<td>Desa</td>
						<td align='middle'>:</td>
						<td>
						   <?php
                           if($data_desa = $this->spkp_personnel_model->get_desa($desa)){
                            echo $data_desa['nama_desa'];
                           }
                           ?>
						</td>
				   </tr>
			</table>
		</td>
		<td>
			<table border='0' width='100%' cellpadding='7' cellspacing='2' style="font-size: 12px;color: black">
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
					       {badan_tinggi}
					   </td>
				   </tr>
				   <tr>
					   <td>Berat badan (kg)</td>
					   <td align='middle'>:</td>
					   <td>
						  {badan_berat}
					   </td>
					</tr>
					<tr>
						<td>Rambut</td>
						<td align='middle'>:</td>
						<td>
						   {badan_rambut}
						</td>
					</tr>
					<tr>
					   <td>Bentuk muka</td>
					   <td align='middle'>:</td>
					   <td>
						   {badan_muka}
					   </td>
					</tr>
					<tr>
					   <td>Warna kulit</td>
					   <td align='middle'>:</td>
					   <td>
						   {badan_kulit}
					   </td>
					</tr>
					<tr>
					   <td>Ciri-ciri khas</td>
					   <td align='middle'>:</td>
					   <td>
						   {badan_khas}
					   </td>
					</tr>
					<tr>
					   <td>Cacat Tubuh</td>
					   <td align='middle'>:</td>
					   <td>
						   {badan_cacat}
					   </td>
					 </tr>
					 <tr>
					   <td>Kegemaran (hobby)</td>
					   <td align='middle'>:</td>
					   <td>
						   {kegemaran}
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
