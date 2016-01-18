<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("input[name='indikator']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='target']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='waktu']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='sumber_dana']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
    });
</script>
<div style="display: none;" id="divLoad"></div>
    <div id="divForm" style="padding:8px">
        <form method="post" id="frmDataKegiatan">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_kegiatan_dialog($('#frmDataKegiatan').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_dialog_kegiatan();">Batal</button>
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
                        <input type="text" size="10" maxlength="10" name="id_kegiatan" style="margin: 0;width: 50px;" value="{id_kegiatan}" readonly=""/>
                        <?php
                       }
                       ?>
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Propinsi</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <select size="1" name="propinsi" style="width: 230px;margin: 0;">
                        <?php
                         $data_propinsi = $this->spkp_pjas_a001_model->get_all_propinsi();
                         if(set_value('propinsi')=="" && isset($propinsi)){
                            foreach($data_propinsi as $row_propinsi){
                                ?>
                                    <option value="<?php echo $row_propinsi->id_propinsi; ?>" <?php if($row_propinsi->id_propinsi==$propinsi) echo "Selected";  ?>><?php echo ucwords(strtolower($row_propinsi->nama_propinsi)); ?></option>
                                <?php
                                }
                         }else{
                            foreach($data_propinsi as $row_propinsi){
                                ?>
                                    <option value="<?php echo $row_propinsi->id_propinsi; ?>" <?php if($row_propinsi->id_propinsi=="31") echo "Selected";  ?>><?php echo ucwords(strtolower($row_propinsi->nama_propinsi)); ?></option>
                                <?php
                                }
                            }
                        ?>
                        </select>
                        <span style="vertical-align: top">*</span>   
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Tahun</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <select size="1" name="tahun" style="width: 85px;height:25px;padding:2px;margin: 0;">
                                <?php
                                if(set_value('tahun')=="" && isset($tahun)){
                                    for($x=intval(date('Y'));$x>=intval(date('Y'))-5;$x--){
                                    ?>
                                    <option value="<?php echo $x; ?>" <?php if($x==$tahun) echo "Selected"; ?>><?php echo $x; ?></option>
                                    <?php
                                    }
                                }else{
                                    for($x=intval(date('Y'));$x>=intval(date('Y'))-5;$x--){
                                        ?>
                                        <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                         </select>  *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Program</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <select size="1" name="program" style="width: 300px;margin: 0;">
                            <?php
                            $data_program = $this->spkp_pjas_a001_model->get_all_program();
                            if(set_value('program')=="" && isset($program)){
                                foreach($data_program as $row_program){
                                ?>
                                    <option value="<?php echo $row_program->id_program; ?>" <?php if($row_program->id_program==$program) echo "Selected";  ?>><?php echo $row_program->nama; ?></option>
                                <?php
                                }
                            }else{
                                foreach($data_program as $row_program){
                                ?>
                                    <option value="<?php echo $row_program->id_program; ?>"><?php echo $row_program->nama; ?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                        <span style="vertical-align: top">*</span>   
                    </td>
                </tr>
                <tr>
                    <td width='14%' valign='top'>Kegiatan</td>
                    <td width='3%' valign='top' align='middle'>:</td>
                    <td width='50%'>
                                <?php 
								if(set_value('nama')=="" && isset($nama)){
								    $val_nama = $nama;
								}else{
									$val_nama = set_value('nama');
								}
								 ?>
                         <textarea cols="35" rows="3" wrap="virtual" maxlength="200" name="nama" style="width: 300px;"><?php echo $val_nama; ?></textarea>
                         <span style="vertical-align: top">*</span>        
                    </td>
                </tr>
                <tr>
                    <td width='14%' valign='top'>Instansi</td>
                    <td width='3%' valign='top' align='middle'>:</td>
                    <td width='50%'>
                                <?php 
								if(set_value('instansi')=="" && isset($instansi)){
								    $val_instansi = $instansi;
								}else{
									$val_instansi = set_value('instansi');
								}
								 ?>
                         <textarea cols="35" rows="3" wrap="virtual" maxlength="100" name="instansi" style="width: 300px;"><?php echo $val_instansi; ?></textarea>
                         <span style="vertical-align: top">*</span>        
                    </td>
                </tr>
                <tr>
                    <td width='14%' valign='top'>Indikator</td>
                    <td width='3%' valign='top' align='middle'>:</td>
                    <td width='50%'>
                         <input type="text" size="80" maxlength="150" name="indikator" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('indikator')=="" && isset($indikator)){
    								 	echo $indikator;
    								}else{
    									echo  set_value('indikator');
    								}
    								 ?>"/>
                    </td>
                </tr>
                <tr>
                    <td width='14%' valign='top'>Target</td>
                    <td width='3%' valign='top' align='middle'>:</td>
                    <td width='50%'>
                         <input type="text" size="80" maxlength="100" name="target" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('target')=="" && isset($target)){
    								 	echo $target;
    								}else{
    									echo  set_value('target');
    								}
    								 ?>"/>
                    </td>
                </tr>
                <tr>
                    <td width='14%' valign='top'>Waktu Pelaksanaan</td>
                    <td width='3%' valign='top' align='middle'>:</td>
                    <td width='50%'>
                          <input type="text" size="80" maxlength="50" name="waktu" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('waktu')=="" && isset($waktu)){
    								 	echo $waktu;
    								}else{
    									echo  set_value('waktu');
    								}
    								 ?>"/>   
                    </td>
                </tr>
                <tr>
                    <td width='14%' valign='top'>Sumber Dana</td>
                    <td width='3%' valign='top' align='middle'>:</td>
                    <td width='50%'>
                         <input type="text" size="80" maxlength="50" name="sumber_dana" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('sumber_dana')=="" && isset($sumber_dana)){
    								 	echo $sumber_dana;
    								}else{
    									echo  set_value('sumber_dana');
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