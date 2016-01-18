<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
		$("input[name='penanggungjawab_jabatan']").jqxInput({ theme: 'fresh', height: '22px', width: '200px' });
        $("input[name='penanggungjawab_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '220px' });
		$("input[name='penanggungjawab_nip']").jqxMaskedInput({ theme: theme, height: '22px', width: '175px', mask: '######## ###### # ###' });
		$("input[name='tmpt']").jqxInput({ theme: 'fresh', height: '22px', width: '150px' });
		$('#tanggal').jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd'});
	});
	
    function save_add_rekap_dialog(content){
		$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_f2/doadd",
			data: content,
			success: function(response){
			var data = response.split("_");
				 if(data[0]=="1"){
					window.location.href = "<?php echo base_url(); ?>spkp_pjas_f2/edit/"+data[1];
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
        <form method="post" id="frmData">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_rekap_dialog($('#frmData').serialize());">Simpan</button>
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
				<tr>
					<td>Propinsi</td>
					<td align='middle'>:</td>
					<td>
						<select size="1" class="input" name="id_provinsi" id="id_provinsi" style="width: 250px;margin: 0;">
						<?php
						$propinsi = $this->spkp_pjas_f2_model->get_all_propinsi();
						foreach($propinsi as $row_propinsi){
						?>
						   <option value="<?php echo $row_propinsi->id_propinsi; ?>" <?php if($row_propinsi->id_propinsi==$propinsi) echo "Selected"; ?>><?php echo $row_propinsi->nama_propinsi; ?></option>
						<?php
						}
						?>
						</select> *
					</td>
				</tr>
				<tr>
				<td width='15%'>Balai</td>
				<td align='middle'>:</td>
				<td>
					<select size="1" class="input" name="id_balai" id="id_balai" style="width: 250px;margin: 0;">
					<?php
					$balai = $this->spkp_pjas_f2_model->get_all_balai();
					foreach($balai as $row_balai){
					?>
					   <option value="<?php echo $row_balai->id_balai; ?>" <?php if($row_balai->id_balai==$balai) echo "Selected"; ?>><?php echo $row_balai->nama_balai; ?></option>
					<?php
					}
					?>
					</select> *
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
					<td colspan='2'>Penanggung Jawab</td>
				</tr>
				<tr>
					<td>Jabatan</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="80" maxlength="100" name="penanggungjawab_jabatan"/> 
                    </td>
				</tr>
				<tr>
					<td>Nama</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="80" maxlength="100" name="penanggungjawab_nama"/> 
                    </td>
				</tr>
				<tr>
					<td>NIP</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="80" maxlength="100" name="penanggungjawab_nip"/> 
                    </td>
				</tr>
				<tr>
					<td>Tempat (Pembuatan Laporan)</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="80" maxlength="100" name="tmpt"/> 
                    </td>
				</tr>
            </table>
        </form>
    </div>
</div>