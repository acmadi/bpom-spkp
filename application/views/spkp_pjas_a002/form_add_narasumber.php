<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
		$("input[name='nama']").jqxInput({ theme: 'fresh', height: '22px', width: '225px' }); 
        $("input[name='materi']").jqxInput({ theme: 'fresh', height: '22px', width: '325px' });
    });
</script>
<div style="display: none;" id="divLoadJbtn"></div>
    <div id="divFormJbtn" style="padding:8px">
        <form method="post" id="frmDataNarasumber">
            <div style="background: #F4F4F4;padding: 5px;text-align: right;">
                <span id="show-time" style="display: none;"></span>
                <span style="float: left;padding: 5px;display: none;color: green;" id="msg"></span>
                <button type="button" onclick="save_{action}_narasumber_dialog($('#frmDataNarasumber').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_dialog();">Batal</button>
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
                        <input type="text" size="10" maxlength="15" name="id"" value="<?php if(set_value('id')=="" && isset($id)){
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
                    <td width='10%'>ID Narasumber</td>
                    <td width='3%' align='middle'>:</td>
                    <td>
                       <?php
                       if($action=="edit"){
                        ?>
                        <input type="text" size="10" maxlength="15" name="id_narasumber" value="<?php if(set_value('id_narasumber')=="" && isset($id_narasumber)){
								 	echo $id_narasumber;
								}else{
									echo  set_value('id_narasumber');
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
								}?>"/>*
                    </td> 
                </tr>
				<tr>
                    <td>Materi</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="30" maxlength="50" name="materi" value="<?php if(set_value('materi')=="" && isset($materi)){
								 	echo $materi;
								}else{
									echo  set_value('materi');
								}?>"/>*
                    </td> 
                </tr>
            </table>
        </form>
    </div>
</div>