<div class="row-fluid">
   <div class="span12">
	   <h3 class="page-title">
		 User Profile
	   </h3>
   </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#jqxTabs').jqxTabs({ width: '100%', height: '960', position: 'top', theme: theme });
    });
</script>
<div id="jqxTabs">
    <ul>
        <li>Profile</li>
        <li>Password</li>
    </ul>
    <div style="padding: 10px;">
        {form_profile}
    </div>
    <div style="padding: 10px;">
        {form_password}
    </div>
</div>