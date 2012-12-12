<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome administration</title>
    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/extjs/resources/css/ext-all.css') ?>" />
    <script type="text/javascript" src="<?php echo base_url('public/extjs/ext-all-debug.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('public/extjs/ext-all.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('public/app.js') ?>"></script>   
    <script type="text/javascript">
	var BASE_URL = '<?php echo site_url(); ?>';
    var welcome = '<?php echo $this->session->userdata('name'); ?>';
    var tes = '<?php echo config_item('user_type') ?>'        
    </script>
</head>
<body>


</body>
</html>