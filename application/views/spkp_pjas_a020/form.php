<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '30px', width: '100px' });
        $("input[name='ttd_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='ttd_nip']").jqxInput({ theme: 'fresh', height: '22px', width: '130px' }); 
        $("input[name='ttd_tmpt']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='penyelenggara']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='tempat']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='lokasi']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' });
        $("#ttd_tgl").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme, value: '{ttd_tgl}'});
        $("#tgl").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme, value: '{tgl}'});
    });
    
    function save_form(){
        $("#divForm").hide();
        $("#divLoadForm").css("display","block");
        $("#divLoadForm").html("<div style='text-align:center;margin-top: 70px'><br><br><br><br><img src='<?php echo base_url();?>media/images/loaderB64.gif' alt='loading content.. '><br>loading</div>");
             
        $.ajax({
           type: "POST",
           url: "<?php echo base_url(); ?>spkp_pjas_a020/doedit_form/{id}",
           data: $("#frmData").serialize(),
           success: function(response){
                if(response=="1"){
                   $.notific8('Notification', {
    				   life: 5000,
    				   message: 'Save data succesfully.',
    				   heading: 'Saving data',
    				   theme: 'lime'
    			   });
                   
                   $("#divLoadForm").css("display","none");
                   
                   $.ajax({
                     type: "POST",
                     url: "<?php echo base_url(); ?>spkp_pjas_a020/load_form/{id}",
                     success: function(response){
                        $("#divForm").show();
                        $("#divForm").html(response);
                     }
                   });
                }else{
                    $.notific8('Notification', {
					  life: 5000,
					  message: response,
                      heading: 'Saving data FAIL',
					  theme: 'red'
					});
                    
                    $("#divLoadForm").css("display","none");
                    
                    $.ajax({
                     type: "POST",
                     url: "<?php echo base_url(); ?>spkp_pjas_a020/load_form/{id}",
                     success: function(response){
                        $("#divForm").show();
                        $("#divForm").html(response);
                     }
                   });
                }
           } 
        });
    }
    
    function back(){
        window.location.href = "<?php echo base_url(); ?>spkp_pjas_a020";
    }
    
    function export_word(){
        $.ajax({
           type: "POST",
           url: "<?php echo base_url(); ?>spkp_pjas_a020/export/{id}",
           success: function(response){
              window.open("<?php echo base_url();?>spkp_loader/"+response);
           } 
        });
    }
</script>
<div style="display: none;" id="divLoadForm"></div>
<div id="divForm" style="padding:8px">
        <form method="post" id="frmData">
        <div style="background: #F4F4F4;padding: 5px;text-align: right;">
            <button type="button" onclick="save_form();">Simpan</button>
        	<button type="reset">Ulang</button>
            <button type="button" onclick="export_word()">Export</button>
            <button type="button" onclick="back()">Kembali</button>
        </div>
        </br>
        <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
            <tr>
                <td valign='top'>
                    <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black">
                        <tr>
                            <td width='14%'>Penyelenggara Pelatihan</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <input type="text" size="30" maxlength="30" name="penyelenggara" style="margin: 0;padding: 2px;" value="<?php 
            								if(set_value('penyelenggara')=="" && isset($penyelenggara)){
            								 	echo $penyelenggara;
            								}else{
            									echo  set_value('penyelenggara');
            								}
            								 ?>"/> *
                            </td>
                        </tr>
                        <tr>
                            <td width='14%'>Tempat Penyelenggaraan</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <input type="text" size="30" maxlength="30" name="tempat" style="margin: 0;padding: 2px;" value="<?php 
            								if(set_value('tempat')=="" && isset($tempat)){
            								 	echo $tempat;
            								}else{
            									echo  set_value('tempat');
            								}
            								 ?>"/> *
                            </td>
                        </tr>
                        <tr>
                            <td width='14%'>Tanggal Pelaksanaan</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <div id='tgl'></div>
                            </td>
                        </tr>
                        <tr>
                        	<td width='10%'>Lokasi praktek lapang</td>
                        	<td width='3%' align='middle'>:</td>
                        	<td width='50%'>
                                <input type="text" size="50" maxlength="50" name="lokasi" style="margin: 0;padding: 2px;" value="{lokasi}"/> 
                            </td>
                        </tr>
                        <tr>
                        	<td valign='top'>Hasil diskusi</td>
                        	<td align='middle' valign='top'>:</td>
                        	<td valign='top'>
                                <textarea cols="45" rows="4" wrap="virtual" style="width: 330px;margin: 0;" name="hasil_diskusi">{hasil_diskusi}</textarea>
                            </td>
                        </tr>
                        <tr>
        				    <td colspan="3" height="30">&nbsp;</td>
        				</tr>
                    </table>
                </td>
                <td valign='top'>
                    <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black">
                        <tr>
                            <td colspan="3">Penanggung Jawab</td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width='14%'>Tempat</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <input type="text" size="30" maxlength="30" name="ttd_tmpt" style="margin: 0;padding: 2px;" value="<?php 
            								if(set_value('ttd_tmpt')=="" && isset($ttd_tmpt)){
            								 	echo $ttd_tmpt;
            								}else{
            									echo  set_value('ttd_tmpt');
            								}
            								 ?>"/> *
                            </td>
                        </tr>
                        <tr>
                            <td width='14%'>Tanggal</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <div id='ttd_tgl'></div>
                            </td>
                        </tr>
                        <tr>
                            <td width='14%'>Nama</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <input type="text" size="50" maxlength="50" name="ttd_nama" style="margin: 0;padding: 2px;" value="<?php 
            								if(set_value('ttd_nama')=="" && isset($ttd_nama)){
            								 	echo $ttd_nama;
            								}else{
            									echo  set_value('ttd_nama');
            								}
            								 ?>"/> *
                            </td>
                        </tr>
                        <tr>
                            <td width='14%'>NIP</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <input type="text" size="30" maxlength="30" name="ttd_nip" style="margin: 0;padding: 2px;" value="<?php 
            								if(set_value('ttd_nip')=="" && isset($ttd_nip)){
            								 	echo $ttd_nip;
            								}else{
            									echo  set_value('ttd_nip');
            								}
            								 ?>"/> 
                            </td>
                        </tr>
                    </table> 
                </td>
            </tr>
        </table>
    </form>
</div>
