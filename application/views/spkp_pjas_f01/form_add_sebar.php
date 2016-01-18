<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
		$('#tanggal').jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme });
        $("input[name='penanggungjawab_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '225px' }); 
        $("input[name='penanggungjawab_nip']").jqxInput({ theme: 'fresh', height: '22px', width: '175px' });
		$("input[name='tmpt']").jqxInput({ theme: 'fresh', height: '22px', width: '150px' });		
	});
	
	function save_add_sebar_dialog(content){
		$.ajax({
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_f01/doadd_sebar",
			data: content,
			success: function(response){
				 var data = response.split("_");
				 if(data[0]=="1"){
					window.location.href = "<?php echo base_url(); ?>spkp_pjas_f01/edit_sebar/"+data[1];
				   
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
<div style="display: none;" id="divLoad"></div>
    <div id="divForm" style="padding:8px">
        <form method="post" id="frmDataSebar">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_sebar_dialog($('#frmDataSebar').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_dialog();">Batal</button>
            </div>
            </br>
            <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
				<tr style="display: none;">
						<td width='10%'>ID</td>
						<td width='3%' align='middle'>:</td>
						<td>
							<input type="text" size="10" maxlength="15" name="id" style="margin: 0;width: 50px;" value="<?php $id= time(); echo $id;?>" readonly=""/>
						</td>
					</tr>
				<tr valign="top">
                    <td width='40%'>Tanggal</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
						<div id="tanggal"></div>
                    </td>
                </tr>
				<tr><td>Penanggung Jawab</td></tr>
                <tr>
                    <td width='40%'>Nama</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="20" maxlength="100" name="penanggungjawab_nama"/> *
                    </td>
                </tr>
                <tr>
                    <td width='40%'>NIP</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="80" maxlength="200" name="penanggungjawab_nip"/> *
                    </td>
                </tr>
				<tr>
                    <td width='40%'>Tempat (Pembuatan Laporan)</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="80" maxlength="200" name="tmpt"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>