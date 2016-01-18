<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
		$("input[name='nama']").jqxInput({ theme: 'fresh', height: '22px', width: '250px' });
		$("input[name='instansi']").jqxInput({ theme: 'fresh', height: '22px', width: '300px' });
    });
    
    function save_add_pesertalintas_dialog(content){
		$.ajax({ 
			type: "POST",
			data: content,
			url: "<?php echo base_url()?>index.php/spkp_pjas_a007b/doadd_pesertalintas",
			success: function(response){
				 if(response=="1"){
					 close_pesertalintas_dialog();
					 $('#refreshdatabuttonpesertalintas').click();
					 $.notific8('Notification', {
					  life: 5000,
					  message: 'Save data succesfully.',
					  heading: 'Saving data',
					  theme: 'lime'
					});
				 }else{
					 $.notific8('Notification', {
					  life: 5000,
					  message: response,
					  heading: 'Saving data FAIL',
					  theme: 'red'
					});
				 }
			}
		 }); 		
	}
	
	function save_edit_pesertalintas_dialog(content){
		$.ajax({ 
			type: "POST",
			data: content,
			url: "<?php echo base_url()?>index.php/spkp_pjas_a007b/doedit_pesertalintas",
			success: function(response){
				 if(response=="1"){
					 close_pesertalintas_dialog();
					 $('#refreshdatabuttonpesertalintas').click();
					 $.notific8('Notification', {
					  life: 5000,
					  message: 'Save data succesfully.',
					  heading: 'Saving data',
					  theme: 'lime'
					});
				 }else{
					 $.notific8('Notification', {
					  life: 5000,
					  message: response,
					  heading: 'Saving data FAIL',
					  theme: 'red'
					});
				 }
			}
		 }); 		
	}
</script>
<div style="display: none;" id="divLoadpesertalintas"></div>
    <div id="divFormpesertalintas" style="padding:8px">
        <form method="post" id="frmDatapesertalintas">
            <div style="background: #F4F4F4;padding: 5px;text-align: right;">
                <span id="show-time" style="display: none;"></span>
                <span style="float: left;padding: 5px;display: none;color: green;" id="msg"></span>
                <button type="button" onclick="save_{action}_pesertalintas_dialog($('#frmDatapesertalintas').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_pesertalintas_dialog();">Batal</button>
            </div>
            </br>
            </br>
            <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
                <tr style="display: none;">
                    <td>ID</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="10" maxlength="15" name="id" value="<?php if(set_value('id')=="" && isset($id)){
							echo $id;
						}else{
							echo  set_value('id');
						}?>" readonly=""/>
                    </td>
                </tr>
				<tr style="display: none;">
                    <td>ID pesertalintas</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="10" maxlength="15" name="id_peserta" value="<?php if(set_value('id_peserta')=="" && isset($id_peserta)){
							echo $id_peserta;
						}else{
							echo time();
						}?>" readonly=""/>
                    </td>
                </tr>
                <tr>
                    <td width='30%'>Nama</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="50" maxlength="100" name="nama" value="<?php if(set_value('nama')=="" && isset($nama)){
							echo $nama;
						}else{
							echo  set_value('nama');
						}?>" /> *
                    </td> 
                </tr>
				<tr>
                    <td>Instansi</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="100" maxlength="200" name="instansi" value="<?php if(set_value('instansi')=="" && isset($instansi)){
							echo $instansi;
						}else{
							echo  set_value('instansi');
						}?>" /> *
                    </td> 
                </tr>
            </table>
        </form>
    </div>
</div>