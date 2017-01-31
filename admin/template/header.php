<!DOCTYPE html>
<html>
 <head>
  <base href="<?php echo $settings['site_url']."admin/";?>">
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 
  <title><?php echo $page_title;?></title>
  <style type="text/css">
		@import url("template/css/style.css");
		@import url("template/css/forms.css");
		@import url("template/css/forms-btn.css");
		@import url("template/css/menu.css");
		@import url("template/css/style_text.css");
		@import url("template/css/datatables.css");
		@import url("template/css/fullcalendar.css");
		@import url("template/css/pirebox.css");
		@import url("template/css/modalwindow.css");
		@import url("template/css/statics.css");
		@import url("template/css/tabs-toggle.css");
		@import url("template/css/system-message.css");
		@import url("template/css/tooltip.css");
		@import url("template/css/wizard.css");
		@import url("template/css/wysiwyg.css");
		@import url("template/css/wysiwyg.modal.css");
		@import url("template/css/wysiwyg-editor.css");
  </style>
  <!--[if lte IE 8]>
   <script type="text/javascript" src="template/js/excanvas.min.js"></script>
  <![endif]-->
	<script type="text/javascript" src="template/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="template/js/jquery.backgroundPosition.js"></script>
	<script type="text/javascript" src="template/js/jquery.placeholder.min.js"></script>
	<script type="text/javascript" src="template/js/jquery.ui.1.8.17.js"></script>
	<script type="text/javascript" src="template/js/jquery.ui.select.js"></script>
	<script type="text/javascript" src="template/js/jquery.ui.spinner.js"></script>
	<script type="text/javascript" src="template/js/superfish.js"></script>
	<script type="text/javascript" src="template/js/supersubs.js"></script>
	<script type="text/javascript" src="template/js/jquery.datatables.js"></script>
	<script type="text/javascript" src="template/js/fullcalendar.min.js"></script>
	<script type="text/javascript" src="template/js/jquery.smartwizard-2.0.min.js"></script>
	<script type="text/javascript" src="template/js/pirobox.extended.min.js"></script>
	<script type="text/javascript" src="template/js/jquery.tipsy.js"></script>
	<script type="text/javascript" src="template/js/jquery.elastic.source.js"></script>
	<script type="text/javascript" src="template/js/jquery.customInput.js"></script>
	<script type="text/javascript" src="template/js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="template/js/jquery.metadata.js"></script>
	<script type="text/javascript" src="template/js/jquery.filestyle.mini.js"></script>
	<script type="text/javascript" src="template/js/jquery.filter.input.js"></script>
	<script type="text/javascript" src="template/js/jquery.flot.js"></script>
	<script type="text/javascript" src="template/js/jquery.flot.pie.min.js"></script>
	<script type="text/javascript" src="template/js/jquery.flot.resize.min.js"></script>
	<script type="text/javascript" src="template/js/jquery.graphtable-0.2.js"></script>
	<script type="text/javascript" src="template/js/jquery.wysiwyg.js"></script>
	<script type="text/javascript" src="template/js/controls/wysiwyg.image.js"></script>
	<script type="text/javascript" src="template/js/controls/wysiwyg.link.js"></script>
	<script type="text/javascript" src="template/js/controls/wysiwyg.table.js"></script>
	<script type="text/javascript" src="template/js/plugins/wysiwyg.rmFormat.js"></script>
	<script type="text/javascript" src="template/js/costum.js"></script>
	<script type="text/javascript" src="template/js/admin.functions.js"></script>
</head>
<body>
 <div id="wrapper">
	<div id="container">
		<div class="hide-btn top"></div>
		<div class="hide-btn center"></div>
		<div class="hide-btn bottom"></div>
