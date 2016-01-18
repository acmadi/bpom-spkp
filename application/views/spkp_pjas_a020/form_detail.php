<form method="post" id="frmDetail">
    <table width='100%' border='0' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
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
        	<td colspan="3">&nbsp;</td>
        </tr>
        <tr>
        	<td colspan="3" width='50%'>
                <div style="background: #F4F4F4;padding: 5px;text-align: right;">
                    <button type="button" onclick="save_detail()">Simpan</button>
                	<button type="reset">Ulang</button>
                </div>
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '30px', width: '100px' });
        $("input[name='lokasi']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' });
    });
    
    function save_detail(){
        $("#divDetail").hide();
        $("#divLoadDetail").css("display","block");
        $("#divLoadDetail").html("<div style='text-align:center;margin-top: 1px'><br><br><br><br><img src='<?php echo base_url();?>media/images/loaderB32.gif'><br>loading</div>");
             
        $.ajax({
           type: "POST",
           url: "<?php echo base_url(); ?>spkp_pjas_a020/doedit_form_detail/{id}",
           data: $("#frmDetail").serialize(),
           success: function(response){
                if(response=="1"){
                   $.notific8('Notification', {
    				   life: 5000,
    				   message: 'Save data succesfully.',
    				   heading: 'Saving data',
    				   theme: 'lime'
    			   });
                   
                   $("#divLoadDetail").css("display","none");
                   
                   $.ajax({
                     type: "POST",
                     url: "<?php echo base_url(); ?>spkp_pjas_a020/load_form_detail/{id}",
                     success: function(response){
                        $("#divDetail").show();
                        $("#divDetail").html(response);
                     }
                   });
                }else{
                    $.notific8('Notification', {
					  life: 5000,
					  message: response,
                      heading: 'Saving data FAIL',
					  theme: 'red'
					});
                    
                    $("#divLoadDetail").css("display","none");
                    
                    $.ajax({
                     type: "POST",
                     url: "<?php echo base_url(); ?>spkp_pjas_a020/load_form/{id}",
                     success: function(response){
                        $("#divDetail").show();
                        $("#divDetail").html(response);
                     }
                   });
                }
           } 
        });
    }
</script>