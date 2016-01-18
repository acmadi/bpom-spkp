<script type="text/javascript">
    $(document).ready(function(){
       $("button,submit,reset").jqxInput({ theme: 'fresh', height: '28px', width: '100px' });  
       if('{status_kirim}'=='0'){
           $("input[name='jml']").jqxInput({ theme: 'fresh', height: '23px', width: '30px' }); 
           
           $("input").hover(
           function(){
                $(this).css('background','#F4F4F4');
           }, function(){
                $(this).css('background','white');
           });  
           
        $("[name='btn_simpan']").click(function(){
            $("#divFormCuti").fadeOut("fast");
            $("#divLoadForm").css('display','block');
            $("#divLoadForm").html("<div style='text-align:center;margin-top: 70px'><br><br><br><br><img src='<?php echo base_url();?>media/images/loaderB64.gif' alt='loading content.. '><br>loading</div>");
        
            $.ajax({
               type: "POST",
               url: "<?php echo base_url(); ?>spkp_personalia_form_pegawai/save_form/{id}/{kode}",
               data: $("#frmDataIzin").serialize(),
               success: function(response){
                    if(response=="1"){
                        $.notific8('Notification', {
						  life: 5000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
                        
                        $("#divLoadForm").css('display','none');
                        $.ajax({
                           type: "GET",
                           url: "<?php echo base_url(); ?>spkp_personalia_form_pegawai/load_form_cuti/{uid}/{id}",
                           success: function(response){
                                $("#divFormCuti").html(response);
                                $("#divFormCuti").fadeIn("slow");
                           } 
                        });
                    
                    }else if(response=="0"){
                        $.notific8('Notification', {
						  life: 5000,
						  message: 'Save data Failed',
						  heading: 'Saving data FAIL',
						  theme: 'red2'
						});
                        $("#divLoadForm").css('display','none');
                        $("#divFormCuti").fadeIn("slow");
                    }else{
                        $.notific8('Notification', {
						  life: 5000,
						  message: response,
						  heading: 'Saving data FAIL',
						  theme: 'red2'
						});
                        $("#divLoadForm").css('display','none');
                        $("#divFormCuti").fadeIn("slow");
                    }            
               } 
            });
        });
        
        $("button[name='btn_kirim']").click(function(){
           $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>spkp_personalia_form_pegawai/save_form/{id}/{kode}",
                data: $("#frmDataIzin").serialize(),
                success: function(response){
                    if(response=="1"){
                       if(confirm("Anda yakin akan mengirim formulir cuti ini ?")){
                            $("#divFormCuti").fadeOut("slow");
                            $("#divFormCuti").html("");
                            $.ajax({
                               type: "POST",
                               url: "<?php echo base_url(); ?>spkp_personalia_form_pegawai/dosend_cuti/{id}/{kode}",
                               success: function(response){
                                if(response=="1"){
                                    $.notific8('Notification', {
                						  life: 5000,
                						  message: 'Save data succesfully.',
                						  heading: 'Saving data',
                						  theme: 'lime2'
                						});
                                    
                                    $.ajax({
                                       type: "GET",
                                       url: "<?php echo base_url(); ?>spkp_personalia_form_pegawai/load_form_cuti/{uid}/{id}",
                                       success: function(response){
                                            $("#divFormCuti").html(response);
                                            $("#divFormCuti").fadeIn("slow");
                                       } 
                                    });
                                }else{
                                    $.notific8('Notification', {
                						  life: 5000,
                						  message: 'Save data Failed',
                						  heading: 'Saving data FAIL',
                						  theme: 'red2'
                						});
                                    $("#divFormCuti").fadeIn("slow");
                                }            
                               } 
                            });
                            }   
                            
                   }else if(response=="0"){
                        $.notific8('Notification', {
						  life: 5000,
						  message: 'Save data Failed',
						  heading: 'Saving data FAIL',
						  theme: 'red2'
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
        }
        
        $("[name='btn_back']").click(function(){
			window.location.href="<?php echo base_url()?>spkp_personalia_form_pegawai/detail/{uid}";
		});
        
        $("button[name='btn_export']").click(function(){
            $.ajax({
               type: "POST",
               url: "<?php echo base_url(); ?>spkp_personalia_form_pegawai/export/{uid}/{id}/{kode}",
               success: function(response){
                  window.open("<?php echo base_url();?>spkp_loader/"+response);
               } 
            });
        });
        
        $("button[name='btn_upload']").click(function(){
            $("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
			$("#popup").jqxWindow({
				theme: theme, resizable: false, position: { x: 300, y: 200},
                width: 720,
                height: 330,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup").jqxWindow('open');
			$.get("<?php echo base_url();?>spkp_personalia_form_pegawai/add_upload/{id}" , function(response) {
				$("#popup_content").html("<div>"+response+"</div>");
			});   
        });
        
        if({add_permission}==true){
            if({status_approve}=='0'){
                $("button[name='btn_approve']").click(function(){
                    if(confirm("Anda yakin akan menyetujui formulir cuti/izin ini ?")){
                        $("#divFormCuti").fadeOut("slow");
                        $("#divFormCuti").html("");
                        $.ajax({
                           type: "POST",
                           url: "<?php echo base_url(); ?>spkp_personalia_form_pegawai/doapprove_status/{id}/{status_approve}",
                           success: function(response){
                                if(response=="1"){
                                    $.notific8('Notification', {
                						  life: 3000,
                						  message: 'Save data succesfully.',
                						  heading: 'Saving data',
                						  theme: 'lime2'
                						});
                                    
                                    $.ajax({
                                       type: "GET",
                                       url: "<?php echo base_url(); ?>spkp_personalia_form_pegawai/load_form_cuti/{uid}/{id}",
                                       success: function(response){
                                            $("#divFormCuti").html(response);
                                            $("#divFormCuti").fadeIn("slow");
                                       } 
                                    });
                                }else{
                                    $.notific8('Notification', {
                						  life: 4000,
                						  message: 'Save data Failed',
                						  heading: 'Saving data FAIL',
                						  theme: 'red2'
                						});
                                    $("#divFormCuti").fadeIn("slow");
                                }
                           } 
                        });
                    }
                });
            }else{
                $("button[name='btn_not_approve']").click(function(){
                    if(confirm("Anda yakin tidak akan menyetujui formulir cuti/izin ini ?")){
                        $("#divFormCuti").fadeOut("slow");
                        $("#divFormCuti").html("");
                        $.ajax({
                           type: "POST",
                           url: "<?php echo base_url(); ?>spkp_personalia_form_pegawai/doapprove_status/{id}/{status_approve}",
                           success: function(response){
                                if(response=="1"){
                                    $.notific8('Notification', {
                						  life: 3000,
                						  message: 'Save data succesfully.',
                						  heading: 'Saving data',
                						  theme: 'lime2'
                						});
                                    
                                    $.ajax({
                                       type: "GET",
                                       url: "<?php echo base_url(); ?>spkp_personalia_form_pegawai/load_form_cuti/{uid}/{id}",
                                       success: function(response){
                                            $("#divFormCuti").html(response);
                                            $("#divFormCuti").fadeIn("slow");
                                       } 
                                    });
                                }else{
                                    $.notific8('Notification', {
                						  life: 4000,
                						  message: 'Save data Failed',
                						  heading: 'Saving data FAIL',
                						  theme: 'red2'
                						});
                                    $("#divFormCuti").fadeIn("slow");
                                }
                           } 
                        });
                    }
                });
            }
        }
    });
</script>
<div id="popup" style="display:none"><div id="popup_title">Form Dokumen Cuti/Izin</div><div id="popup_content"></div></div>
        <form method="POST" id="frmDataIzin">
    		<div style="width: 99%;text-align: right;background: #F4F4F4;padding: 5px;">
                <?php
                if($uid==$this->session->userdata('id') || $add_permission==true){
                    ?>
                    <span style="text-align: left;float: left;color: <?php echo $status_approve=="0" ? "black" : "green" ?>;font-weight: bold;padding: 4px;">{status}</span>
                    <?php
                }
                
                if($add_permission==true){
                    if($status_kirim=="1"){
                        if($status_approve=="0"){
                            ?>
                            <button type="button" name="btn_approve">Approve</button>
                            <?php
                        }else{
                            ?>
                            <button type="button" name="btn_not_approve">Not Approve</button>
                        <?php
                        }
                     }
                }
                ?>      
                
                <?php if($status_kirim=='1'){ ?>
                <button type="button" name="btn_upload">Upload</button>
                <button type="button" name="btn_export">Export</button>
                <?php } if($status_kirim=='0'){ ?>
                <button type="button" name="btn_kirim">Kirim Formulir</button>
                <button type="button" name="btn_simpan">Simpan</button>
                <?php } ?>
        		<button type="button" name="btn_back">Kembali</button>
            </div>
            <br />
           <table width='65%' cellpadding='4' cellspacing='2' border='0' align='center' style="font-size: 13px;color: black">
                <tr>
                    <td colspan="3">Formulir Cuti Sakit</td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3">Yang bertanda tangan dibawah ini saya  :</td>
                </tr>
                <tr>
                    <td width='10%'>Nama</td>
                    <td width='3%' align='center'>:</td>
                    <td>{nama}</td>
                </tr>
                <tr>
                    <td>NIP</td>
                    <td align='center'>:</td>
                    <td>{nip}</td>
                </tr>
                <tr>
                    <td>Pangkat/Golongan</td>
                    <td align='center'>:</td>
                    <td><?php echo isset($golongan) ? $golongan : "" ?> - <?php echo isset($jabatan) ? $jabatan : "" ?></td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td align='center'>:</td>
                    <td><?php echo isset($nama_jabatan) ? $nama_jabatan : "" ?></td>
                </tr>
                <tr>
                    <td>Unit Kerja</td>
                    <td align='center'>:</td>
                    <td><?php echo isset($ket) ? $ket : "" ?></td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <?php
                        if($status_kirim=="1"){
                            ?>
                            <p align='justify'>
                                Dengan ini mengajukan permintaan cuti sakit selama {prm_jml} {prm_hitungan}*
                                karena saya menderita {prm_stat_sakit} dan oleh karena menjalankan tugas kewajiban*,
                                sesuai dengan surat keterangan {stat_lampiran}* terlampir
                            </p>
                            <?php
                        }else{
                            ?>
                            <p align='justify'>
                                <input type="text" size="10" name="stat_tgl" value="{tgl}" style="display: none;"/>
                                Dengan ini mengajukan permintaan cuti sakit selama <input type="text" size="8" value="{prm_jml}" name="jml" style="border: 0px;border-bottom: dotted;text-align: center;"/>
                                <select size='1' name='hitungan' style='width: 76px;'>
                                  <option value='hari'  <?php if(strtolower($prm_hitungan)=="hari") echo "Selected"; ?>>Hari</option>
                                  <option value='bulan' <?php if(strtolower($prm_hitungan)=="bulan") echo "Selected"; ?>>Bulan</option>
                                  <option value='tahun' <?php if(strtolower($prm_hitungan)=="tahun") echo "Selected"; ?>>Tahun</option>
                               </select>*
                                karena saya menderita  
                                <select size="1" name="stat_sakit" style="width: 185px;">
                                    <option value="sakit" <?php if(strtolower($prm_stat_sakit)=="sakit") echo "Selected"; ?>>Sakit</option>
                                    <option value="gugur kandungan" <?php if(strtolower($prm_stat_sakit)=="gugur kandungan") echo "Selected"; ?>>Gugur Kandungan</option>
                                    <option value="mengalami kecelakaan" <?php if(strtolower($prm_stat_sakit)=="mengalami kecelakaan") echo "Selected"; ?>>Mengalami Kecelakaan</option>
                                </select> 
                                dan oleh karena menjalankan tugas kewajiban*,
                                sesuai dengan surat keterangan 
                                <select size="1" name="stat_lampiran" style="width: 85px;">
                                    <option value="dokter" <?php if(strtolower($prm_stat_lampiran)=="dokter") echo "Selected";  ?>>Dokter</option>
                                    <option value="bidan" <?php if(strtolower($prm_stat_lampiran)=="bidan") echo "Selected";  ?>>Bidan</option>
                                </select>
                                * terlampir
                            </p>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p align='justify'>
                        Demikian permintaan ini saya buat untuk dapat dipertimbangkan sebagaimana mestinya.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">Hormat Saya,</td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">
                    <u>{nama}</u></br>
		            NIP. {nip}
                    </td>
                </tr>
            </table>
        </form>       