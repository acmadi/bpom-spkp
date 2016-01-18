<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("input[name='nama_sekolah']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='kepsek_nip']").jqxInput({ theme: 'fresh', height: '22px', width: '130px' }); 
        $("input[name='alamat']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='kepsek_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='nilai']").jqxInput({ theme: 'fresh', height: '22px', width: '70px' }); 
        $("input[name='temuan']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='kode_pbkpks']").jqxInput({ theme: 'fresh', height: '22px', width: '130px' }); 
    });
</script>
<div style="display: none;" id="divLoad"></div>
    <div id="divForm" style="padding:8px">
        <form method="post" id="frmDataSdmi">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_sdmi_dialog($('#frmDataSdmi').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_dialog_sdmi();">Batal</button>
            </div>
            </br>
            <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
                <tr style="display: none;">
                    <td width='25%'>ID</td>
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
                    <td width='25%'>Nama Sekolah</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="nama_sekolah" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('nama_sekolah')=="" && isset($nama_sekolah)){
    								 	echo $nama_sekolah;
    								}else{
    									echo  set_value('nama_sekolah');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3">Kepala Sekolah</td>
                </tr>
                <tr>
                    <td width='14%'>Nama</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="100" name="kepsek_nama" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('kepsek_nama')=="" && isset($kepsek_nama)){
    								 	echo $kepsek_nama;
    								}else{
    									echo  set_value('kepsek_nama');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>NIP</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="20" maxlength="20" name="kepsek_nip" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('kepsek_nip')=="" && isset($kepsek_nip)){
    								 	echo $kepsek_nip;
    								}else{
    									echo  set_value('kepsek_nip');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td width='14%'>Alamat Sekolah</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="200" name="alamat" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('alamat')=="" && isset($alamat)){
    								 	echo $alamat;
    								}else{
    									echo  set_value('alamat');
    								}
    								 ?>"/> 
                    </td>
                </tr>
                <tr>
                    <td width='22%'>Nilai Audit Sarana (%)</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="10" maxlength="10" name="nilai" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('nilai')=="" && isset($nilai)){
    								 	echo $nilai;
    								}else{
    									echo  set_value('nilai');
    								}
    								 ?>"/> 
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Temuan Ketidaksesuaian</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="100" maxlength="200" name="temuan" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('temuan')=="" && isset($temuan)){
    								 	echo $temuan;
    								}else{
    									echo  set_value('temuan');
    								}
    								 ?>"/> 
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Kode PBKP-KS</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="20" maxlength="20" name="kode_pbkpks" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('kode_pbkpks')=="" && isset($kode_pbkpks)){
    								 	echo $kode_pbkpks;
    								}else{
    									echo  set_value('kode_pbkpks');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
            </table>
        </form>
    </div>
</div>