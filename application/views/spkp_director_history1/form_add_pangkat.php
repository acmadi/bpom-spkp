<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        <?php if($action=="add") { ?>
            $("#sk_jb_tgl_pangkat").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme });
            $("#tgl_mulai_pangkat").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme });
            $("#tgl_sampai_pangkat").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme });
        <?php }else{ ?>
            $("#sk_jb_tgl_pangkat").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme, value: '{sk_jb_tgl}'});
            $("#tgl_mulai_pangkat").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme, value: '{tgl_mulai}'});
            $("#tgl_sampai_pangkat").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme, value: '{tgl_sampai}'});
        <?php } ?>
    });
</script>
<div style="display: none;" id="divLoadPngkt"></div>
    <div id="divFormPngkt" style="padding:8px">
        <form method="post" id="frmDataPngkt">
            <div style="background: #F4F4F4;padding: 5px;text-align: right;">
                <span id="show-time" style="display: none;"></span>
                <span style="float: left;padding: 5px;display: none;color: green;" id="msg"></span>
                <button type="button" onclick="save_{action}_pangkat_dialog($('#frmDataPngkt').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_pangkat_dialog();">Batal</button>
            </div>
            </br>
            </br>
            <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
                <tr style="display: none;">
                    <td width='14%'>ID</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                       <?php
                       if($action=="edit"){
                        ?>
                        <input type="text" size="10" maxlength="15" name="id" style="margin: 0;width: 50px;" value="{id}" readonly=""/>
                        <?php
                       }
                       ?>
                    </td>
                </tr>
                <tr>
                    <td>Subdit</td>
                    <td align='middle'>:</td>
                    <td>
                        <select size="1" class="input" name="id_subdit_pangkat" id="id_subdit_pangkat" style="width: 315px;margin: 0;"> 
                            <option></option>
                            <?php
                            $data_subdit = $this->spkp_director_history_model->get_all_subdit();
                            if(set_value('id_subdit')=="" && isset($id_subdit)){
                                foreach($data_subdit as $row_subdit){
                                ?>
                                    <option value="<?php echo $row_subdit->id_subdit; ?>" <?php if($row_subdit->id_subdit==$id_subdit) echo "Selected"; ?>><?php echo $row_subdit->ket; ?></option>
                                <?php
                                }
                            }else{
                                foreach($data_subdit as $row_subdit){
                                ?>
                                    <option value="<?php echo $row_subdit->id_subdit; ?>"><?php echo $row_subdit->ket; ?></option>
                                <?php
                                }
                            }
                                ?>
                        </select> *)
                    </td>
                </tr>
                <tr>
                    <td>Golongan</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="10" maxlength="10" name="id_golruang_hide" style="margin: 0;display: none;" value="{id_golruang}"/>
                        <select size="1" class="input" name="id_golruang" style="width: 225px;margin: 0;">
                            <?php
                            $data_gol = $this->spkp_director_history_model->get_all_gol();
                            if(set_value('id_golruang')=="" && isset($id_golruang)){
                                foreach($data_gol as $row_gol){
                                ?>
                                    <option value="<?php echo $row_gol->id_golongan; ?>" <?php if($row_gol->id_golongan==$id_golruang) echo "Selected"; ?>><?php echo $row_gol->golongan." - ".$row_gol->jabatan; ?></option>
                                <?php
                                }
                            }else{
                                foreach($data_gol as $row_gol){
                                ?>
                                    <option value="<?php echo $row_gol->id_golongan; ?>"><?php echo $row_gol->golongan." - ".$row_gol->jabatan; ?></option>
                                <?php
                                }
                            }
                                ?>
                        </select> *)
                    </td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td align='middle'>:</td>
                    <td>
                        <select size="1" class="input" name="status" style="width: 90px;margin: 0;">
                            <?php
                            if(set_value('status')=="" && isset($status)){
                                ?>
                                <option value="CPNS" <?php if($status=="CPNS") echo "Selected"; ?>>CPNS</option>
                                <option value="PNS" <?php if($status=="PNS") echo "Selected"; ?>>PNS</option>
                                <option value="PHP" <?php if($status=="PHP") echo "Selected"; ?>>PHP</option>
                                <option value="PHL" <?php if($status=="PHL") echo "Selected"; ?>>PHL</option>
                                <?php
                            }else{
                                ?>
                                <option value="CPNS">CPNS</option>
                                <option value="PNS">PNS</option>
                                <option value="PHP">PHP</option>
                                <option value="PHL">PHL</option>
                                <?php
                            }
                            ?>
                            
                        </select> *)
                    </td>
                </tr>
                <tr>
                    <td>Tanggal SK</td>
                    <td align='middle'>:</td>
                    <td>
                        <div id='sk_jb_tgl_pangkat'></div> 
                    </td>
                </tr>
                <tr>
                    <td>Nomor SK</td>
                    <td align='middle'>:</td>
                    <td>
                        <input class=input type="text" size="20" maxlength="50" name="sk_jb_nomor" style="margin: 0;height: 30px;" value="<?php 
								if(set_value('sk_jb_nomor')=="" && isset($sk_jb_nomor)){
								 	echo $sk_jb_nomor;
								}else{
									echo  set_value('sk_jb_nomor');
								}
								 ?>"/> *)
                    </td>
                </tr>
                <tr>
                    <td>Pejabat</td>
                    <td align='middle'>:</td>
                    <td>
                        <input class=input type="text" size="20" maxlength="50" name="sk_jb_pejabat" style="margin: 0;height: 30px;" value="<?php 
								if(set_value('sk_jb_pejabat')=="" && isset($sk_jb_pejabat)){
								 	echo $sk_jb_pejabat;
								}else{
									echo  set_value('sk_jb_pejabat');
								}
								 ?>"/> *)
                    </td>
                </tr>
                <tr>
                    <td>Nomor Persetujuan</td>
                    <td align='middle'>:</td>
                    <td>
                        <input class=input type="text" size="20" maxlength="50" name="nomor_persetujuan" style="margin: 0;height: 30px;" value="<?php 
								if(set_value('nomor_persetujuan')=="" && isset($nomor_persetujuan)){
								 	echo $nomor_persetujuan;
								}else{
									echo  set_value('nomor_persetujuan');
								}
								 ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>Pendidikan Tertinggi</td>
                    <td align='middle'>:</td>
                    <td>
                        <input class=input type="text" size="20" maxlength="100" name="pddk_tertinggi" style="margin: 0;height: 30px;" value="<?php 
								if(set_value('pddk_tertinggi')=="" && isset($pddk_tertinggi)){
								 	echo $pddk_tertinggi;
								}else{
									echo  set_value('pddk_tertinggi');
								}
								 ?>"/> *)
                    </td>
                </tr>
                <tr>
                    <td>Uraian</td>
                    <td align='middle'>:</td>
                    <td>
                        <input class=input type="text" size="20" maxlength="50" name="uraian" style="margin: 0;height: 30px;" value="<?php 
								if(set_value('uraian')=="" && isset($uraian)){
								 	echo $uraian;
								}else{
									echo  set_value('uraian');
								}
								 ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Mulai</td>
                    <td align='middle'>:</td>
                    <td>
                        <div id='tgl_mulai_pangkat'></div> 
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Akhir</td>
                    <td align='middle'>:</td>
                    <td>
                        <div id='tgl_sampai_pangkat'></div> 
                    </td>
                </tr>
                <tr>
                    <td>Gaji Pokok</td>
                    <td align='middle'>:</td>
                    <td>
                        <input class=input type="text" size="20" maxlength="10" name="gapok_bulanan" style="margin: 0;height: 30px;" value="<?php 
								if(set_value('gapok_bulanan')=="" && isset($gapok_bulanan)){
								 	echo $gapok_bulanan;
								}else{
									echo  set_value('gapok_bulanan');
								}
								 ?>"/>
                    </td>
                </tr>
                <tr>
                    <td valign='top'>Keterangan</td>
                    <td valign='top' align='middle'>:</td>
                    <td>
                        <?php
                        if(set_value('ket')=="" && isset($ket)){
							$val = $ket;
						}else{
						    $val = set_value('ket');
						}
                        ?>
                        <textarea cols="65" rows="3" wrap="virtual" maxlength="100" name="ket"><?php echo $val; ?></textarea>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>