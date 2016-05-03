			<tr valign="top" style="height:30px" id="<?php echo "1"?>__<?php echo $id_kategori_parent?>">
				<td class="tbl_list" width=100% align="left" style="padding-left:20px;padding-right:0px">|---&raquo;  <?php echo $nama?>
				<a href="#" onclick="if(confirm('Tambah sub Kategori?')){tambahsubkategori(<?php echo $id_kategori;?>)}" title="Tambah Sub Kategori"><img src="<?php echo base_url()?>media/images/16_add.gif"  style="padding:4px"/></a> 
				<?php if(!$this->srikandi_kategori_model->check_child($id_subdit,$id_kategori)){ 
						if ($this->srikandi_kategori_model->checdatajoin($id_kategori)==0) {
							# code...
						
				?>

					<a href="#" onclick="if(confirm('Hapus data ini?')){deletekategori(<?php echo $id_kategori;?>)}" title="Hapus Kategori"><img src="<?php echo base_url()?>media/images/16_del.gif"/></a> 
				<?php 
				}
				/*	$linkData="srikandi_kategori/dodel/".$id_kategori;
					$testLink=$this->verifikasi_icon->del_icon('srikandi_kategori',$linkData);
					echo $testLink;*/
				?>	
				<?php 

					?>

				<?php //}?>
				<?php } ?>
				
