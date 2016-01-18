<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("input[name='jenis']").jqxInput({ theme: 'fresh', height: '22px', width: '180px' }); 
        $("input[name='media']").jqxInput({ theme: 'fresh', height: '22px', width: '180px' }); 
        $("input[name='kegiatan']").jqxInput({ theme: 'fresh', height: '22px', width: '180px' }); 
        
        <?php if($action=="edit"){ ?>
            $("#tgl").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme, value : '{tgl}'});
        <?php }else{ ?>
            $("#tgl").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme});
        <?php } ?>
        
    });
</script>
<div style="display: none;" id="divLoad"></div>
    <div id="divForm" style="padding:8px">
        <form method="post" id="frmDataPelaksanaan">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_pelaksanaan_dialog($('#frmDataPelaksanaan').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_dialog_pelaksanaan();">Batal</button>
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
                        <input type="text" size="10" maxlength="10" name="id_pelaksanaan" style="margin: 0;width: 50px;" value="{id_pelaksanaan}" readonly=""/>
                        <?php
                       }
                       ?>
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Tanggal</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <div id='tgl'></div>
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Jenis KIE</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="30" maxlength="30" name="jenis" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('jenis')=="" && isset($jenis)){
    								 	echo $jenis;
    								}else{
    									echo  set_value('jenis');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Media KIE</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="30" maxlength="30" name="media" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('media')=="" && isset($media)){
    								 	echo $media;
    								}else{
    									echo  set_value('media');
    								}
    								 ?>"/> 
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Nama Kegiatan</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="30" maxlength="30" name="kegiatan" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('kegiatan')=="" && isset($kegiatan)){
    								 	echo $kegiatan;
    								}else{
    									echo  set_value('kegiatan');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%' valign='top'>Evaluasi</td>
                    <td width='3%' align='middle' valign='top'>:</td>
                    <td width='50%'>
                                   <?php 
    								if(set_value('evaluasi')=="" && isset($evaluasi)){
    								 	$val = $evaluasi;
    								}else{
    									$val = set_value('evaluasi');
    								}
    								 ?>
                                     <textarea cols="40" rows="4" wrap="virtual" maxlength="100" name="evaluasi" style="width: 300px;"><?php echo $val; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
            </table>
        </form>
    </div>
</div>