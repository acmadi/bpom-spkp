<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("input[name='mengetahui_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='mengetahui_nip']").jqxInput({ theme: 'fresh', height: '22px', width: '130px' }); 
        $("input[name='pelapor_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='pelapor_nip']").jqxInput({ theme: 'fresh', height: '22px', width: '130px' }); 
        $("#tanggal").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme});
    });
</script>
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
                    <td colspan="3">Mengetahui</td>
                </tr>
                <tr>
                    <td width='14%'>Nama</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="mengetahui_nama" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('mengetahui_nama')=="" && isset($mengetahui_nama)){
    								 	echo $mengetahui_nama;
    								}else{
    									echo  set_value('mengetahui_nama');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>NIP</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="20" maxlength="20" name="mengetahui_nip" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('mengetahui_nip')=="" && isset($mengetahui_nip)){
    								 	echo $mengetahui_nip;
    								}else{
    									echo  set_value('mengetahui_nip');
    								}
    								 ?>"/> 
                    </td>
                </tr>
                 <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                 <tr>
                    <td colspan="3">Pelapor</td>
                </tr>
                <tr>
                    <td width='14%'>Nama</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="pelapor_nama" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('pelapor_nama')=="" && isset($pelapor_nama)){
    								 	echo $pelapor_nama;
    								}else{
    									echo  set_value('pelapor_nama');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>NIP</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="20" maxlength="20" name="pelapor_nip" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('pelapor_nip')=="" && isset($pelapor_nip)){
    								 	echo $pelapor_nip;
    								}else{
    									echo  set_value('pelapor_nip');
    								}
    								 ?>"/> 
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td width='14%'>Tanggal</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <div id='tanggal'></div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>