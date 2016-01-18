<div class="row-fluid">
	<div class="widget purple">
		<div class="widget-title">
			<h4><i class="icon-tasks"></i> Kegiatan </h4>
			<div style="float:right; padding:8px; padding-right:20px;">
				<a href="<?php echo base_url() ?>content/index/event" style="color:white">
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
			<a href="<?php echo base_url() ?>spkp/detail/event/<?php echo $data['file_id']; ?>/<?php echo $data['id']; ?>">
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close">×</button>
				<strong><?php $angkabln=array('01','02','03','04','05','06','07','08','09','10','11','12');
				$indobln=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus',
				'September','Oktober','November','Desember');
				echo substr($data['waktu_kegiatan'],8,2).' '.
				str_ireplace($angkabln,$indobln,(substr($data['waktu_kegiatan'],5,2))).' '.
				substr($data['waktu_kegiatan'],0,4); ?> ::</strong> <?php echo $data['title_content']; ?>
			</div>
			</a>
			<?php endforeach; ?>
			<!--div class="alert alert-info">
				<button data-dismiss="alert" class="close">×</button>
				<strong>Palembang ::</strong> Kegiatan Penyidikan Untuk Pelindungan Masyarakat
			</div>
			<div class="alert alert-success">
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