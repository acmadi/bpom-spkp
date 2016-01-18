<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
		$("input[name='nama']").jqxInput({ theme: 'fresh', height: '22px', width: '225px' }); 
        $("input[name='nisn']").jqxInput({ theme: 'fresh', height: '22px', width: '150px' });
		$("input[name='intervensi']").jqxInput({ theme: 'fresh', height: '22px', width: '175px' });
		$("input[name='petugas']").jqxInput({ theme: 'fresh', height: '22px', width: '200px' });
		$("input[name='institusi']").jqxInput({ theme: 'fresh', height: '22px', width: '325px' });
		$("input[name='kegiatan']").jqxInput({ theme: 'fresh', height: '22px', width: '325px' });
    });
    
    function save_add_sdmi_dialog(content){
		$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a023/doadd_sdmi",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_sdmi_dialog();
					 $('#refreshdatabuttonsdmi').click();
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
	
	function save_edit_sdmi_dialog(content){
	   	$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a023/doedit_sdmi",
			data: content,
			success: function(response){
				 if(response=="1"){
					 close_sdmi_dialog();
					 $('#refreshdatabuttonsdmi').click();
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
<div style="display: none;" id="divLoadsdmi"></div>
    <div id="divFormsdmi" style="padding:8px">
        <form method="post" id="frmDatasdmi">
            <div style="background: #F4F4F4;padding: 5px;text-align: right;">
                <span id="show-time" style="display: none;"></span>
                <span style="float: left;padding: 5px;display: none;color: green;" id="msg"></span>
                <button type="button" onclick="save_{action}_sdmi_dialog($('#frmDatasdmi').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_sdmi_dialog();">Batal</button>
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
                    <td>Petugas</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="30" maxlength="50" name="petugas" value="<?php if(set_value('petugas')=="" && isset($petugas)){
								 	echo $petugas;
								}else{
									echo  set_value('petugas');
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