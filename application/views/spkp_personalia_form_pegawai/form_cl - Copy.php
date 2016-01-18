<script type="text/javascript">
    $(document).ready(function(){
       $("button,submit,reset").jqxInput({ theme: 'fresh', height: '28px', width: '100px' });  
       $("span.edit").dblclick(function(){
            if($(this).attr('id')=='prm__hitungan'){
                $("span").removeClass('edit');
                $("#divStore").text($(this).attr('id'));
                var arr_id = $("#divStore").text().split("__");
                $("#divStoreVal").text($(this).text());
                $(this).text("");
                
                $.get("<?php echo base_url(); ?>spkp_personalia_form_pegawai/get_hitungan/"+$("#divStoreSelect").text(), function(response){
                    $("#prm__hitungan").html(response); 
                });
            }else if($(this).attr('id')=='prm__jml'){
                $("span").removeClass('edit');
                $("#divStore").text($(this).attr('id'));
                var arr_id = $("#divStore").text().split("__");
                $("#divStoreVal").text($(this).text());
                $(this).text("");
                $(this).append("<input class='input_edit' type='text' size='45' name='text_"+$(this).attr('id')+"' value='"+$("#divStoreVal").text()+"' />");
                $("input[name='text_"+$(this).attr('id')+"']").jqxInput({ theme: 'fresh', height: '23px', width: '30px' }); 
                
                $("input[name='text_"+$(this).attr('id')+"']").blur(function(){
                   save_form(arr_id[1],$("#frmDataIzin").serialize());
                   
                   $(this).fadeOut("slow", function(){
                        var id = $("#divStore").text();
                        $("span#"+id).text($("input[name='text_"+id+"']").val());
                        show_span();
                   });
                });
            }else if($(this).attr('id')=='prm__stat_tgl'){
                $("span").removeClass('edit');
                $("#divStore").text($(this).attr('id'));
                var arr_id = $("#divStore").text().split("__");
                $("#divStoreVal").text($(this).text());
                $(this).text("");
                $(this).append("<table><tr><td><div id='text_"+$(this).attr('id')+"'></div></td><td><input class='btn_done' type='button' value='Selesai' /></td></tr></table>");
                
                if($("#divStoreVal").text()=="..............."){ var divDate = <?php echo date('Y-m-d'); ?> }else{ var divDate = $("#divStoreVal").text(); }
                $("#text_"+$(this).attr('id')).jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme, value: divDate });
                $("input.btn_done").jqxInput({ theme: 'fresh', height: '25px', width: '54px' });
                
                $("input.btn_done").click(function(){
                   save_form(arr_id[1],$("#frmDataIzin").serialize());
                   
                   $(this).fadeOut("slow", function(){
                        var id = $("#divStore").text();
                        $("span#"+id).text($("#text_"+id).val());
                        show_span();
                   });
                });
            }else{
                $("span").removeClass('edit');
                $("#divStore").text($(this).attr('id'));
                var arr_id = $("#divStore").text().split("__");
                $("#divStoreVal").text($(this).text());
                $(this).text("");
                $(this).append("<input class='input_edit' type='text' size='45' name='text_"+$(this).attr('id')+"' value='"+$("#divStoreVal").text()+"' />");
                $("input[name='text_"+$(this).attr('id')+"']").jqxInput({ theme: 'fresh', height: '23px', width: '400px' }); 
                
                $("input[name='text_"+$(this).attr('id')+"']").blur(function(){
                   save_form(arr_id[1],$("#frmDataIzin").serialize());
                   
                   $(this).fadeOut("slow", function(){
                        var id = $("#divStore").text();
                        $("span#"+id).text($("input[name='text_"+id+"']").val());
                        show_span();
                   });
                });
            }
       });
    });
    
    function save_form(col,data){
        $.ajax({
            type : "POST",
            url : "<?php echo base_url(); ?>spkp_personalia_form_pegawai/save_form/{id}/"+col,
            data: data,
            success: function(response){
                if(response=="1"){
                    $.notific8('Notification', {
						  life: 5000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
                }else{
                    $.notific8('Notification', {
						  life: 5000,
						  message: res[1],
						  heading: 'Saving data FAIL',
						  theme: 'red2'
						});
                }            
            }   
        });
    }
    
    function show_span(){
        $("#prm__jml").addClass('edit');
        $("#prm__hitungan").addClass('edit');
        $("#prm__stat_tgl").addClass('edit');
        $("#prm__alasan_tambahan").addClass('edit');
        $("#prm__alamat").addClass('edit');
    }
</script>
<style>
.edit {
    color: blue;
    font-weight: bold;
    cursor: pointer;
}
.input_edit {
    
}
</style>
   
           <table width='68%' cellpadding='4' cellspacing='2' border='0' align='center' style="font-size: 13px;color: black">
                <tr>
                    <td colspan="3">Formulir Cuti Diluar Tanggungan Negara</td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3">Yang bertanda tangan dibawah ini saya  :</td>
                </tr>
                <tr>
                    <td width='10%'>Nama</td>
                    <td width='3%' align='center'>:</td>
                    <td>{nama}</td>
                </tr>
                <tr>
                    <td>NIP</td>
                    <td align='center'>:</td>
                    <td>{nip}</td>
                </tr>
                <tr>
                    <td>Pangkat/Golongan</td>
                    <td align='center'>:</td>
                    <td>{golongan} - {jabatan}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td align='center'>:</td>
                    <td>{nama_jabatan}</td>
                </tr>
                <tr>
                    <td>Unit Kerja</td>
                    <td align='center'>:</td>
                    <td>{ket}</td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div id="divStore" style="display: none;"></div>
                        <div id="divStoreVal" style="display: none;"></div>
                        <div id="divStoreSelect" style="display: none;"><?php echo strtolower($prm_hitungan); ?></div>
                        <?php
                        if($status_kirim=="1"){
                            ?>
                            <p align='justify'>
                            Dengan ini mengajukan permintaan cuti diluar tanggungan negara selama {prm_jml} {prm_hitungan}*
                            terhitung mulai tanggal {prm_stat_tgl}
                            dengan alasan sebagai berikut {prm_alasan_tambahan}
                            Selama menjalankan cuti alamat saya adalah di {prm_alamat}
                            </p>
                            <?php
                        }else{
                            ?>
                            <p align='justify'>
                            Dengan ini mengajukan permintaan cuti diluar tanggungan negara selama <span id="prm__jml" class="edit">{prm_jml}</span> <span id="prm__hitungan" class="edit">{prm_hitungan}</span>*
                            terhitung mulai tanggal <span id="prm__stat_tgl" class="edit">{prm_stat_tgl}</span>
                            dengan alasan sebagai berikut <span id="prm__alasan_tambahan" class="edit">{prm_alasan_tambahan}</span>
                            Selama menjalankan cuti alamat saya adalah di <span id="prm__alamat" class="edit">{prm_alamat}</span>
                            </p>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p align='justify'>
                        Demikian permintaan ini saya buat untuk dapat dipertimbangkan sebagaimana mestinya.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">Hormat Saya,</td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">
                    <u>{nama}</u></br>
		            NIP. {nip}
                    </td>
                </tr>
            </table>
       