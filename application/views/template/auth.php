<?php
	$_ci = &get_instance();
	$_URL = $_ci->config->slash_item('base_url');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="keyword" content="">
	<link rel="shortcut icon" href="img/favicon.png">

	<title>Administração Congresso | Login</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="<?php echo assets('system','css','bootstrap.css');?>">
	<link rel="stylesheet" href="<?php echo assets('system','css','bootstrap-reset.css');?>">

	<!--external css-->
	<link rel="stylesheet" href="<?php echo assets('system','assets','font-awesome/css/font-awesome.css');?>">
	<!-- Custom styles for this template -->

	<link rel="stylesheet" href="<?php echo assets('system','css','style.css');?>">
	<link rel="stylesheet" href="<?php echo assets('system','css','style-responsive.css');?>">

	<?php echo $_styles; ?>
	
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
	<!--[if lt IE 9]>
	<script src="<?php echo assets('libs','','template/html5shiv.js');?>"></script>
	<script src="<?php echo assets('libs','','template/respond.min.js');?>"></script>
	<![endif]-->
</head>

<body class="login-body">

	<div class="container">
		<?php echo $content; ?>
	</div>

	<script>var siteURL = "<?php echo $_URL; ?>";</script>
	<script src="<?php echo assets('libs','','jquery/jquery.min.js');?>"></script>
	<script src="<?php echo assets('libs','','template/bootstrap.min.js');?>"></script>
	<script>
		function message(object,type,title,message){
			var html = '<div class="alert alert-block '+type+' fade in"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button><strong>'+title+'</strong> '+message+'</div>';
			jQuery(object).append(html);
		}
	</script>
	<?php echo $_scripts; ?>
</body>
</html>
