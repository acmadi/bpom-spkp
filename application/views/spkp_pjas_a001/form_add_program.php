<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
         
    });
</script>
<div style="display: none;" id="divLoad"></div>
    <div id="divForm" style="padding:8px">
        <form method="post" id="frmDataProgram">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_program_dialog($('#frmDataProgram').serialize());">Simpan</button>
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
                        <input type="text" size="10" maxlength="10" name="id_program" style="margin: 0;width: 50px;" value="{id_program}" readonly=""/>
                        <?php
                       }
                       ?>
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Strategi</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <select size="1" name="strategi" style="margin: 0;width: 300px;">
                            <?php
                            $data_strategi = $this->spkp_pjas_a001_model->get_all_strategi();
                            if(set_value('strategi')=="" && isset($strategi)){
                                foreach($data_strategi as $row_strategi){
                                ?>
                                    <option value="<?php echo $row_strategi->id_strategi; ?>" <?php if($row_strategi->id_strategi==$strategi) echo "Selected"; ?>><?php echo $row_strategi->nama; ?></option>
                                <?php
                                }
                            }else{
                                foreach($data_strategi as $row_strategi){
                                ?>
                                    <option value="<?php echo $row_strategi->id_strategi; ?>"><?php echo $row_strategi->nama; ?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                        <span style="vertical-align: top">*</span>   
                    </td>
                </tr>
                <tr>
                    <td width='14%' valign='top'>Nama</td>
                    <td width='3%' valign='top' align='middle'>:</td>
                    <td width='50%'>
                                <?php 
								if(set_value('nama')=="" && isset($nama)){
								    $val = $nama;
								}else{
									$val = set_value('nama');
								}
								 ?>
                         <textarea cols="35" rows="3" wrap="virtual" maxlength="150" name="nama" style="width: 300px;"><?php echo $val; ?></textarea>
                         <span style="vertical-align: top">*</span>        
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>