<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("input[name='parameter']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='kesimpulan']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
    });
</script>
<div style="display: none;" id="divLoad"></div>
    <div id="divForm" style="padding:8px">
        <form method="post" id="frmDataUji">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_uji_dialog($('#frmDataUji').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_dialog_uji();">Batal</button>
            </div>
            </br>
            <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
                <tr style="display: none;">
                    <td width='18%'>ID</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                       <input type="text" size="10" maxlength="10" name="id" style="margin: 0;width: 50px;" value="{id}" readonly=""/>
                       <input type="text" size="10" maxlength="10" name="id_hasil" style="margin: 0;width: 50px;" value="{id_hasil}" readonly=""/>
                       <?php
                       if($action=="edit"){
                        ?>
                        <input type="text" size="10" maxlength="10" name="id_parameter" style="margin: 0;width: 50px;" value="{id_parameter}" readonly=""/>
                        <?php
                       }
                       ?>
                    </td>
                </tr>
                <tr>
                    <td width='18%'>Parameter</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="parameter" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('parameter')=="" && isset($parameter)){
    								 	echo $parameter;
    								}else{
    									echo  set_value('parameter');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Hasil</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <select size="1" name="hasil" style="width: 100px;">
                            <?php
                            if(set_value('hasil')=="" && isset($hasil)){
                                ?>
                                <option value="Negatif" <?php if($hasil=="Negatif") echo "Selected";  ?>>Negatif</option>
                                <option value="Positif" <?php if($hasil=="Positif") echo "Selected";  ?>>Positif</option>
                                <?php
                            }else{
                                ?>
                                <option value="Negatif">Negatif</option>
                                <option value="Positif">Positif</option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Kesimpulan</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="kesimpulan" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('kesimpulan')=="" && isset($kesimpulan)){
    								 	echo $kesimpulan;
    								}else{
    									echo  set_value('kesimpulan');
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