<link  href="<?php echo base_url();?>plugins/js/jHorizontalTree/css/style.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url();?>plugins/js/jHorizontalTree/js/jquery-1.8.1.min.js"></script>
<script src="<?php echo base_url();?>plugins/js/jHorizontalTree/js/jquery-ui.js"></script>
<script src="<?php echo base_url();?>plugins/js/jHorizontalTree/js/jquery.tree.js"></script>
<script>
$(document).ready(function() {
	 $('.tree').tree_structure({
		'add_option': false,
		'edit_option': false,
		'delete_option': false,
		'confirm_before_delete' : true,
		'animate_option': [true, 5],
		'fullwidth_option': false,
		'align_option': 'center',
		'draggable_option': false
    });
    
});
</script>
<div>
	{chart}
</div>
