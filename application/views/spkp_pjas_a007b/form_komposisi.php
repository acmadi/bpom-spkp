<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '50px' });
		$("input[name='jml_kepsek']").jqxInput({ theme: 'fresh', height: '22px', width: '50px' });
		$("input[name='jml_guru']").jqxInput({ theme: 'fresh', height: '22px', width: '50px' });
		$("input[name='jml_kantin']").jqxInput({ theme: 'fresh', height: '22px', width: '50px' });
		$("input[name='jml_pedagang']").jqxInput({ theme: 'fresh', height: '22px', width: '50px' });
		$("input[name='jml_komite']").jqxInput({ theme: 'fresh', height: '22px', width: '50px' });
		$("input[name='jml_siswa']").jqxInput({ theme: 'fresh', height: '22px', width: '50px' });
		
    $(document).ready(function() {
		$("input").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ( $.inArray(event.keyCode,[46,8,9,27,13,190]) !== -1 ||
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
		});
	});   
});
	function save_edit_komposisi_dialog(content){
		$.ajax({ 
			type: "POST",
			data: content,
			url: "<?php echo base_url()?>index.php/spkp_pjas_a007b/doedit_komposisi",
			success: function(response){
				 if(response=="1"){
					 close_komposisi_dialog();
					 $("#jqxgridkomposisi").jqxGrid('updatebounddata', 'cells');
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
<div style="display: none;" id="divLoadkomposisi"></div>
    <div id="divFormkomposisi" style="padding:8px">
        <form method="post" id="frmDatakomposisi">
            <div style="background: #F4F4F4;padding: 5px;text-align: right;">
                <span id="show-time" style="display: none;"></span>
                <span style="float: left;padding: 5px;display: none;color: green;" id="msg"></span>
                <button type="button" onclick="save_edit_komposisi_dialog($('#frmDatakomposisi').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_komposisi_dialog();">Batal</button>
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
                <tr>
                    <td width='65%'>Jumlah Kepsek</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="50" maxlength="100" name="jml_kepsek" value="<?php if(set_value('jml_kepsek')=="" && isset($jml_kepsek)){
							echo $jml_kepsek;
						}else{
							echo  set_value('jml_kepsek');
						}?>" /> *
                    </td> 
                </tr>
				<tr>
                    <td>Jumlah Guru</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="50" maxlength="100" name="jml_guru" value="<?php if(set_value('jml_guru')=="" && isset($jml_guru)){
							echo $jml_guru;
						}else{
							echo  set_value('jml_guru');
						}?>" /> *
                    </td> 
                </tr>
				<tr>
                    <td>Jumlah Pengelola Kantin</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="50" maxlength="100" name="jml_kantin" value="<?php if(set_value('jml_kantin')=="" && isset($jml_kantin)){
							echo $jml_kantin;
						}else{
							echo  set_value('jml_kantin');
						}?>" /> *
                    </td> 
                </tr>
				<tr>
                    <td>Jumlah Pedagang PJAS</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="50" maxlength="100" name="jml_pedagang" value="<?php if(set_value('jml_pedagang')=="" && isset($jml_pedagang)){
							echo $jml_pedagang;
						}else{
							echo  set_value('jml_pedagang');
						}?>" /> *
                    </td> 
                </tr>
				<tr>
                    <td>Jumlah Komite Sekolah</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="50" maxlength="100" name="jml_komite" value="<?php if(set_value('jml_komite')=="" && isset($jml_komite)){
							echo $jml_komite;
						}else{
							echo  set_value('jml_komite');
						}?>" /> *
                    </td> 
                </tr>
				<tr>
                    <td>Jumlah Siswa</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="50" maxlength="100" name="jml_siswa" value="<?php if(set_value('jml_siswa')=="" && isset($jml_siswa)){
							echo $jml_siswa;
						}else{
							echo  set_value('jml_siswa');
						}?>" /> *
                    </td> 
                </tr>
            </table>
        </form>
    </div>