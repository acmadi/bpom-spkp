<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("input[name='nama']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
    });
</script>
<div style="display: none;" id="divLoad"></div>
    <div id="divForm" style="padding:8px">
        <form method="post" id="frmDataSekolah">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_sekolah_dialog($('#frmDataSekolah').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_dialog_sekolah();">Batal</button>
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
                    <td width='14%'>Status</td>
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
                    <td width='14%' valign='top'>Akreditasi</td>
                    <td width='3%' valign='top' align='middle'>:</td>
                    <td width='50%'>
                        <select size="1" name="akreditasi" style="width: 100px;">
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
                    <td width='14%' valign='top'>Kantin</td>
                    <td width='3%' valign='top' align='middle'>:</td>
                    <td width='50%'>
                         <select size="1" name="kantin" style="width: 100px;">
                            <?php
                            if(set_value('kantin')=="" && isset($kantin)){
                                ?>
                                <option value="Ada" <?php if($kantin=="Ada") echo "Selected";  ?>>Ada</option>
                                <option value="Tidak" <?php if($kantin=="Tidak") echo "Selected";  ?>>Tidak</option>
                                <?php
                            }else{
                                ?>
                                <option value="Ada">Ada</option>
                                <option value="Tidak">Tidak</option>
                                <?php
                            }
                            ?>
                         </select>
                         <span style="vertical-align: top">*</span>   
                    </td>
                </tr>
                <tr>
                    <td width='14%' valign='top'>Internet</td>
                    <td width='3%' valign='top' align='middle'>:</td>
                    <td width='50%'>
                         <select size="1" name="internet" style="width: 100px;">
                            <?php
                            if(set_value('internet')=="" && isset($internet)){
                                ?>
                                <option value="Ada" <?php if($internet=="Ada") echo "Selected";  ?>>Ada</option>
                                <option value="Tidak" <?php if($internet=="Tidak") echo "Selected";  ?>>Tidak</option>
                                <?php
                            }else{
                                ?>
                                <option value="Ada">Ada</option>
                                <option value="Tidak">Tidak</option>
                                <?php
                            }
                            ?>
                         </select>   
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