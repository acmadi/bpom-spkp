<script type="text/javascript">
    $(document).ready(function () {
        $("#bar_datapjas").click();
    });
</script>
<div class="row-fluid">
   <div class="span12">
	   <h3 class="page-title">
		 {title}
	   </h3>
   </div>
</div>
<div style="border: 2px solid #DDDDDD;">
        <table width='100%' border='0'>
            <tr>
                <td colspan="3">
                    <table width='100%'>
                        <tr>
                            <td colspan="3">{form_edit}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3">
                    <table width='100%'>
                        <tr>
                            <td colspan="3" style="padding: 10px;">Target</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="padding-left: 10px;">
                                <div style="border-top: 2px solid #DDDDDD"></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div style="padding: 10px;">
                                    {form_target}
                                </div>
                            </td>
                        </tr>
                     </table>
                </td>
            </tr>
        </table>
</div>