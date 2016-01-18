<div class="row-fluid">
	<div class="widget orange">
		<div class="widget-title">
			<h4><i class="icon-bell-alt"></i> Berita Utama </h4>
			<div style="float:right; padding:8px; padding-right:20px;">
				<a href="<?php echo base_url() ?>content/index/news" style="color:white">
					<strong>Show All...</strong>
				</a>
			</div>
		</div>
		<div class="widget-body">
			<!--div class="alert">
				<button data-dismiss="alert" class="close">×</button>
				<strong>Bandung ::</strong> Mobil Keliling Siap Menunjang Kegiatan Pengawasan
			</div>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close">×</button>
				<strong>Banda Aceh ::</strong> Asistensi dan Bimtek Penyusunan RKAKL 2014
			</div-->
			<?php foreach($konten as $data): ?>
			<a href="<?php echo base_url() ?>spkp/detail/news/<?php echo $data['file_id']; ?>/<?php echo $data['id']; ?>">
			<div class="alert alert-info">
				<button data-dismiss="alert" class="close">×</button>
				<strong><?php echo $data['title_content']; ?> ::</strong> <?php echo $data['headline']; ?>
			</div>
			</a>
			<?php endforeach; ?>
			<!--div class="alert alert-error">
				<button data-dismiss="alert" class="close">×</button>
				<strong>Palembang ::</strong> Kegiatan Penyidikan Untuk Pelindungan Masyarakat
			</div>
			<div class="alert alert-error">
				<button data-dismiss="alert" class="close">×</button>
				<strong>Palembang ::</strong> Sosialisasi Peraturan Dan Jaminan Produk Halal
			</div>
			<div class="alert alert-error">
				<button data-dismiss="alert" class="close">×</button>
				<strong>Palembang ::</strong> Sosialisasi Peraturan Dan Jaminan Produk Halal
			</div-->
		</div>
	</div>   
</div>