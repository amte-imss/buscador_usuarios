<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"><!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=0">

        <title>
            <?php echo (!is_null($title)) ? "{$title}&nbsp;|" : "" ?>
            <?php echo (!is_null($main_title)) ? $main_title : "XV Foro Nacional y I Foro Internacional de Educación en Salud" ?>
        </title>

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
        <link href="<?php echo asset_url();?>css/esconder.css" rel="stylesheet">
        <!--link href="<?php echo asset_url(); ?>css/inicio_sesion.css" rel="stylesheet"-->
        <?php echo $css_files; ?>
        <?php echo css('template_foro/apprise.css'); ?>

        <!--[if lt IE 9]>
        <script src="<?php echo asset_url(); ?>plugins/iesupport/html5shiv.js"></script>
        <script src="<?php echo asset_url(); ?>plugins/iesupport/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript">
            var language_text = <?php echo json_encode($language_text); ?>;
            var lang_system_ = "<?php echo $lang_system; ?>";
            var url = "<?php echo base_url(); ?>";
            var site_url = "<?php echo site_url(); ?>";
            var img_url_loader = "<?php echo base_url('assets/img/loader.gif'); ?>";
        </script>
        <!--[if lt IE 9]><script src="<?php echo asset_url(); ?>plugins/jquery/jquery-1.11.1.min.js"></script><![endif]-->
        <!--[if gte IE 9]><!--><script src="<?php echo asset_url(); ?>plugins/jquery/jquery-2.1.1.min.js"></script><!--<![endif]-->
        <script src="<?php echo asset_url(); ?>js/template_foro/general.js"></script>
        <script src="<?php echo asset_url(); ?>js/template_foro/apprise.js"></script>
        <script src="<?php echo asset_url(); ?>js/template_foro/idioma.js"></script>
        <!-- Google Analytics -->
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-119316120-1', 'auto');
            ga('send', 'pageview');
        </script>
        <!-- End Google Analytics -->
    </head>
    <body id="home" class="wide body-light">
        <div id="overlay">
            <img src="<?php echo base_url('assets/img/loader.gif'); ?>" alt="Loading" /><br/>
            Cargando...
        </div>

        <!-- Preloader -->
        <div id="preloaders">
            <div id="status">
                <div class="spinner"></div>
            </div>
        </div>

        <div class="modal fade" id="my_modal" tabindex="3" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" id="my_modal_content" role="document">
                <?php
                if (isset($my_modal)) {
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
                        <div id="logo" class="col-xs-12 col-sm-12 col-md-5">
                            <div class="region region-head-logo">
                                <section id="block-block-4" class="block block-block clearfix">
                                    <div class="col-xs-6 col-sm-6 col-md-6 main-logos"><a href="http://www.gob.mx/" target="_blank"><img alt="MÉXICO | Gobierno de la República" class="img-responsive" src="<?php echo asset_url(); ?>img/PRESIDENCIA-2.png"></a></div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 main-logos"><a href="/"><img alt="Coordinación de Educación en Salud" class="img-responsive" src="<?php echo asset_url(); ?>img/ces.png"></a></div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 main-logos"><a href="http://www.imss.gob.mx/" target="_blank"><img alt="Instituto Mexicano del Seguro Social" class="img-responsive" src="<?php echo asset_url(); ?>img/imss.png"></a></div>
                                </section>
                            </div>
                        </div>
                        <!-- /Logo -->
                        <div class="col-sm-4 col-md-7 col-lg-7 pull-right text-right">
                            <a href="#" class="languaje_catalogo" data-cvelanguage="es">
                                <img img-responsive src="<?php echo asset_url(); ?>img/language/mx.png"
                                     class="logos"
                                     alt="<?php echo $language_text['template_general']['espaniol']; ?>"
                                     title="<?php echo $language_text['template_general']['espaniol']; ?>"
                                     target="_blank"
                                     width="20px;"/>
                            </a>
                            <!-- <a href="#"><img img-responsive class"logos" height="70px" src="assets/img/sipimss.png" alt=""></a> -->
                            <a href="#" class="languaje_catalogo" data-cvelanguage="en">
                                <img img-responsive src="<?php echo asset_url(); ?>img/language/us.png"
                                     class="logos"
                                     alt="<?php echo $language_text['template_general']['ingles']; ?>"
                                     title="<?php echo $language_text['template_general']['ingles']; ?>"
                                     target="_blank"
                                     width="20px;"/>
                            </a>
                        </div>

                        <!-- Navigation -->
                        <div class="col-sm-4 col-md-7 col-lg-7 right">
                            <?php
                            if (isset($menu) && !is_null($menu)) {
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
                    <div class="container">
                        <div class="row">
<?php echo $main_content; ?>
                        </div>
                    </div>
                </section>
                <!-- SLIDER -->
                <!-- <section class="page-section no-padding background-img-slider">
                    <div style="clear:both;"></div>
                    <div class="container">
                        <div id="main-slider"> -->
<?php //echo $main_content;  ?>
                <!-- </div>
            </div>
        </section> -->
                <!-- /SLIDER -->
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
                            <!-- <ul class="social-line list-inline">
                                <li><img src="<?php echo asset_url(); ?>img/Logo_SaberIMSS.png" alt="..." width="70" height="70"></li>
                                <li data-animation="flipInY" data-animation-delay="100"><a href="https://twitter.com/Saber_IMSS" class="twitter"><i class="fa fa-twitter"></i></a></li>
                                <li data-animation="flipInY" data-animation-delay="300"><a href="https://www.facebook.com/SaberIMSS/" class="facebook"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="https://www.youtube.com/channel/UCvlda6Uw7N_pZAH_fxE9ZYA" target="_blank" class="youtube"><i class="fa fa-youtube"></i></a></li>
                            </ul> -->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                <?php if(isset($language_text['generales']['legal'])){
                                    echo $language_text['generales']['legal'];
                                } ?>
                            </div>
                            <?php if(isset($language_text['generales']['creditos_titulo'])){
                                echo $language_text['generales']['creditos_titulo'];
                            } ?>
                            <!-- a target="_blank" href="<?php //echo site_url() . '/inicio/ver_creditos' ?>">Creditos</a -->
                        </div>
                        <!-- <span class="copyright" data-animation="fadeInUp" data-animation-delay="100">&copy; 2018 Instituto Mexicano del Seguro Social.</span>-->
                        <!-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 text-center">
                            <a href="https://www.gob.mx/presidencia/" class="scroll-to">
                                <img src="<?php echo asset_url(); ?>img/logo-presidencia.png" />
                            </a>
                        </div> -->
                        <!--div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 text-left">
                            <a href="http://www.qroo.gob.mx/sedetur" class="scroll-to">
                                <img src="<?php echo asset_url(); ?>img/logo-Cancun.png" />
                            </a>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-center">
                            <a href="http://www.fundacionimss.org.mx/" class="scroll-to">
                                <img src="<?php echo asset_url(); ?>img/logo-fundacion-imss.png" />
                            </a>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-center">
                            <a href="http://www.imss.gob.mx/" class="scroll-to">
                                <img src="<?php echo asset_url(); ?>img/logo-imss.png" />
                            </a>
                        </div> -->
                    </div>
                </div>
            </footer>
            <!-- /FOOTER -->
            <div class="to-top"><i class="fa fa-angle-up"></i></div>

        </div>
        <!-- /Wrap all content -->

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered"  role="document">
                <div id="modal_contenido" class="modal-content">
                    <!-- <div class="modal-header">
                      <h3 class="modal-title" id="exampleModalLabel">Asignar revisor(es)</h3>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div> -->
                    <div class="modal-body">
                        <!-- <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">Nombre</th>
                              <th scope="col">Especialidad</th>
                              <th scope="col">Opciones</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th scope="row">Juan Cuadros </th>
                              <td>Diabetes</td>
                              <td><button type="button" data-animation="flipInY" data-animation-delay="100" class="btn btn-theme btn-block submit-button" data-toggle="modal" data-target="#exampleModal">Asignar</button>
                              </td>
                            </tr>
                            <tr>
                              <th scope="row">Mariana Reyes</th>
                              <td>Medicina general</td>
                              <td><button type="button" data-animation="flipInY" data-animation-delay="100" class="btn btn-theme btn-block submit-button" data-toggle="modal" data-target="#exampleModal">Asignar</button>
                              </td>
                            </tr>
                            <tr>
                              <th scope="row">Cristina Pacheco</th>
                              <td>Neurocirugia</td>
                              <td><button type="button" data-animation="flipInY" data-animation-delay="100" class="col-sm-1 btn btn-theme btn-block submit-button" data-toggle="modal" data-target="#exampleModal">Asignar</button>
                              </td>
                            </tr>
                            <tr>
                              <th scope="row">Cristina Pacheco</th>
                              <td>Neurocirugia</td>
                              <td><button type="button" data-animation="flipInY" data-animation-delay="100" class="col-sm-1 btn btn-theme btn-block submit-button" data-toggle="modal" data-target="#exampleModal">Asignar</button>
                              </td>
                            </tr>
                          </tbody>
                        </table> -->
                    </div>
                    <!-- <div class="modal-footer">
                      <button type="button" data-animation="flipInY" data-animation-delay="100" class="btn btn-theme btn-block" class="btn btn-primary">Guardar</button>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- Modal -->

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



                $(window).resize(function(){

                   if ($('header').width() < 992 ){
                     $('#menuREPORTES_MENU').parent()[0].childNodes[1].className = "esconderNav";
                     $('#menuPERFIL').parent()[0].childNodes[1].className = "esconderNav";
                     $('#menuADMIN').parent()[0].childNodes[1].className = "esconderNav";
                     $('.esconderNav').hide();
                     //$('#menuREPORTES_MENU').children('li').css('display','none !important');
                   }else{
                     $('.esconderNav').show();
                     //$('.sf-menu ul li').css('background-color','rgba(13, 29, 49, 0.80)');
                     //background-color: ;
                   }

                });
            });
            jQuery(window).load(function () {
                theme.initAnimation();
            });

            jQuery(window).load(function () {
                jQuery('body').scrollspy({offset: 100, target: '.navigation'});
            });
            jQuery(window).load(function () {
                jQuery('body').scrollspy('refresh');
            });
            jQuery(window).resize(function () {
                jQuery('body').scrollspy('refresh');
            });

            jQuery(document).ready(function () {
                theme.onResize();
            });
            jQuery(window).load(function () {
                theme.onResize();
            });
            jQuery(window).resize(function () {
                theme.onResize();
            });

            jQuery(window).load(function () {
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
<?php echo $js_files; ?>
    </body>
</html>
