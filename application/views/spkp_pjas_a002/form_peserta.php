<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
		$("input[name='nama']").jqxInput({ theme: 'fresh', height: '22px', width: '225px' }); 
        $("input[name='instansi']").jqxInput({ theme: 'fresh', height: '22px', width: '325px' });
    });
</script>
<div style="display: none;" id="divLoadPngkt"></div>
    <div id="divFormPngkt" style="padding:8px">
        <form method="post" id="frmDataPsrta">
            <div style="background: #F4F4F4;padding: 5px;text-align: right;">
                <span id="show-time" style="display: none;"></span>
                <span style="float: left;padding: 5px;display: none;color: green;" id="msg"></span>
                <button type="button" onclick="save_{action}_peserta_dialog($('#frmDataPsrta').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_pangkat_dialog();">Batal</button>
            </div>
            </br>
            </br>
            <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
                <tr style="display: none;">
                    <td width='10%'>ID</td>
                    <td width='3%' align='middle'>:</td>
                    <td>
                       <?php
                       if($action=="edit"){
                        ?>
                        <input type="text" size="10" maxlength="15" name="id" value="<?php if(set_value('id')=="" && isset($id)){
							echo $id;
						}else{
							echo  set_value('id');
						}?>" readonly=""/>
                        <?php
                       }
                       ?>
                    </td>
                </tr>
				<tr style="display: none;">
                    <td width='10%'>ID Peserta</td>
                    <td width='3%' align='middle'>:</td>
                    <td>
                       <?php
                       if($action=="edit"){
                        ?>
                        <input type="text" size="10" maxlength="15" name="id_peserta" value="<?php if(set_value('id_peserta')=="" && isset($id_peserta)){
							echo $id_peserta;
						}else{
							echo  set_value('id_peserta');
						}?>" readonly=""/>
                        <?php
                       }
                       ?>
                    </td>
                </tr>
                <tr>
                    <td width='5%'>Nama</td>
                    <td width='3%' align='middle'>:</td>
                    <td>
                        <input type="text" size="30" maxlength="50" name="nama" value="<?php if(set_value('nama')=="" && isset($nama)){
							echo $nama;
						}else{
							echo  set_value('nama');
						}?>" />*
                    </td> 
                </tr>
				<tr>
                    <td>Instansi</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="30" maxlength="50" name="instansi" value="<?php if(set_value('instansi')=="" && isset($instansi)){
							echo $instansi;
						}else{
							echo  set_value('instansi');
						}?>" />*
                    </td> 
                </tr>
            </table>
        </form>
    </div>
</div>