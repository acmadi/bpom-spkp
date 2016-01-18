<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("input[name='nama']").jqxInput({ theme: 'fresh', height: '22px', width: '220px' }); 
        $("input[name='keterangan']").jqxInput({ theme: 'fresh', height: '22px', width: '500px' }); 
	});
</script>
<div style="display: none;" id="divLoad"></div>
    <div id="divForm" style="padding:8px">
        <form method="post" id="frmDataKegiatan">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_kegiatan_dialog($('#frmDataKegiatan').serialize());">Simpan</button>
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
                        <input type="text" size="10" maxlength="15" name="id" style="margin: 0;width: 50px;" value="{id}" readonly=""/>
                        <?php
                       }
                       ?>
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Nama</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="20" maxlength="100" name="nama" value="<?php 
								if(set_value('nama')=="" && isset($nama)){
								 	echo $nama;
								}else{
									echo  set_value('nama');
								}
								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td>Tahun</td>
                    <td>:</td>
                    <td>
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
                    <td width='14%'>Keterangan</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="80" maxlength="200" name="keterangan" value="<?php 
								if(set_value('keterangan')=="" && isset($keterangan)){
								 	echo $keterangan;
								}else{
									echo  set_value('keterangan');
								}
								 ?>"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>