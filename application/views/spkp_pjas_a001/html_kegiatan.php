<script type="text/javascript">
    $(document).ready(function(){
		$("#tabeldatakegiatan").jqxInput({ theme: theme });
		$("button,submit,reset").jqxInput({ theme: 'fresh' });
		$('#btn_print').click(function () {
			wincetak = window.open("", "Cetak Dokumen", "width=1,height=1,scrollbars=no,menubar=no");
			wincetak.document.writeln($("#datacetakegiatan").html());
			wincetak.print();
		});
});
</script>
<div style="padding:6px;position:fixed;width:100%;left:865px">
	<table cellpadding='2' cellspacing='1' border='0' style='background:#CFCFCF;border:1px solid #CFCFCF;border-radius:4px;'>
	<tr>
		<td align="right" id="td_proses" style="color:white;">
			<button type="button" class=btn style="width:90px" id="btn_print">Print</button>
        </td>
	</tr>
	</table>
</div>
<div id="datacetakegiatan" style="padding:10px;padding-top:50px;text-align:center;border: 1px solid rgb(204,209,205);background: rgb(244,244,244);min-height:600px">
	<div style="padding: 5px;text-align: center;font-weight: bold;">
        Form  A001. Matriks kegiatan Lintas Sektor dalam Rangka Aksi Nasional PJAS <br>Tahun <?php echo $tahun; ?> di Provinsi <?php echo $nama_propinsi; ?>
    </div>
    <br />
    <table id="tabeldatakegiatan" cellpadding="4" cellspacing="2" width="100%" border='1' style="border-collapse: collapse;">
		<thead>
        <tr style="font-weight:bold">
			<td width='15%'>Program</td>
			<td width='20%'>Contoh Kegiatan</td>
            <td width='15%'>Instansi Pelaksana</td>
            <td width='13%'>Indikator</td>
            <td width='13%'>Target</td>
            <td width='12%'>Waktu</td>
            <td width='12%'>Sumber Dana</td>
        </tr>
		</thead>
        <tbody>
            <?php
            $arr_abjad = array("","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
            $data_strategi = $this->spkp_pjas_a001_model->get_strategi();
            $x = 1;
            foreach($data_strategi as $row_strategi){
            ?>
            <tr>
                <td colspan="7" style="text-align: center;font-weight: bold;padding: 3px;">
                    <?php echo "Strategi ".$x.": ".$row_strategi->nama; ?>
                </td>
            </tr>
                <?php
                $data_program = $this->spkp_pjas_a001_model->get_program($row_strategi->id_strategi);
                $y = 1;
                foreach($data_program as $row_program){
                    $count_kegiatan = $this->spkp_pjas_a001_model->get_kegiatan($row_program->id_program,$propinsi,$tahun);
                    if($count_kegiatan->num_rows()==0){
                        $rowspan = 2;
                    }else{
                        $rowspan = intval($count_kegiatan->num_rows)+1;
                    }
                ?>
                <tr>
                    <td rowspan="<?php echo $rowspan; ?>" valign='top'>
                        <?php echo $y.". ".$row_program->nama; ?>
                    </td>
                </tr>
                    <?php
                    $data_kegiatan = $this->spkp_pjas_a001_model->get_kegiatan($row_program->id_program,$propinsi,$tahun);
                    if($data_kegiatan->num_rows==0){
                        ?>
                        <tr>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                        </tr>
                        <?php
                    }else{
                        $z=1;
                        foreach($data_kegiatan->result() as $row_kegiatan){
                        ?>
                        <tr>
                            <td valign='top'><?php echo $arr_abjad[$z].". ".$row_kegiatan->nama; ?></td>
                            <td valign='top'><?php echo $row_kegiatan->instansi; ?></td>
                            <td valign='top'><?php echo $row_kegiatan->indikator; ?></td>
                            <td valign='top'><?php echo $row_kegiatan->target; ?></td>
                            <td valign='top'><?php echo $row_kegiatan->waktu; ?></td>
                            <td valign='top'><?php echo $row_kegiatan->sumber_dana; ?></td>
                        </tr>
            <?php
                        $z++;
                        }
                    }
                $y++;
                }
            $x++;
            }
            ?>
        </tbody>
	</table>
</div>