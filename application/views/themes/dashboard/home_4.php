<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/1998/REC-html40-19980424/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="id" lang="id" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
		<title>{title}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<META NAME="description" CONTENT="{description}" />
		<META NAME="keywords" CONTENT="{keywords}" />
		<style type="text/css">
		/* <![CDATA[ */
			@import url("<?php echo base_url()?>public/themes/dashboard/css/style.css");
		/* ]]> */
		</style>
		<script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jquery-1.3.2.js"></script>
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
		<table id="Table_01" width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
			<tr valign="bottom">
				<td>
					<img src="<?php echo base_url()?>public/themes/dashboard/images/dashboard_01.gif" alt=""></td>
				<td align="right" style="background:url(<?php echo base_url()?>public/themes/dashboard/images/dashboard_04.gif) no-repeat bottom right">
					<img src="<?php echo base_url()?>public/themes/dashboard/images/dashboard_02.gif" alt=""></td>
			</tr>
			<tr>
				<td colspan="2" style="height:10px;background:#999999 url(<?php echo base_url()?>public/themes/dashboard/images/dashboard_03.gif) no-repeat top right">&nbsp;</td>
			</tr>
			<tr valign="top">
				<td colspan="2" id="content">
					{content}
			</tr>
		</table>
	</div>
 </BODY>
</html>
