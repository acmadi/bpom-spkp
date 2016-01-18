<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("input[name='nama']").jqxInput({ theme: 'fresh', height: '22px', width: '250px' });
        $("input[name='institusi']").jqxInput({ theme: 'fresh', height: '22px', width: '250px' });
        $("input[name='pre_test']").jqxInput({ theme: 'fresh', height: '22px', width: '150px' });
        $("input[name='post_test']").jqxInput({ theme: 'fresh', height: '22px', width: '150px' });
    });
</script>
<div style="display: none;" id="divLoad"></div>
    <div id="divForm" style="padding:8px">
        <form method="post" id="frmDataPeserta">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_peserta_dialog($('#frmDataPeserta').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_dialog_peserta();">Batal</button>
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
                        <input type="text" size="10" maxlength="10" name="id_peserta" style="margin: 0;width: 50px;" value="{id_peserta}" readonly=""/>
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
                    <td width='14%'>Institusi</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="institusi" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('institusi')=="" && isset($institusi)){
    								 	echo $institusi;
    								}else{
    									echo  set_value('institusi');
    								}
    								 ?>"/> 
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Pre test</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="10" maxlength="10" name="pre_test" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('pre_test')=="" && isset($pre_test)){
    								 	echo $pre_test;
    								}else{
    									echo  set_value('pre_test');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Post test</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="10" maxlength="10" name="post_test" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('post_test')=="" && isset($post_test)){
    								 	echo $post_test;
    								}else{
    									echo  set_value('post_test');
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