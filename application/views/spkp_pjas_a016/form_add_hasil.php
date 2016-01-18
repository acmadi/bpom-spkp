<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("input[name='lokasi']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='kode_sampel']").jqxInput({ theme: 'fresh', height: '22px', width: '210px' }); 
        $("input[name='produk']").jqxInput({ theme: 'fresh', height: '22px', width: '210px' }); 
        $("input[name='pedagang']").jqxInput({ theme: 'fresh', height: '22px', width: '210px' }); 
        $("input[name='pengolah']").jqxInput({ theme: 'fresh', height: '22px', width: '210px' }); 
        $("input[name='jenis']").jqxInput({ theme: 'fresh', height: '22px', width: '210px' }); 
        $("input[name='no_pendaftaran']").jqxInput({ theme: 'fresh', height: '22px', width: '210px' }); 
        $("input[name='kesimpulan_akhir']").jqxInput({ theme: 'fresh', height: '22px', width: '210px' }); 
        $("input[name='tindaklanjut']").jqxInput({ theme: 'fresh', height: '22px', width: '210px' }); 
        
        $('#propinsi').change(function(){
			$.get("<?php echo base_url()?>index.php/admin_user/select_kota/"+ $(this).val(), function(response) {
				var data = eval(response);

				$("#kota").html(data.kota);
				$('#kota').change();

			}, "json");

		});
        
        <?php if($action=="edit") { ?>
            $.get("<?php echo base_url()?>index.php/admin_user/select_kota/{propinsi}/{kabkota}", function(response) {
				var data = eval(response);

				$("#kota").html(data.kota);

			}, "json");
        <?php } ?>
    });
</script>
<div style="display: none;" id="divLoad"></div>
    <div id="divForm" style="padding:8px">
        <form method="post" id="frmDataHasil">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_hasil_dialog($('#frmDataHasil').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_dialog_hasil();">Batal</button>
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
                        <input type="text" size="10" maxlength="10" name="id_hasil" style="margin: 0;width: 50px;" value="{id_hasil}" readonly=""/>
                        <?php
                       }
                       ?>
                    </td>
                </tr>
                <tr>
                    <td width='18%'>Lokasi</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="lokasi" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('lokasi')=="" && isset($lokasi)){
    								 	echo $lokasi;
    								}else{
    									echo  set_value('lokasi');
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
                    <td width='14%'>Propinsi</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <select size="1" name="propinsi" id="propinsi" style="width: 300px;">
                            <?php
                            $data_propinsi = $this->spkp_pjas_a016_model->get_all_propinsi();
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
                    <td width='14%'>Kode Sampel</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="20" maxlength="20" name="kode_sampel" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('kode_sampel')=="" && isset($kode_sampel)){
    								 	echo $kode_sampel;
    								}else{
    									echo  set_value('kode_sampel');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Nama Produk</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="20" maxlength="20" name="produk" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('produk')=="" && isset($produk)){
    								 	echo $produk;
    								}else{
    									echo  set_value('produk');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Nama Pedagang</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="20" maxlength="20" name="pedagang" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('pedagang')=="" && isset($pedagang)){
    								 	echo $pedagang;
    								}else{
    									echo  set_value('pedagang');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Nama Pengolah</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="20" maxlength="20" name="pengolah" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('pengolah')=="" && isset($pengolah)){
    								 	echo $pengolah;
    								}else{
    									echo  set_value('pengolah');
    								}
    								 ?>"/> 
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Jenis Pangan</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="20" maxlength="20" name="jenis" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('jenis')=="" && isset($jenis)){
    								 	echo $jenis;
    								}else{
    									echo  set_value('jenis');
    								}
    								 ?>"/> 
                    </td>
                </tr>
                <tr>
                    <td width='14%'>No. Pendaftaran</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="20" maxlength="20" name="no_pendaftaran" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('no_pendaftaran')=="" && isset($no_pendaftaran)){
    								 	echo $no_pendaftaran;
    								}else{
    									echo  set_value('no_pendaftaran');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Kesimpulan Akhir</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="20" maxlength="20" name="kesimpulan_akhir" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('kesimpulan_akhir')=="" && isset($kesimpulan_akhir)){
    								 	echo $kesimpulan_akhir;
    								}else{
    									echo  set_value('kesimpulan_akhir');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Tindak Lanjut</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="20" maxlength="20" name="tindaklanjut" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('tindaklanjut')=="" && isset($tindaklanjut)){
    								 	echo $tindaklanjut;
    								}else{
    									echo  set_value('tindaklanjut');
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