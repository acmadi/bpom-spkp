<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/1998/REC-html40-19980424/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="id" lang="id" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
		<title>:: {title} - SPKP ::</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<META NAME="description" CONTENT="{description}" />
		<META NAME="keywords" CONTENT="{keywords}" />
		<link rel="icon" href="<?php echo base_url()?>public/themes/spkp/front/images/bpom.png">
		<style type="text/css">
		/* <![CDATA[ */
			@import url("<?php echo base_url()?>public/themes/spkp/front/css/style.css");
		/* ]]> */
		</style>
			
		<script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jquery-1.6.1.min.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jquery.MyDigitClock.js"></script>
		<script type="text/javascript" language="javascript">
		/* <![CDATA[ */
		$(function() {
					
			$('input[type=text]').each(function() {
				$(this).attr('autocomplete', 'off');
			});
					
		});
		/* ]]> */

		</script>
	</head>
	<body>
	<div id="bodypage">
		<table id="Table_01" width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;">
			<tr>
				<td style="padding:0 0 0 10px;vertical-align:top;">{content}</td>
			</tr>
		</table>
	</div>
 </BODY>
</html>
