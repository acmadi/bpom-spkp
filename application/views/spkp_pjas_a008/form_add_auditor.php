<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("input[name='nama']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='nip']").jqxInput({ theme: 'fresh', height: '22px', width: '130px' }); 
        $("input[name='gol']").jqxInput({ theme: 'fresh', height: '22px', width: '70px' }); 
        $("input[name='jabatan']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='instansi']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        
        <?php if($action=="edit"){ ?>
            $("#tanggal_auditor").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme, value : '{tanggal}'});
        <?php }else{ ?>
            $("#tanggal_auditor").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme});
        <?php } ?>
        
    });
</script>
<div style="display: none;" id="divLoad"></div>
    <div id="divForm" style="padding:8px">
        <form method="post" id="frmDataAuditor">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_auditor_dialog($('#frmDataAuditor').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_dialog_auditor();">Batal</button>
            </div>
            </br>
            <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
                <tr style="display: none;">
                    <td width='14%'>ID</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                       <input type="text" size="10" maxlength="10" name="id" style="margin: 0;width: 50px;" value="{id}" readonly=""/>
                       <?php
                       if($action=="edit"){
                        ?>
                        <input type="text" size="10" maxlength="10" name="id_auditor" style="margin: 0;width: 50px;" value="{id_auditor}" readonly=""/>
                        <?php
                       }
                       ?>
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Nama</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="100" name="nama" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('nama')=="" && isset($nama)){
    								 	echo $nama;
    								}else{
    									echo  set_value('nama');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>NIP</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="20" maxlength="20" name="nip" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('nip')=="" && isset($nip)){
    								 	echo $nip;
    								}else{
    									echo  set_value('nip');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Golongan</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="10" maxlength="10" name="gol" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('gol')=="" && isset($gol)){
    								 	echo $gol;
    								}else{
    									echo  set_value('gol');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Jabatan</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="jabatan" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('jabatan')=="" && isset($jabatan)){
    								 	echo $jabatan;
    								}else{
    									echo  set_value('jabatan');
    								}
    								 ?>"/> 
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Instansi</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="instansi" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('instansi')=="" && isset($instansi)){
    								 	echo $instansi;
    								}else{
    									echo  set_value('instansi');
    								}
    								 ?>"/> 
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Tanggal</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <div id='tanggal_auditor'></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
            </table>
        </form>
    </div>
</div>