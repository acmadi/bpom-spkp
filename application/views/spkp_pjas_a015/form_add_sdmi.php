<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("input[name='nama']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='instansi']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
    });
</script>
<div style="display: none;" id="divLoad"></div>
    <div id="divForm" style="padding:8px">
        <form method="post" id="frmDataSDMI">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_sdmi_dialog($('#frmDataSDMI').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_dialog_sdmi();">Batal</button>
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
                        <input type="text" size="10" maxlength="10" name="id_sdmi" style="margin: 0;width: 50px;" value="{id_sdmi}" readonly=""/>
                        <?php
                       }
                       ?>
                    </td>
                </tr>
                <tr>
                    <td width='18%'>Nama Sekolah</td>
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
                    <td width='18%'>Status</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <select size="1" name="status" style="width: 100px;">
                            <?php
                            if(set_value('status')=="" && isset($status)){
                                ?>
                                <option value="Negeri" <?php if($status=="Negeri") echo "Selected";  ?>>Negeri</option>
                                <option value="Swasta" <?php if($status=="Swasta") echo "Selected";  ?>>Swasta</option>
                                <?php
                            }else{
                                ?>
                                <option value="Negeri">Negeri</option>
                                <option value="Swasta">Swasta</option>
                                <?php
                            }
                            ?>
                        </select>
                        <span style="vertical-align: top">*</span>
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Akreditasi</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <select size="1" name="akreditasi" style="width: 60px;">
                            <?php
                            if(set_value('akreditasi')=="" && isset($akreditasi)){
                                ?>
                                <option value="A" <?php if($akreditasi=="A") echo "Selected";  ?>>A</option>
                                <option value="B" <?php if($akreditasi=="B") echo "Selected";  ?>>B</option>
                                <option value="C" <?php if($akreditasi=="C") echo "Selected";  ?>>C</option>
                                <option value="TT" <?php if($akreditasi=="TT") echo "Selected";  ?>>TT</option>
                                <?php
                            }else{
                                ?>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="TT">TT</option>
                                <?php
                            }
                            ?>
                        </select>
                        <span style="vertical-align: top">*</span>
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Intervensi</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <select size="1" name="intervensi" style="width: 50px;">
                            <?php
                            if(set_value('intervensi')=="" && isset($intervensi)){
                                ?>
                                <option value="A" <?php if($intervensi=="A") echo "Selected";  ?>>A</option>
                                <option value="B" <?php if($intervensi=="B") echo "Selected";  ?>>B</option>
                                <option value="C" <?php if($intervensi=="C") echo "Selected";  ?>>C</option>
                                <?php
                            }else{
                                ?>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <?php
                            }
                            ?>
                        </select>
                        <span style="vertical-align: top">*</span>
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Instansi Pelaksana</td>
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
                    <td colspan="3">&nbsp;</td>
                </tr>
            </table>
        </form>
    </div>
</div>