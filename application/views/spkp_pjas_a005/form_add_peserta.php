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
        <form method="post" id="frmDataPeserta">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_peserta_dialog($('#frmDataPeserta').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_dialog_peserta();">Batal</button>
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
                        <input type="text" size="10" maxlength="10" name="id_peserta" style="margin: 0;width: 50px;" value="{id_peserta}" readonly=""/>
                        <?php
                       }
                       ?>
                    </td>
                </tr>
                <tr>
                    <td width='18%'>Nama</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="10" maxlength="50" name="nama" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('nama')=="" && isset($nama)){
    								 	echo $nama;
    								}else{
    									echo  set_value('nama');
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
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%' valign='top'>Hari</td>
                    <td width='3%' align='middle' valign='top'>:</td>
                    <td width='50%'>
                        <?php
                        $max = $this->spkp_pjas_a005_model->get_max_hari($id);
                        if($action=="edit"){
                            for($x=1;$x<=intval($max['max']);$x++){
                                $hari = $this->spkp_pjas_a005_model->get_hari($id,$id_peserta,$x);
                                $y="";
                                if($hari>0){
                                    $y = "checked='checked'";
                                }
                                ?>
                                <input type="checkbox" value="<?php echo $x; ?>" name="check_<?php echo $x; ?>" <?php echo $y; ?>/> 
                                <span style="padding: 10px;">Hari <?php echo $x; ?></span>
                                <br />
                                <br />
                                <?php
                            }    
                        }else{
                            for($x=1;$x<=intval($max['max']);$x++){
                                ?>
                                <input type="checkbox" value="<?php echo $x; ?>" name="check_<?php echo $x; ?>"/> 
                                <span style="padding: 10px;">Hari <?php echo $x; ?></span>
                                <br />
                                <br />
                            <?php
                            }
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
            </table>
        </form>
    </div>
</div>