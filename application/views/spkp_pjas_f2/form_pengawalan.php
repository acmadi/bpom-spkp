<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
		$("input[name='nama']").jqxInput({ theme: 'fresh', height: '22px', width: '225px' }); 
        $("input[name='nisn']").jqxInput({ theme: 'fresh', height: '22px', width: '150px' });
		$("input[name='fasilitator']").jqxInput({ theme: 'fresh', height: '22px', width: '200px' });
		$("input[name='intervensi']").jqxInput({ theme: 'fresh', height: '22px', width: '325px' });
		$("input[name='kegiatan']").jqxInput({ theme: 'fresh', height: '22px', width: '325px' });
    });
    
    function save_add_pengawalan_dialog(content){
		$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_f2/doadd_pengawalan",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_pengawalan_dialog();
					 $('#refreshdatabuttonpengawalan').click();
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
	
	function save_edit_pengawalan_dialog(content){
	   	$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_f2/doedit_pengawalan",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_pengawalan_dialog();
					 $('#refreshdatabuttonpengawalan').click();
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
<div style="display: none;" id="divLoadpengawalan"></div>
    <div id="divFormpengawalan" style="padding:8px">
        <form method="post" id="frmDatapengawalan">
            <div style="background: #F4F4F4;padding: 5px;text-align: right;">
                <span id="show-time" style="display: none;"></span>
                <span style="float: left;padding: 5px;display: none;color: green;" id="msg"></span>
                <button type="button" onclick="save_{action}_pengawalan_dialog($('#frmDatapengawalan').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_pengawalan_dialog();">Batal</button>
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
                    <td>ID SDMI</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="10" maxlength="15" name="id_sdmi" value="<?php if(set_value('id_sdmi')=="" && isset($id_sdmi)){
							echo $id_sdmi;
						}else{
							echo time();
						}?>" readonly=""/>
                    </td>
                </tr>
                <tr>
                    <td width='10%'>Nama SD/MI</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="30" maxlength="50" name="nama" value="<?php if(set_value('nama')=="" && isset($nama)){
								 	echo $nama;
								}else{
									echo  set_value('nama');
								}?>" />*
                    </td> 
                </tr>
				<tr>
                    <td>NISN</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="30" maxlength="50" name="nisn" value="<?php if(set_value('nisn')=="" && isset($nisn)){
								 	echo $nisn;
								}else{
									echo  set_value('nisn');
								}?>" />
                    </td> 
                </tr>
				<tr>
                    <td>Fasilitator</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="30" maxlength="50" name="fasilitator" value="<?php if(set_value('fasilitator')=="" && isset($fasilitator)){
								 	echo $fasilitator;
								}else{
									echo  set_value('fasilitator');
								}?>" />
                    </td> 
                </tr>
				<tr>
                    <td>Intervensi</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="30" maxlength="50" name="intervensi" value="<?php if(set_value('intervensi')=="" && isset($intervensi)){
								 	echo $intervensi;
								}else{
									echo  set_value('intervensi');
								}?>" />
                    </td> 
                </tr>
				<tr>
                    <td>Institusi</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="30" maxlength="50" name="institusi" value="<?php if(set_value('institusi')=="" && isset($institusi)){
								 	echo $institusi;
								}else{
									echo  set_value('institusi');
								}?>" />
                    </td> 
                </tr>
				<tr>
                    <td>Kegiatan</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="30" maxlength="50" name="kegiatan" value="<?php if(set_value('kegiatan')=="" && isset($kegiatan)){
								 	echo $kegiatan;
								}else{
									echo  set_value('kegiatan');
								}?>" />*
                    </td> 
                </tr>
            </table>
        </form>
    </div>
</div>