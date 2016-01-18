<link  href="<?php echo base_url();?>plugins/js/jHorizontalTree/style.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url();?>plugins/js/jHorizontalTree/js/jquery-1.8.1.min.js"></script>
<script src="<?php echo base_url();?>plugins/js/jHorizontalTree/js/jquery-ui.js"></script>
<script src="<?php echo base_url();?>plugins/js/jHorizontalTree/js/jquery.tree.js"></script>
<script>
$(document).ready(function() {
	$('.tree').tree_structure({
		'add_option': true,
		'edit_option': true,
		'delete_option': true,
		'confirm_before_delete' : true,
		'animate_option': [true, 5],
		'fullwidth_option': false,
		'align_option': 'center',
		'draggable_option': true
	});
});
</script>
<div class="overflow">
	<div>
		<ul class="tree">
			<li>
				<div style="width:150px;min-height:35px">Direktur Badan POM</div>
				<ul>
					<li>
						<div style="width:150px;min-height:35px">Subdit Surveilan dan Penanggulangan Keamanan Pangan</div>
						<ul>
							<li>
								<div>1.1.1</div>
							</li>
							<li>
								<div>1.1.2</div>
							</li>
							<li>
								<div>1.1.3</div>
								<ul>
									<li>
										<div>1.1.3.1</div>
										<ul>
											<li>
												<div>1.1.3.1.1</div>
											</li>
											<li>
												<div>1.1.3.1.2</div>
											</li>
										</ul>
									</li>
									<li>
										<div>1.1.3.1</div>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<li>
						<div style="width:150px;min-height:35px">Subdit Promosi Keamanan Pangan</div>
						<ul>
							<li>
								<div>1.2.1</div>
							</li>
							<li>
								<div>1.2.2</div>
							</li>
						</ul>
					</li>
					<li>
						<div style="width:150px;min-height:35px">Subdit Penyuluhan Makanan Siap Saji dan Industri Rumah Tangga</div>
						<ul>
							<li>
								<div>1.3.1</div>
							</li>
							<li>
								<div>1.3.2</div>
							</li>
							<li>
								<div>1.3.3</div>
							</li>
						</ul>
					</li>
					<li>
						<div>Pramubakti</div>
						<ul>
							<li>
								<div>1.4.1</div>
							</li>
							<li>
								<div>1.4.2</div>
							</li>
							<li>
								<div>1.4.3</div>
							</li>
						</ul>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</div>
<br><br>