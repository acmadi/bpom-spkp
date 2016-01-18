<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
		$("input[name='nama']").jqxInput({ theme: 'fresh', height: '22px', width: '200px' });
    });
    
    function save_add_petugas_dialog(content){
		$.ajax({ 
			type: "POST",
			data: content,
			url: "<?php echo base_url()?>index.php/spkp_pjas_a007b/doadd_petugas",
			success: function(response){
				 if(response=="1"){
					 close_petugas_dialog();
					 $('#refreshdatabuttonpetugas').click();
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
<div style="display: none;" id="divLoadpetugas"></div>
    <div id="divFormpetugas" style="padding:8px">
        <form method="post" id="frmDatapetugas">
            <div style="background: #F4F4F4;padding: 5px;text-align: right;">
                <span id="show-time" style="display: none;"></span>
                <span style="float: left;padding: 5px;display: none;color: green;" id="msg"></span>
                <button type="button" onclick="save_add_petugas_dialog($('#frmDatapetugas').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_petugas_dialog();">Batal</button>
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
                    <td>ID Peserta</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="10" maxlength="15" name="id_petugas" value="<?php if(set_value('id_petugas')=="" && isset($id_petugas)){
							echo $id_petugas;
						}else{
							echo time();
						}?>" readonly=""/>
                    </td>
                </tr>
                <tr>
                    <td width='30%'>Nama Petugas</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="30" maxlength="50" name="nama" value="<?php if(set_value('nama')=="" && isset($nama)){
							echo $nama;
						}else{
							echo  set_value('nama');
						}?>" /> *
                    </td> 
                </tr>
            </table>
        </form>
    </div>
</div>