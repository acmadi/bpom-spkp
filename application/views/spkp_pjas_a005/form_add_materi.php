<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("input[name='nama']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='instansi']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
    });
</script>
<div style="display: none;" id="divLoad"></div>
    <div id="divForm" style="padding:8px">
        <form method="post" id="frmDataMateri">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_materi_dialog($('#frmDataMateri').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_dialog_materi();">Batal</button>
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
                        <input type="text" size="10" maxlength="10" name="id_narasumber" style="margin: 0;width: 50px;" value="{id_narasumber}" readonly=""/>
                        <?php
                       }
                       ?>
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Nama</td>
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
                    <td width='14%' valign='top'>Materi</td>
                    <td width='3%' valign='top' align='middle'>:</td>
                    <td width='50%'>
                                <?php 
								if(set_value('materi')=="" && isset($materi)){
								    $val = $materi;
								}else{
									$val = set_value('materi');
								}
								 ?>
                         <textarea cols="35" rows="10" wrap="virtual" name="materi" style="width: 350px;"><?php echo $val; ?></textarea>
                         <span style="vertical-align: top">*</span>        
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
            </table>
        </form>
    </div>
</div>