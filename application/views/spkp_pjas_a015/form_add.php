<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("input[name='penanggungjawab_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='penanggungjawab_nip']").jqxInput({ theme: 'fresh', height: '22px', width: '130px' }); 
        $("input[name='tempat']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("#tanggal").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme});
    });
</script>
<?php
?>
<div style="display: none;" id="divLoad"></div>
    <div id="divForm" style="padding:8px">
        <form method="post" id="frmData">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_form_dialog($('#frmData').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_dialog();">Batal</button>
            </div>
            </br>
            <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
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
                        </select> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Provinsi</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <select size="1" name="id_provinsi" id="id_provinsi" style="width: 300px;">
                            <?php
                            $data_propinsi = $this->spkp_pjas_a015_model->get_all_propinsi();
                                ?>
                                <option></option>
                                <?php
                            if(set_value('id_provinsi')=="" && isset($id_provinsi)){
                                foreach($data_propinsi as $row_propinsi){
                                ?>
                                <option value="<?php echo $row_propinsi->id_propinsi; ?>" <?php if($row_propinsi->id_propinsi==$id_provinsi) echo "Selected";  ?>><?php echo $row_propinsi->id_propinsi." - ".$row_propinsi->nama_propinsi; ?></option>
                                <?php
                                }
                            }else{
                                foreach($data_propinsi as $row_propinsi){
                                ?>
                                <option value="<?php echo $row_propinsi->id_propinsi; ?>"><?php echo $row_propinsi->id_propinsi." - ".$row_propinsi->nama_propinsi; ?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                        <span style="vertical-align: top">*</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                 <tr>
                    <td colspan="3">Penanggung Jawab</td>
                </tr>
                <tr>
                    <td width='14%'>Tempat</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="tempat" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('tempat')=="" && isset($tempat)){
    								 	echo $tempat;
    								}else{
    									echo  set_value('tempat');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Tanggal</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <div id='tanggal'></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td width='14%'>Nama</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="penanggungjawab_nama" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('penanggungjawab_nama')=="" && isset($penanggungjawab_nama)){
    								 	echo $penanggungjawab_nama;
    								}else{
    									echo  set_value('penanggungjawab_nama');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>NIP</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="20" maxlength="20" name="penanggungjawab_nip" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('penanggungjawab_nip')=="" && isset($penanggungjawab_nip)){
    								 	echo $penanggungjawab_nip;
    								}else{
    									echo  set_value('penanggungjawab_nip');
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