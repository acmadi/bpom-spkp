<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("input[name='judul']").jqxInput({ theme: 'fresh', height: '22px', width: '300px' }); 
        $("input[name='tempat']").jqxInput({ theme: 'fresh', height: '22px', width: '220px' });
		$("textarea").jqxInput({ theme: theme, height: '29px', width: '320px', height:'100px' });
        $("input[name='penanggungjawab_nip']").jqxInput({ theme: 'fresh', height: '22px', width: '220px' });
		$("input[name='penanggungjawab_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '220px' });
		$('#tanggal').jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme });
	});
	
    function save_add_pertemuan_dialog(content){
		$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a002/doadd",
			data: content,
			success: function(response){
			var data = response.split("_");
				 if(data[0]=="1"){
					window.location.href = "<?php echo base_url(); ?>spkp_pjas_a002/edit/"+data[1];
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
        <form method="post" id="frmDataPertemuan">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_pertemuan_dialog($('#frmDataPertemuan').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_dialog();">Batal</button>
            </div>
            </br>
            <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
                <tr style="display: none;">
						<td>ID</td>
						<td>:</td>
						<td>
							<input type="text" size="10" maxlength="15" name="id" value="<?php $id=time(); echo $id; ?>" readonly=""/>
						</td>
					</tr>
				<tr valign="top">
                    <td width='35%'>Tanggal</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
						<div id="tanggal"></div>
                    </td>
                </tr>
                <tr>
                    <td>Pertemuan</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="20" maxlength="100" name="judul"/> *
                    </td>
                </tr>
                <tr>
                    <td>Tempat</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="80" maxlength="100" name="tempat"/> *
                    </td>
                </tr>
				<tr>
					<td>Hasil</td>
                    <td align='middle'>:</td>
                    <td>
                        <textarea id="hasil" name="hasil" class="input" wrap="virtual" rows="3" cols="65"></textarea> *
                    </td>
				</tr>
				<tr>
					<td colspan='2'>Penanggung Jawab</td>
				</tr>
				<tr>
					<td>Nama</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="80" maxlength="100" name="penanggungjawab_nama"/> *
                    </td>
				</tr>
				<tr>
					<td>NIP</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="80" maxlength="100" name="penanggungjawab_nip"/> *
                    </td>
				</tr>
            </table>
        </form>
    </div>
</div>