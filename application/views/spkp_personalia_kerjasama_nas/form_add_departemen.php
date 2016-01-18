<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("input[name='ket']").jqxInput({ theme: 'fresh', height: '22px', width: '500px' }); 
	});
</script>
<div style="display: none;" id="divLoad"></div>
    <div id="divForm" style="padding:8px">
        <form method="post" id="frmDataDepartemen">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_departemen_dialog($('#frmDataDepartemen').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_dialog();">Batal</button>
            </div>
            </br>
            <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
                <tr style="display: none;">
                    <td width='14%'>ID</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                       <?php
                       if($action=="edit"){
                        ?>
                        <input type="text" size="10" maxlength="15" name="id_departemen" style="margin: 0;width: 50px;" value="{id_departemen}" readonly=""/>
                        <?php
                       }
                       ?>
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Keterangan</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="80" maxlength="100" name="ket" value="<?php 
								if(set_value('ket')=="" && isset($ket)){
								 	echo $ket;
								}else{
									echo  set_value('ket');
								}
								 ?>"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>