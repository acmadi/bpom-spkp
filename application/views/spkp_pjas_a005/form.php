<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '30px', width: '100px' });
        $("input[name='tempat']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='penanggungjawab_tempat']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
      //  $("input[name='tanggal']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='penanggungjawab_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='penanggungjawab_nip']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("#tanggal").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme, value: '{tanggal}'});
        $("#penanggungjawab_tanggal").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme, value: '{penanggungjawab_tanggal}'});
        
    });
    
    function save_form(){
        $("#divForm").hide();
        $("#divLoadForm").css("display","block");
        $("#divLoadForm").html("<div style='text-align:center;margin-top: 70px'><br><br><br><br><img src='<?php echo base_url();?>media/images/loaderB64.gif' alt='loading content.. '><br>loading</div>");
             
        $.ajax({
           type: "POST",
           url: "<?php echo base_url(); ?>spkp_pjas_a005/doedit_form/{id}",
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
                     url: "<?php echo base_url(); ?>spkp_pjas_a005/load_form/{id}",
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
                     url: "<?php echo base_url(); ?>spkp_pjas_a005/load_form/{id}",
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
        window.location.href = "<?php echo base_url(); ?>spkp_pjas_a005";
    }
    
    function export_word(){
        $.ajax({
           type: "POST",
           url: "<?php echo base_url(); ?>spkp_pjas_a005/export/{id}",
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
                   <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
                        <tr>
                            <td width='21%'>Balai Besar / Balai POM</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <select size="1" name="balai" style="width: 230px;margin: 0;">
                                 <?php
                                 $data_balai = $this->spkp_pjas_a005_model->get_all_balai();
                                 foreach($data_balai as $row_balai){
                                 ?>
                                    <option value="<?php echo $row_balai->id_balai; ?>" <?php if($row_balai->id_balai==$id_balai) echo "Selected";  ?>><?php echo $row_balai->nama_balai; ?></option>
                                <?php
                                }
                                ?>
                                </select>
                                <span style="vertical-align: top">*</span>   
                            </td>
                        </tr>
                        <tr>
                            <td width='21%'>Tempat</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <input type="text" size="50" maxlength="50" name="tempat" style="margin: 0;padding: 2px;" value="{tempat}"/> *
                            </td>
                        </tr>
                        <tr>
                            <td width='21%'>Tanggal</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <div id='tanggal'></div>
                            </td>
                        </tr>
                        <tr>
                            <td width='21%' valign='top'>Hasil Diskusi</td>
                            <td width='3%' valign='top' align='middle'>:</td>
                            <td width='50%'>
                                 <textarea cols="35" rows="10" wrap="virtual" name="hasil" style="width: 450px;">{hasil}</textarea>
                            </td>
                        </tr>
                        <tr>
        				    <td colspan="3" height="30">&nbsp;</td>
        				</tr>
                        <tr>
                            <td colspan="3">Penanggung Jawab</td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width='25%'>Tempat</td>
                            <td width='4%' align='middle'>:</td>
                            <td width='50%'>
                                <input type="text" size="50" maxlength="50" name="penanggungjawab_tempat" style="margin: 0;padding: 2px;" value="<?php 
            								if(set_value('penanggungjawab_tempat')=="" && isset($penanggungjawab_tempat)){
            								 	echo $penanggungjawab_tempat;
            								}else{
            									echo  set_value('penanggungjawab_tempat');
            								}
            								 ?>"/> *
                            </td>
                        </tr>
                        <tr>
                            <td width='14%'>Tanggal</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <div id='penanggungjawab_tanggal'></div>
                            </td>
                        </tr>
                        <tr>
                            <td width='14%' valign='middle'>Nama</td>
                            <td width='3%' valign='middle' align='middle'>:</td>
                            <td width='50%'>
                                 <input type="text" size="50" maxlength="50" name="penanggungjawab_nama" style="margin: 0;padding: 2px;" value="{penanggungjawab_nama}"/> 
                            </td>
                        </tr>
                        <tr>
                            <td width='14%' valign='middle'>NIP</td>
                            <td width='3%' valign='middle' align='middle'>:</td>
                            <td width='50%'>
                                 <input type="text" size="20" maxlength="20" name="penanggungjawab_nip" style="margin: 0;padding: 2px;" value="{penanggungjawab_nip}"/> 
                            </td>
                        </tr>
                    </table> 
                </td>
            </tr>
        </table>
        
    </form>
</div>
