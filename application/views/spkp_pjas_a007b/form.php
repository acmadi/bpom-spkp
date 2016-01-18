<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
		$("input[name='ttd_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '300px' });
		$("input[name='ttd_nip']").jqxMaskedInput({ theme: theme, height: '22px', width: '175px', mask: '######## ###### # ###' });
		$("input[name='ttd_tmpt']").jqxInput({ theme: 'fresh', height: '22px', width: '150px' });
		$('#ttd_tgl, #kegiatan_tgl').jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd'});
        $("input[name='kegiatan_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '300px' });
		$("input[name='kegiatan_tmpt']").jqxInput({ theme: 'fresh', height: '22px', width: '150px' });
		$("input[name='kegiatan_penyelenggara']").jqxInput({ theme: 'fresh', height: '22px', width: '220px' });
	});
	
    function add_kegiatan_dialog(content){
		$.ajax({ 
			type: "POST",
			url: "<?php echo base_url()?>index.php/spkp_pjas_a007b/doadd",
			data: content,
			success: function(response){
			var data = response.split("_");
				 if(data[0]=="1"){
					window.location.href = "<?php echo base_url(); ?>spkp_pjas_a007b/edit/"+data[1];
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
                <button type="button" onclick="add_kegiatan_dialog($('#frmData').serialize());">Simpan</button>
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
					<td width='25%'>Balai</td>
					<td width='3%' align='middle'>:</td>
					<td width='50%'>
						<select size="1" class="input" name="id_balai" id="id_balai" style="width: 200px;margin: 0;">
						<?php
						$balai = $this->spkp_pjas_a007b_model->get_all_balai();
						foreach($balai as $row_balai){
						?>
						   <option value="<?php echo $row_balai->id_balai; ?>" <?php if($row_balai->id_balai==$balai) echo " Selected"; ?>><?php echo $row_balai->nama_balai; ?></option>
						<?php
						}
						?>
						</select> *
					</td>
				</tr>
				<tr>
					<td>Nama Kegiatan</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="80" maxlength="100" name="kegiatan_nama"/> *
                    </td> 
				</tr>
				<tr>
                    <td>Tanggal Kegiatan</td>
                    <td align='middle'>:</td>
                    <td>
						<div id="kegiatan_tgl"></div>
                    </td>
                </tr>
				<tr>
					<td>Tempat Kegiatan</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="80" maxlength="100" name="kegiatan_tmpt"/> *
                    </td>
				</tr>
				<tr>
					<td>Instansi Penyelenggara</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="80" maxlength="100" name="kegiatan_penyelenggara"/> *
                    </td>
				</tr>
				<tr>
					<td colspan='2'><br>PENANGGUNG JAWAB :</td>
				</tr>
				<tr>
					<td>Tempat TTD</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="80" maxlength="100" name="ttd_tmpt"/> 
                    </td>
				</tr>
				<tr>
                    <td>Tanggal TTD</td>
                    <td align='middle'>:</td>
                    <td>
						<div id="ttd_tgl"></div>
                    </td>
                </tr>
				<tr>
					<td>Nama</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="80" maxlength="100" name="ttd_nama"/> *
                    </td>
				</tr>
				<tr>
					<td>NIP</td>
                    <td align='middle'>:</td>
                    <td>
                        <input type="text" size="20" maxlength="50" name="ttd_nip"/> 
                    </td>
				</tr>
            </table>
        </form>
    </div>
</div>