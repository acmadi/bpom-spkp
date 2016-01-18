<div class="row-fluid">
	<div class="widget red">
		 <div class="widget-title">
			<h4><i class="icon-comments-alt"></i>Pengumuman</h4>
			<div style="float:right; padding:8px; padding-right:20px;">
				<a href="<?php echo base_url() ?>content/index/announcement" style="color:white">
					<strong>Show All...</strong>
				</a>
			</div>
		 </div>
		 <div class="widget-body">
			 <div class="timeline-messages">
				
				 <!--div class="msg-time-chat">
					 <a class="message-img" href="#"> <img src="<?php echo base_url(); ?>media/images/avatar1.png" alt="" class="avatar"/></a>
					 <div class="message-body msg-in">
						 <span class="arrow"></span>
						 <div class="text">
							 <p class="attribution">Harry Zustiman at 1:55pm, 13th Septemnbr 2013</p>
							 <p><a href="#">Upaya Bersama Mewujudkan Obat Tradisional Bebas Bahan Kimia Obat</a></p>
						 </div>
					 </div>
				 </div-->
				<?php foreach($konten as $data): ?>
					 <div class="msg-time-chat">
						 <div class="message-img"><img src="<?php echo base_url(); ?>media/images/user/<?php echo $data['image']; ?>" alt="" class="avatar"/></div>
						 <div class="message-body msg-out">
							 <span class="arrow"></span>
							 <div class="text">
								 <p class="attribution"><?php echo $data['author'].' At '.$data['waktu']; ?></p>
								 <p>
									<a href="<?php echo base_url() ?>spkp/detail/announcement/<?php echo $data['file_id']; ?>/<?php echo $data['id']; ?>">
										<b><?php echo $data['title_content']; ?></b>
									</a>
								</p>
							 </div>
						 </div>
					 </div>
				<?php endforeach; ?>
				 <!--div class="msg-time-chat">
					 <a class="message-img" href="#"><img src="<?php echo base_url(); ?>media/images/avatar-mini2.png" alt="" class="avatar"/></a>
					 <div class="message-body msg-in">
						 <span class="arrow"></span>
						 <div class="text">
							 <p class="attribution"><a href="#">Fakhri Syahab</a> at 2:03pm, 13th April 2013</p>
							 <p>Dukung Pemerintah Kabupaten Seruyan dalam Pengawasan Obat dan Makanan</p>
						 </div>
					 </div>
				 </div>
				 
				 <div class="msg-time-chat">
					 <a class="message-img" href="#"><img src="<?php echo base_url(); ?>media/images/avatar1.png" alt="" class="avatar"/></a>
					 <div class="message-body msg-out">
						 <span class="arrow"></span>
						 <div class="text">
							 <p class="attribution"><a href="#">Harry Zustiman</a> at 2:05pm, 13th April 2013</p>
							 <p>Rencana Umum Pengadaan Barang/Jasa Balai Besar POM di Jakarta</p>
						 </div>
					 </div>
				 </div-->
				
			 </div>
		  
		 </div>
	 </div>
</div>