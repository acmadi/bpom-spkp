<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("input[name='ttd_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='ttd_nip']").jqxInput({ theme: 'fresh', height: '22px', width: '130px' }); 
        $("input[name='ttd_tmpt']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='penyelenggara']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='tempat']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("#ttd_tgl").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme});
        $("#tgl").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme});
    });
</script>
<?php
?>
<div style="display: none;" id="divLoad"></div>
    <div id="divForm" style="padding:8px">
        <form method="post" id="frmData">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_form_dialog($('#frmData').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_dialog();">Batal</button>
            </div>
            </br>
            <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
                <tr>
                    <td width='14%'>Penyelenggara Pelatihan</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="30" maxlength="30" name="penyelenggara" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('penyelenggara')=="" && isset($penyelenggara)){
    								 	echo $penyelenggara;
    								}else{
    									echo  set_value('penyelenggara');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Tempat Penyelenggaraan</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="30" maxlength="30" name="tempat" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('tempat')=="" && isset($tempat)){
    								 	echo $tempat;
    								}else{
    									echo  set_value('tempat');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Tanggal Pelaksanaan</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <div id='tgl'></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                 <tr>
                    <td colspan="3">Penanggung Jawab</td>
                </tr>
                <tr>
                    <td width='14%'>Tempat</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="30" maxlength="30" name="ttd_tmpt" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('ttd_tmpt')=="" && isset($ttd_tmpt)){
    								 	echo $ttd_tmpt;
    								}else{
    									echo  set_value('ttd_tmpt');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Tanggal</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <div id='ttd_tgl'></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td width='14%'>Nama</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="ttd_nama" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('ttd_nama')=="" && isset($ttd_nama)){
    								 	echo $ttd_nama;
    								}else{
    									echo  set_value('ttd_nama');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>NIP</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="30" maxlength="30" name="ttd_nip" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('ttd_nip')=="" && isset($ttd_nip)){
    								 	echo $ttd_nip;
    								}else{
    									echo  set_value('ttd_nip');
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