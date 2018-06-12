<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Database Error</title>
<style type="text/css">

::selection { background-color: #E13300; color: white; }
::-moz-selection { background-color: #E13300; color: white; }

body {
	background-color: #fff;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}
</style>
</head>
<body>
	<div id="container">
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
	</div>
</body>
</html>
*/?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"><!--<![endif]-->
<head>
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Foro Nacional y Foro Internacional de Educación en Salud</title>


    <!-- Favicons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="shortcut icon" href="assets/ico/favicon.ico">

    <!-- CSS Global -->
    <link href="<?php echo asset_url(); ?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo asset_url(); ?>plugins/fontawesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo asset_url(); ?>plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
    <!-- <link href="<?php echo asset_url(); ?>plugins/owlcarousel2/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?php echo asset_url(); ?>plugins/owlcarousel2/assets/owl.theme.default.min.css" rel="stylesheet">
    <link href="<?php echo asset_url(); ?>plugins/prettyphoto/css/prettyPhoto.css" rel="stylesheet"> -->
    <link href="<?php echo asset_url(); ?>plugins/animate/animate.min.css" rel="stylesheet">
    <!-- <link href="<?php echo asset_url(); ?>plugins/countdown/jquery.countdown.css" rel="stylesheet"> -->

    <link href="<?php echo asset_url(); ?>css/theme.css" rel="stylesheet">
    <link href="<?php echo asset_url(); ?>css/custom.css" rel="stylesheet">

    

    <!--[if lt IE 9]>
    <script src="<?php echo asset_url(); ?>plugins/iesupport/html5shiv.js"></script>
    <script src="<?php echo asset_url(); ?>plugins/iesupport/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
    var language_text = <?php echo json_encode($language_text); ?>;
    var url = "<?php echo base_url(); ?>";
    var site_url = "<?php echo site_url(); ?>";
    var img_url_loader = "<?php echo base_url('assets/img/loader.gif'); ?>";
    </script>
    <!--[if lt IE 9]><script src="<?php echo asset_url(); ?>plugins/jquery/jquery-1.11.1.min.js"></script><![endif]-->
    <!--[if gte IE 9]><!--><script src="<?php echo asset_url(); ?>plugins/jquery/jquery-2.1.1.min.js"></script><!--<![endif]-->
    <script src="<?php echo asset_url(); ?>js/template_foro/general.js"></script>
    <script src="<?php echo asset_url(); ?>js/template_foro/apprise.js"></script>
    <script src="<?php echo asset_url(); ?>js/template_foro/idioma.js"></script>
</head>
<body id="home" class="wide body-light">

<!-- Preloader -->
<div id="preloaders">
    <div id="status">
        <div class="spinner"></div>
    </div>
</div>

<div class="modal fade" id="my_modal" tabindex="3" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" id="my_modal_content" role="document">
        <?php
        if (isset($my_modal))
        {
            ?>
            <?php echo $my_modal; ?>
        <?php } ?>
    </div>
</div>

<!-- Wrap all content -->
<div class="wrapper">

    <!-- HEADER -->
    <header class="header fixed">
        <div class="container">
            <div class="header-wrapper clearfix">

                <!-- Logo -->
                <div class="logo col-sm-4 col-md-4 col-lg-4">
                    <a href="#home" class="scroll-to">
                        <img height="100px" src="<?php echo asset_url(); ?>img/logo_foro_naranja.png" />
                    </a>
                </div>
                <!-- /Logo -->
                <div class="col-sm-8 col-md-8 col-lg-8 pull-right text-right">
                    
                </div>

                <!-- Navigation -->
                <div class="col-sm-8 col-md-8 col-lg-8 right">
                    <?php
                    if (isset($menu) && !is_null($menu))
                    {
                        // pr($menu);
                        //echo $menu;
                        if (isset($menu['lateral']) && !empty($menu['lateral'])) {
                            //echo render_menu($menu['lateral'], null);
                            echo render_menu_no_sesion($menu['lateral'], null);
                        }
                        if (isset($menu['lateral_no_sesion']) && !empty($menu['lateral_no_sesion'])) {
                            echo render_menu_no_sesion($menu['lateral_no_sesion'], null);
                        }
                    }
                    ?>
                <!-- /Navigation -->
                </div>

                <!-- /Redes sociales -->
                <!--div id="div_redes" class="right col-sm-2 col-md-2 col-lg-2">
                    <ul class="social-line list-inline text-right">
                        <li data-animation="flipInY" data-animation-delay="100"><a href="#" class="twitter"><i class="fa fa-twitter"></i></a></li>
                        <li data-animation="flipInY" data-animation-delay="300"><a href="#" class="facebook"><i class="fa fa-facebook"></i></a></li>
                    </ul>
                </div-->
            </div>
        </div>
    </header>
    <!-- /HEADER -->

    <!-- Content area -->
    <div class="content-area">

        <!-- <div id="main"> -->
            <section class="page-section background-img">
                <div class="container text-center">
                    <div class="row">
                    	<div class="col-sm-12 col-md-12 col-lg-12">
                    		<h1>Foro Nacional y Foro Internacional de Educación en Salud</h1>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-sm-12 col-md-12 col-lg-12">
							<p>Puede estar experimentando variaciones en su conexión de internet, o podría no estar conectado a su red. Por favor verifique el estado de su conexión.</p>
						</div>
                    </div>
                </div>
            </section>
            
        </div>
        <span class="copyright" data-animation="fadeInUp" data-animation-delay="100"></span>

    <!-- </div> -->
    <!-- /Content area -->
    <!-- FOOTER -->
    <footer class="footer">
        <!-- <div class="footer-meta">
            <div class="container text-center">
                <span class="copyright" data-animation="fadeInUp" data-animation-delay="100">&copy; 2018 Instituto Mexicano del Seguro Social.</span>
            </div>
        </div> -->
        <div class="footer-meta">
            <div class="container">
                <div class="clearfix text-center">
                    <ul class="social-line list-inline">
                        <li data-animation="flipInY" data-animation-delay="100"><a href="#" class="twitter"><i class="fa fa-twitter"></i></a></li>
                        <li data-animation="flipInY" data-animation-delay="300"><a href="#" class="facebook"><i class="fa fa-facebook"></i></a></li>
                    </ul>
                </div>
                <!-- <span class="copyright" data-animation="fadeInUp" data-animation-delay="100">&copy; 2018 Instituto Mexicano del Seguro Social.</span>-->
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5 text-left">
                    <a href="#home" class="scroll-to">
                        <img src="<?php echo asset_url(); ?>img/logo-presidencia.png" class="img-responsive" />
                    </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-2 text-center pull-centerr">
                    <!-- <span class="copyright" data-animation="fadeInUp" data-animation-delay="100">&copy; 2018 IMSS, <a href="#">Aviso legal</a>.</span> -->
                    <a href="#home" class="scroll-to">
                        <img src="<?php echo asset_url(); ?>img/logo-fundacion-imss.png" class="img-responsive"  />
                    </a>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5 text-right">
                    <a href="#home" class="scroll-to">
                        <img src="<?php echo asset_url(); ?>img/logo-imss.png" class="img-responsive"  />
                    </a>
                </div>
            </div>
        </div>
    </footer>
    <!-- /FOOTER -->
    <div class="to-top"><i class="fa fa-angle-up"></i></div>

</div>
<!-- /Wrap all content -->

<!-- JS Global -->
<script src="<?php echo asset_url(); ?>plugins/modernizr.custom.js"></script>
<script src="<?php echo asset_url(); ?>plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo asset_url(); ?>plugins/bootstrap-select/bootstrap-select.min.js"></script>
<!-- <script src="<?php echo asset_url(); ?>plugins/superfish/js/superfish.js"></script>
<script src="<?php echo asset_url(); ?>plugins/prettyphoto/js/jquery.prettyPhoto.js"></script> -->
<script src="<?php echo asset_url(); ?>plugins/placeholdem.min.js"></script>
<script src="<?php echo asset_url(); ?>plugins/jquery.smoothscroll.min.js"></script>
<script src="<?php echo asset_url(); ?>plugins/jquery.easing.min.js"></script>

<!-- JS Page Level -->
<!-- <script src="<?php echo asset_url(); ?>plugins/owlcarousel2/owl.carousel.min.js"></script> -->
<script src="<?php echo asset_url(); ?>plugins/waypoints/waypoints.min.js"></script>
<!-- <script src="<?php echo asset_url(); ?>plugins/countdown/jquery.plugin.min.js"></script>
<script src="<?php echo asset_url(); ?>plugins/countdown/jquery.countdown.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script> -->

<script src="<?php echo asset_url(); ?>js/theme-ajax-mail.js"></script>
<script src="<?php echo asset_url(); ?>js/theme.js"></script>
<script src="<?php echo asset_url(); ?>js/template_foro/menu.js"></script>
<!-- script src="<?php echo asset_url(); ?>js/custom.js"></script -->

<script type="text/javascript">
    jQuery(document).ready(function () {
        theme.init();
        theme.initMainSlider();
        theme.initCountDown();
        theme.initPartnerSlider();
        theme.initTestimonials();
        theme.initGoogleMap();
    });
    jQuery(window).load(function () {
        theme.initAnimation();
    });

    jQuery(window).load(function () { jQuery('body').scrollspy({offset: 100, target: '.navigation'}); });
    jQuery(window).load(function () { jQuery('body').scrollspy('refresh'); });
    jQuery(window).resize(function () { jQuery('body').scrollspy('refresh'); });

    jQuery(document).ready(function () { theme.onResize(); });
    jQuery(window).load(function(){ theme.onResize(); });
    jQuery(window).resize(function(){ theme.onResize(); });

    jQuery(window).load(function() {
        if (location.hash != '') {
            var hash = '#' + window.location.hash.substr(1);
            if (hash.length) {
                jQuery('html,body').delay(0).animate({
                    scrollTop: jQuery(hash).offset().top - 44 + 'px'
                }, {
                    duration: 1200,
                    easing: "easeInOutExpo"
                });
            }
        }
    });

</script>
</body>
</html>