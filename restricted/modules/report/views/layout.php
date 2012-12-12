<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="lolkittens" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/extjs/resources/css/ext-all.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style.css') ?>" /> 
    <script type="text/javascript" src="<?php echo base_url('public/extjs/ext-all.js') ?>"></script>
    <script type="text/javascript">
    var exporterUrl = '<?php echo base_url() ?>public/extjs/ux/';
    var PathUrl = '<?php echo base_url() ?>';
     Ext.Loader.setPath('Ext.ux.exporter','<?php echo base_url() ?>public/extjs/app/lib/components/gridexporter/ux/exporter');
		
    </script>
    <script type="text/javascript" src="<?php echo base_url() ?>public/extjs/app/lib/components/gridexporter/ux/exporter/swfobject.js"></script>
     <script type="text/javascript" src="<?php echo base_url() ?>public/extjs/app/lib/components/gridexporter/ux/exporter/downloadify.min.js"></script>
     <script type="text/javascript" src="<?php echo base_url() ?>public/extjs/app/lib/components/gridexporter/ux/exporter/Button.js"></script>
     <script type="text/javascript" src="<?php echo base_url() ?>public/extjs/app/lib/components/gridexporter/ux/exporter/Exporter.js"></script>

    <title>Untitled 1</title>
</head>

<body>
<?php echo $contents; ?>


</body>
</html>