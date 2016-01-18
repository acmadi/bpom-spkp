<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("input[name='kepsek']").jqxInput({ theme: 'fresh', height: '22px', width: '80px' }); 
        $("input[name='guru_uks']").jqxInput({ theme: 'fresh', height: '22px', width: '80px' }); 
        $("input[name='guru']").jqxInput({ theme: 'fresh', height: '22px', width: '80px' }); 
        $("input[name='kantin']").jqxInput({ theme: 'fresh', height: '22px', width: '80px' }); 
        $("input[name='komite']").jqxInput({ theme: 'fresh', height: '22px', width: '80px' }); 
        $("input[name='kelas4']").jqxInput({ theme: 'fresh', height: '22px', width: '80px' }); 
        $("input[name='kelas5']").jqxInput({ theme: 'fresh', height: '22px', width: '80px' }); 
        $("input[name='lainnya']").jqxInput({ theme: 'fresh', height: '22px', width: '80px' }); 
    });
</script>
<div style="display: none;" id="divLoad"></div>
    <div id="divForm" style="padding:8px">
        <form method="post" id="frmDataJumlah">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_jumlah_dialog($('#frmDataJumlah').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_dialog_jumlah();">Batal</button>
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
                        <input type="text" size="10" maxlength="10" name="hari" style="margin: 0;width: 50px;" value="{hari}" readonly=""/>
                        <?php
                       }
                       ?>
                    </td>
                </tr>
                <tr>
                    <td width='18%'>Kepsek</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="10" maxlength="10" name="kepsek" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('kepsek')=="" && isset($kepsek)){
    								 	echo $kepsek;
    								}else{
    									echo  set_value('kepsek');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Guru UKS</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="10" maxlength="10" name="guru_uks" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('guru_uks')=="" && isset($guru_uks)){
    								 	echo $guru_uks;
    								}else{
    									echo  set_value('guru_uks');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Guru</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="10" maxlength="10" name="guru" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('guru')=="" && isset($guru)){
    								 	echo $guru;
    								}else{
    									echo  set_value('guru');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Pengelola Kantin</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="10" maxlength="10" name="kantin" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('kantin')=="" && isset($kantin)){
    								 	echo $kantin;
    								}else{
    									echo  set_value('kantin');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Komite Sekolah</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="10" maxlength="10" name="komite" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('komite')=="" && isset($komite)){
    								 	echo $komite;
    								}else{
    									echo  set_value('komite');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Siswa Kelas 4</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="10" maxlength="10" name="kelas4" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('kelas4')=="" && isset($kelas4)){
    								 	echo $kelas4;
    								}else{
    									echo  set_value('kelas4');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Siswa Kelas 5</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="10" maxlength="10" name="kelas5" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('kelas5')=="" && isset($kelas5)){
    								 	echo $kelas5;
    								}else{
    									echo  set_value('kelas5');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Lainnya</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="10" maxlength="10" name="lainnya" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('lainnya')=="" && isset($lainnya)){
    								 	echo $lainnya;
    								}else{
    									echo  set_value('lainnya');
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