<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/1998/REC-html40-19980424/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="id" lang="id" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
		<title>:: {title} - SPKP ::</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<META NAME="description" CONTENT="{description}" />
		<META NAME="keywords" CONTENT="{keywords}" />
		<link rel="shortcut icon" href="<?php echo base_url(); ?>media/images/favicon.png">
		<style type="text/css">
		/* <![CDATA[ */
			@import url(<?php echo base_url()?>public/themes/spkp/back/assets/bootstrap/css/bootstrap.min.css);
			@import url(<?php echo base_url()?>public/themes/spkp/back/assets/bootstrap/css/bootstrap-responsive.min.css);
			@import url(<?php echo base_url()?>public/themes/spkp/back/assets/font-awesome/css/font-awesome.css);
			@import url(<?php echo base_url()?>public/themes/spkp/back/css/style.css);
			@import url(<?php echo base_url()?>public/themes/spkp/back/css/style-responsive.css);
			@import url(<?php echo base_url()?>public/themes/spkp/back/css/style-default.css);
			@import url(<?php echo base_url()?>public/themes/spkp/back/assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css);	
            @import url(<?php echo base_url()?>plugins/js/jquery/notific8/jquery.notific8.min.css);
            @import url(<?php echo base_url()?>plugins/js/jquery/jqwidgets/styles/jqx.arctic.css);
            @import url(<?php echo base_url()?>plugins/js/jquery/jqwidgets/styles/jqx.base.css);
            @import url(<?php echo base_url()?>plugins/js/jquery/jqwidgets/styles/jqx.fresh.css);
		/* ]]> */
		</style>
        <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>plugins/js/jquery/jquery-1.10.2.min.js"></script>
    	<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>plugins/js/jquery/ajaxupload.3.5.js"></script>
    	<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>plugins/js/jquery/notific8/jquery.notific8.min.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>plugins/js/print_preview/jquery.print-preview.js"></script>
		</style>
	</head>
<body class="fixed-top">
	<!-- BEGIN HEADER -->
   <div id="header" class="navbar navbar-inverse navbar-fixed-top">
       <!-- BEGIN TOP NAVIGATION BAR -->
       <div class="navbar-inner">
           <div class="container-fluid">
               <!--BEGIN SIDEBAR TOGGLE-->
               <div class="sidebar-toggle-box hidden-phone">
                   <div class="icon-reorder"></div>
               </div>
               <!--END SIDEBAR TOGGLE-->
               <!-- BEGIN LOGO -->
               <a class="brand" href="#">
					<img src="<?php echo base_url(); ?>media/images/logo.png" alt="DIT SPKP" /> 
               </a>
               <!-- END LOGO -->
               <!-- BEGIN RESPONSIVE MENU TOGGLER -->
               <a class="btn btn-navbar collapsed" id="main_menu_trigger" data-toggle="collapse" data-target=".nav-collapse">
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="arrow"></span>
               </a>
               <!-- END RESPONSIVE MENU TOGGLER -->
               <div id="top_menu" class="nav notify-row">
                   <!-- BEGIN NOTIFICATION -->
                   <ul class="nav top-menu">
                       <!-- BEGIN SETTINGS -->
                      
                       <!-- END SETTINGS -->
                   </ul>
               </div>
               <!-- END  NOTIFICATION -->
               <div class="top-nav ">
                   <ul class="nav pull-right top-menu" >
                        <!-- BEGIN INBOX DROPDOWN -->
                       <li class="dropdown" id="header_inbox_bar">
                           {message}
                       </li>
                       <!-- END INBOX DROPDOWN -->
                      <!-- BEGIN NOTIFICATION DROPDOWN -->
                       <li class="dropdown" id="header_notification_bar">
                          {notification}
                       </li>
                       <!-- END NOTIFICATION DROPDOWN -->
                       
                       <!-- BEGIN USER LOGIN DROPDOWN -->
                       <li class="dropdown">
                           {profile}
                       </li>
                       <!-- END USER LOGIN DROPDOWN -->
                       
                   </ul>
                   <!-- END TOP NAVIGATION MENU -->
               </div>
           </div>
       </div>
       <!-- END TOP NAVIGATION BAR -->
   </div>
   <!-- END HEADER -->
   
   {sidebar}
   
   <!-- BEGIN CONTAINER -->
   <div id="container" class="row-fluid">
     
      <!-- BEGIN PAGE -->  
      <div id="main-content">
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            {content}
			<br>
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->  
   </div>
   <!-- END CONTAINER -->

   <!-- BEGIN FOOTER -->
   <div id="footer">
       2013 &copy; BADAN POM RI.
   </div>
   <!-- END FOOTER -->

    <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>plugins/js/assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>plugins/js/assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>plugins/js/assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>plugins/js/assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>plugins/js/metro/common-scripts.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>plugins/js/metro/jquery.nicescroll.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>plugins/js/metro/home-page-calender.js"></script>

	<script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxinput.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxtabs.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxdropdownlist.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxgrid.selection.js"></script>	
	<script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxgrid.edit.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxgrid.filter.js"></script>	
	<script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxgrid.sort.js"></script>		
	<script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxgrid.pager.js"></script>		
	<script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxgrid.columnsresize.js"></script>		
	<script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxcalendar.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxdatetimeinput.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/globalization/globalize.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxdata.js"></script>	
	<script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxlistbox.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxnavigationbar.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxchart.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxtree.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxdocking.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxdata.export.js"></script> 
    <script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxgrid.export.js"></script> 
	<script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxnumberinput.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxmaskedinput.js"></script>
    <script type="text/javascript">
        var theme = "arctic";
    </script>
</body>
</html>

