<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
		$("input[name='materi']").jqxInput({ theme: 'fresh', height: '22px', width: '200px' });
    });
    
    function save_add_materi_dialog(content){
		$.ajax({ 
			type: "POST",
			data: content,
			url: "<?php echo base_url()?>index.php/spkp_pjas_a007b/doadd_materi",
			success: function(response){
				 if(response=="1"){
					 close_materi_dialog();
					 $('#refreshdatabuttonmateri').click();
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
<div style="display: none;" id="divLoadmateri"></div>
    <div id="divFormmateri" style="padding:8px">
        <form method="post" id="frmDatamateri">
            <div style="background: #F4F4F4;padding: 5px;text-align: right;">
                <span id="show-time" style="display: none;"></span>
                <span style="float: left;padding: 5px;display: none;color: green;" id="msg"></span>
                <button type="button" onclick="save_add_materi_dialog($('#frmDatamateri').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_materi_dialog();">Batal</button>
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
                        <input type="text" size="10" maxlength="15" name="id_materi" value="<?php if(set_value('id_materi')=="" && isset($id_materi)){
							echo $id_materi;
						}else{
							echo time();
						}?>" readonly=""/>
                    </td>
                </tr>
                <tr>
                    <td width='30%'>Materi</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="30" maxlength="50" name="materi" value="<?php if(set_value('materi')=="" && isset($materi)){
							echo $materi;
						}else{
							echo  set_value('materi');
						}?>" /> *
                    </td> 
                </tr>
            </table>
        </form>
    </div>
</div>