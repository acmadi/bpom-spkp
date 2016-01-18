<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '30px', width: '100px' });
        $("input[name='mengetahui_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='mengetahui_nip']").jqxInput({ theme: 'fresh', height: '22px', width: '160px' }); 
        $("input[name='pelapor_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='pelapor_nip']").jqxInput({ theme: 'fresh', height: '22px', width: '160px' }); 
        $("#tanggal").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme, value: '{tanggal}'});
    });
    
    function save_form(){
        $("#divForm").hide();
        $("#divLoadForm").css("display","block");
        $("#divLoadForm").html("<div style='text-align:center;margin-top: 70px'><br><br><br><br><img src='<?php echo base_url();?>media/images/loaderB64.gif' alt='loading content.. '><br>loading</div>");
             
        $.ajax({
           type: "POST",
           url: "<?php echo base_url(); ?>spkp_pjas_a008/doedit_form/{id}",
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
                     url: "<?php echo base_url(); ?>spkp_pjas_a008/load_form/{id}",
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
                     url: "<?php echo base_url(); ?>spkp_pjas_a008/load_form/{id}",
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
        window.location.href = "<?php echo base_url(); ?>spkp_pjas_a008";
    }
    
    function export_word(){
        $.ajax({
           type: "POST",
           url: "<?php echo base_url(); ?>spkp_pjas_a008/export/{id}",
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
                <td>
                    <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black">
                        <tr>
                            <td width='12%'>Tanggal</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <div id='tanggal'></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                   <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black">
                        <tr>
                            <td colspan="3">Mengetahui</td>
                        </tr>
                        <tr>
                            <td width='14%'>Nama</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <input type="text" size="50" maxlength="50" name="mengetahui_nama" style="margin: 0;padding: 2px;" value="<?php 
            								if(set_value('mengetahui_nama')=="" && isset($mengetahui_nama)){
            								 	echo $mengetahui_nama;
            								}else{
            									echo  set_value('mengetahui_nama');
            								}
            								 ?>"/> *
                            </td>
                        </tr>
                        <tr>
                            <td width='14%'>NIP</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <input type="text" size="20" maxlength="20" name="mengetahui_nip" style="margin: 0;padding: 2px;" value="<?php 
            								if(set_value('mengetahui_nip')=="" && isset($mengetahui_nip)){
            								 	echo $mengetahui_nip;
            								}else{
            									echo  set_value('mengetahui_nip');
            								}
            								 ?>"/> 
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
                            <td colspan="3">Pelapor</td>
                        </tr>
                        <tr>
                            <td width='14%'>Nama</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <input type="text" size="50" maxlength="50" name="pelapor_nama" style="margin: 0;padding: 2px;" value="<?php 
            								if(set_value('pelapor_nama')=="" && isset($pelapor_nama)){
            								 	echo $pelapor_nama;
            								}else{
            									echo  set_value('pelapor_nama');
            								}
            								 ?>"/> *
                            </td>
                        </tr>
                        <tr>
                            <td width='14%'>NIP</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <input type="text" size="20" maxlength="20" name="pelapor_nip" style="margin: 0;padding: 2px;" value="<?php 
            								if(set_value('pelapor_nip')=="" && isset($pelapor_nip)){
            								 	echo $pelapor_nip;
            								}else{
            									echo  set_value('pelapor_nip');
            								}
            								 ?>"/> 
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
    </form>
</div>
