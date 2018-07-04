<?php
	$_ci = &get_instance();

	$_controller = $_ci->router->fetch_class();

	$_action = $_ci->router->fetch_method();	

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

	<title>Congresso | Administração</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="<?php echo assets('system','css','bootstrap.css');?>">
	<link rel="stylesheet" href="<?php echo assets('system','css','bootstrap-reset.css');?>">

	<!--external css-->
	<link rel="stylesheet" href="<?php echo assets('system','assets','font-awesome/css/font-awesome.css');?>">
	<!-- Custom styles for this template -->

	<link rel="stylesheet" href="<?php echo assets('system','css','style.css');?>">
	<link rel="stylesheet" href="<?php echo assets('system','css','style-responsive.css');?>">

	<link rel="stylesheet" href="<?php echo assets('system','assets','advanced-datatable/media/css/demo_table.css');?>">
	<link rel="stylesheet" href="<?php echo assets('system','assets','gritter/css/jquery.gritter.css');?>">
	<link rel="stylesheet" href="<?php echo assets('system','assets','data-tables/DT_bootstrap.css');?>">
	<link rel="stylesheet" href="<?php echo assets('system','assets','jquery-multi-select/css/multi-select.css');?>">

	<?php echo $_styles; ?>
	
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
	<!--[if lt IE 9]>
	<script src="<?php echo assets('libs','','template/html5shiv.js');?>"></script>
	<script src="<?php echo assets('libs','','template/respond.min.js');?>"></script>
	<![endif]-->
</head>

<body class="full-width">

	<section id="container" class="">
		<header class="header white-bg">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="fa fa-bar"></span>
					<span class="fa fa-bar"></span>
					<span class="fa fa-bar"></span>
				</button>
				<a href="<?php echo $_URL.'index.php/dash'; ?>" class="logo">ADMINISTRAÇÃO <span>CONGRESSO</span></a>
				<div class="horizontal-menu navbar-collapse collapse ">
					<ul class="nav navbar-nav">
						<li class='li-menu'><a href="<?php echo $_URL.'index.php/dash/'; ?>">Home</a></li>
						<li class='li-menu'><a href="<?php echo $_URL.'index.php/faleconosco/'; ?>">Fale Conosco (Dúvidas)</a></li>
						<li class='li-menu'><a href="<?php echo $_URL.'index.php/payments/'; ?>">Pagamentos</a></li>
						<li class='li-menu'><a href="<?php echo $_URL.'index.php/jobs/'; ?>">Trabalhos</a></li>
						<li class="dropdown li-menu">
							<a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Congressistas <b class=" fa fa-angle-down"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo $_URL.'index.php/subscribers/participants/'; ?>">Participantes</a></li>
								<li><a href="<?php echo $_URL.'index.php/subscribers/presenters/'; ?>">Apresentadores</a></li>
							</ul>
						</li>						
						<li class="dropdown li-menu">
							<a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Relatórios <b class=" fa fa-angle-down"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo $_URL.'index.php/reports/generate/1'; ?>">Participantes</a></li>
								<li><a href="<?php echo $_URL.'index.php/reports/generate/2'; ?>">Apresentadores</a></li>
								<li><a href="<?php echo $_URL.'index.php/reports/generate/3'; ?>">Trabalhos</a></li>
								<li><a href="<?php echo $_URL.'index.php/reports/generate/4'; ?>">Financeiro</a></li>
							</ul>
						</li>						
						<li class="dropdown li-menu">
							<a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#">Usuários <b class=" fa fa-angle-down"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo $_URL.'index.php/users/manage/'; ?>">Cadastro</a></li>
								<li><a href="<?php echo $_URL.'index.php/users/'; ?>">Listagem</a></li>
							</ul>
						</li>
					</ul>
				</div>
				
				<div class="top-nav ">
					<ul class="nav pull-right top-menu">
						<li class="dropdown">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<span class="username"><?php echo $_SESSION[$_ci->getSessionHash()]['user']->us_name; ?></span>
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu extended logout">
								<div class="log-arrow-up"></div>
								<li><a class='logout'><i class="fa fa-key"></i> Sair</a></li>
							</ul>
						</li>
					</ul>
				</div>

			</div>
		</header>

		<section id="main-content">
			<section class="wrapper">
				<?php echo $content; ?>
			</section>
		</section>
		<footer class="site-footer">
			<div class="text-center">
				2014 &copy; Desenvolvido por Vizzio Solutions
				<a href="#" class="go-top">
					<i class="fa fa-angle-up"></i>
				</a>
			</div>
		</footer>
		<!--footer end-->
	</section>

	<!-- Confirmação exclusão -->
	<div class="modal fade" id="modal-eliminate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Confirmação</h4>
				</div>
				<div class="modal-body">
					Tem certeza que deseja excluir?
				</div>
				<div class="modal-footer">
					<button class="btn btn-danger dismiss-cancel" type="button" data-dismiss="modal">Não</button>
					<button class="btn btn-success confirm-eliminate" type="button">Sim</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Loading -->
	<div class="modal fade" id="modal-loading" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Aguarde enquanto finalizamos a transação</h4>
				</div>
				<div class="modal-body">
					<div class="progress progress-striped active progress-sm">
						<div class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
							<span class="sr-only">100% Complete</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	

	<script>
		var siteURL = "<?php echo $_URL; ?>"; 
		var controller = "<?php echo $_controller; ?>"; 
		var action = "<?php echo $_action; ?>";
	</script>
	<script src="<?php echo assets('libs','','jquery/jquery.min.js');?>"></script>
	<script src="<?php echo assets('libs','','template/bootstrap.min.js');?>"></script>
	<script src="<?php echo assets('libs','','template/jquery.dcjqaccordion.2.7.js');?>"></script>
	<script src="<?php echo assets('libs','','template/hover-dropdown.js');?>"></script>
	<script src="<?php echo assets('libs','','template/jquery.scrollTo.min.js');?>"></script>
	<script src="<?php echo assets('libs','','template/jquery.nicescroll.js');?>"></script>
	<script src="<?php echo assets('libs','','template/jquery.validate.min.js');?>"></script>
	<script src="<?php echo assets('libs','','template/respond.min.js');?>"></script>
	<script src="<?php echo assets('libs','','template/common-scripts.js');?>"></script>
	<script src="<?php echo assets('libs','','template/count.js');?>"></script>
	<script src="<?php echo assets('libs','','template/jquery.downloader.js');?>"></script>

	<script src="<?php echo assets('system','assets','advanced-datatable/media/js/jquery.dataTables.js');?>"></script>
	<script src="<?php echo assets('system','assets','gritter/js/jquery.gritter.js');?>"></script>

	<script src="<?php echo assets('system','assets','bootstrap-inputmask/bootstrap-inputmask.min.js');?>"></script>
	<script src="<?php echo assets('system','assets','data-tables/DT_bootstrap.js');?>"></script>
	<script src="<?php echo assets('system','assets','jquery-multi-select/js/jquery.multi-select.js');?>"></script>
	<script src="<?php echo assets('system','assets','jquery-multi-select/js/jquery.quicksearch.js');?>"></script>

	<script>
		/* Função que faz reload do datatable */
		(function($, window, document) {
			if ( typeof $.fn.dataTable == "function" &&	typeof $.fn.dataTableExt.fnVersionCheck == "function" && $.fn.dataTableExt.fnVersionCheck('1.7.0') ){
				$.fn.dataTableExt.oApi.fnReloadAjax = function(oSettings, oUrl, oData){
					if (oUrl)
						oSettings.sAjaxSource=oUrl;

					//oSettings.sAjaxSource = sNewSource;
					this.fnClearTable(this);
					this.oApi._fnProcessingDisplay(oSettings, true );
					var that = this;

					$.getJSON(oSettings.sAjaxSource, oData, function(json){
						/* Got the data - add it to the table */
						for (var i=0; i<json.aaData.length; i++)
						{
							that.oApi._fnAddData(oSettings, json.aaData[i]);
						}

						oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
						that.fnDraw(that);
						that.oApi._fnProcessingDisplay(oSettings, false);
					});
				}
			}

		})(jQuery, window, document);
		
		function message(object,type,title,message){
			var html = '<div class="alert alert-block '+type+' fade in"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button><strong>'+title+'</strong> '+message+'</div>';
			jQuery(object).append(html);
		}

		function notification(title,text){
			$.gritter.add({
				title: title,
				text: text
			});
		}

		if(action != "index"){

			if($('a[href="'+siteURL+'index.php/'+controller+'/'+action+'/"]').length > 0)
				$('a[href="'+siteURL+'index.php/'+controller+'/'+action+'/"]').parents('.li-menu').addClass('active');
			else
				$('a[href="'+siteURL+'index.php/'+controller+'/"]').parents('.li-menu').addClass('active');	
		}else
			$('a[href="'+siteURL+'index.php/'+controller+'/"]').parents('.li-menu').addClass('active');	

		$(document).ready(function(){
			$('.logout').click(function(e){

				$.ajax({
					type: "POST",
					url: siteURL+"index.php/auth/ajaxLogout"
				}).done(function(data) {
					location.href=siteURL+"index.php/auth/login";
				});

				e.preventDefault();
			});
		});

	</script>
	<?php echo $_scripts; ?>
</body>
</html>
