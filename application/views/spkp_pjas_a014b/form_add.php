<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("input[name='penanggungjawab_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='penanggungjawab_nip']").jqxInput({ theme: 'fresh', height: '22px', width: '130px' }); 
        $("input[name='tempat']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("#tanggal").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme});
    });
</script>
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
                    <td width='14%'>Balai</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <select size="1" name="id_balai" style="width: 230px;">
                            <?php
                            $data_balai = $this->spkp_pjas_a014b_model->get_all_balai();
                            if(set_value('id_balai')=="" && isset($id_balai)){
                                foreach($data_balai as $row_balai){
                                ?>
                                <option value="<?php echo $row_balai->id_balai; ?>" <?php if($row_balai->id_balai==$id_balai) echo "Selected";  ?>><?php echo $row_balai->nama_balai; ?></option>
                                <?php
                                }
                            }else{
                                foreach($data_balai as $row_balai){
                                ?>
                                <option value="<?php echo $row_balai->id_balai; ?>"><?php echo $row_balai->nama_balai; ?></option>
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