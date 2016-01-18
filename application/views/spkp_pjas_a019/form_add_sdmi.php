<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("input[name='nama']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='npsn']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='komunitas']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='jenis']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='kie_peserta']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='kie_materi']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='evaluasi']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        
        $('#propinsi').change(function(){
			$.get("<?php echo base_url()?>index.php/admin_user/select_kota/"+ $(this).val(), function(response) {
				var data = eval(response);

				$("#kota").html(data.kota);
				$('#kota').change();

			}, "json");

		});
        
        <?php if($action=="add") { ?>
            $("#tanggal_sdmi").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme});
        <?php }else{ ?>
            $("#tanggal_sdmi").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme, value: '{tanggal}'});
            
            $.get("<?php echo base_url()?>index.php/admin_user/select_kota/{propinsi}/{kabkota}", function(response) {
				var data = eval(response);

				$("#kota").html(data.kota);

			}, "json");
        <?php } ?>
    });
</script>
<div style="display: none;" id="divLoad"></div>
    <div id="divForm" style="padding:8px">
        <form method="post" id="frmDataSDMI">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_sdmi_dialog($('#frmDataSDMI').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_dialog_sdmi();">Batal</button>
            </div>
            </br>
            <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
                <tr style="display: none;">
                    <td width='18%'>ID</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                       <input type="text" size="10" maxlength="10" name="id" style="margin: 0;width: 50px;" value="{id}" readonly=""/>
                       <?php
                       if($action=="edit"){
                        ?>
                        <input type="text" size="10" maxlength="10" name="id_sdmi" style="margin: 0;width: 50px;" value="{id_sdmi}" readonly=""/>
                        <?php
                       }
                       ?>
                    </td>
                </tr>
                 <tr>
                    <td width='14%'>Tanggal</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <div id='tanggal_sdmi'></div>
                    </td>
                </tr>
                <tr>
                    <td width='18%'>Nama Sekolah</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="nama" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('nama')=="" && isset($nama)){
    								 	echo $nama;
    								}else{
    									echo  set_value('nama');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='18%'>NPSN</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="npsn" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('npsn')=="" && isset($npsn)){
    								 	echo $npsn;
    								}else{
    									echo  set_value('npsn');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Alamat</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <?php 
    					if(set_value('alamat')=="" && isset($alamat)){
    					   $val = $alamat;
    					}else{
    					   $val = set_value('alamat');
    					}
    					?>
                        <textarea cols="40" rows="3" wrap="virtual" maxlength="150" name="alamat" style="width: 300px;"><?php echo $val; ?></textarea>
                        <span style="vertical-align: top">*</span>
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Provinsi</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <select size="1" name="propinsi" id="propinsi" style="width: 300px;">
                            <?php
                            $data_propinsi = $this->spkp_pjas_a019_model->get_all_propinsi();
                                ?>
                                <option></option>
                                <?php
                            if(set_value('propinsi')=="" && isset($propinsi)){
                                foreach($data_propinsi as $row_propinsi){
                                ?>
                                <option value="<?php echo $row_propinsi->id_propinsi; ?>" <?php if($row_propinsi->id_propinsi==$propinsi) echo "Selected";  ?>><?php echo $row_propinsi->id_propinsi." - ".$row_propinsi->nama_propinsi; ?></option>
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
                        <span style="vertical-align: top">*</span>
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Kab/Kota</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <select class='input' id='kota' name='kota' style="width: 260px;"><option></option></select>
                        <span style="vertical-align: top">*</span>
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Komunitas Sekolah</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="komunitas" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('komunitas')=="" && isset($komunitas)){
    								 	echo $komunitas;
    								}else{
    									echo  set_value('komunitas');
    								}
    								 ?>"/> 
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Jenis Produk Informasi</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="jenis" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('jenis')=="" && isset($jenis)){
    								 	echo $jenis;
    								}else{
    									echo  set_value('jenis');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Peserta KIE</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="kie_peserta" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('kie_peserta')=="" && isset($kie_peserta)){
    								 	echo $kie_peserta;
    								}else{
    									echo  set_value('kie_peserta');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Materi KIE</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="kie_materi" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('kie_materi')=="" && isset($kie_materi)){
    								 	echo $kie_materi;
    								}else{
    									echo  set_value('kie_materi');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Dokumentasi</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <select size="1" name="dokumentasi" style="width: 100px;">
                            <?php
                            if(set_value('dokumentasi')=="" && isset($dokumentasi)){
                                ?>
                                <option value="Ada" <?php if($dokumentasi=="Ada") echo "Selected";  ?>>Ada</option>
                                <option value="Tidak" <?php if($dokumentasi=="Tidak") echo "Selected";  ?>>Tidak</option>
                                <?php
                            }else{
                                ?>
                                <option value="Ada">Ada</option>
                                <option value="Tidak">Tidak</option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Evaluasi Pelaksanaan</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="evaluasi" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('evaluasi')=="" && isset($evaluasi)){
    								 	echo $evaluasi;
    								}else{
    									echo  set_value('evaluasi');
    								}
    								 ?>"/> 
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
            </table>
        </form>
    </div>
</div>