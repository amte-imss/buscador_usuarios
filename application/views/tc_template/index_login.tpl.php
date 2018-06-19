<!DOCTYPE html>
    <head>
      <meta charset="utf-8">
      <meta charset="utf-8">
      <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- Favicons -->
      <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
      <link rel="shortcut icon" href="assets/ico/favicon.ico">

      <!-- CSS Global -->
      <link href="<?php echo asset_url(); ?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <!-- <link href="<?php echo asset_url(); ?>css/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
      <link href="<?php echo asset_url(); ?>plugins/fontawesome/css/font-awesome.min.css" rel="stylesheet">
      <link href="<?php echo asset_url(); ?>plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
      <link href="<?php echo asset_url(); ?>plugins/animate/animate.min.css" rel="stylesheet">

      <link href="<?php echo asset_url(); ?>css/theme.css" rel="stylesheet">
      <link href="<?php echo asset_url(); ?>css/custom.css" rel="stylesheet">

      <?php echo $css_files; ?>
      <?php echo css('template_foro/apprise.css'); ?>

      <script type="text/javascript">
          var language_text = <?php echo json_encode($language_text); ?>;
          var url = "<?php echo base_url(); ?>";
          var site_url = "<?php echo site_url(); ?>";
          var img_url_loader = "<?php echo base_url('assets/img/cargador.gif'); ?>";
      </script>
      <script src="<?php echo asset_url(); ?>plugins/jquery/jquery-2.1.1.min.js"></script>
      <script src="<?php echo asset_url(); ?>js/template_foro/general.js"></script>
      <script src="<?php echo asset_url(); ?>js/template_foro/apprise.js"></script>
      <script src="<?php echo asset_url(); ?>js/template_foro/idioma.js"></script>


        <!-- CSS Style Own -->
        <!-- <link href="<?php echo asset_url(); ?>css/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
        <link href="<?php echo asset_url(); ?>css/inicio_sesion.css" rel="stylesheet">
        <link href="<?php echo asset_url(); ?>css/menu.css" rel="stylesheet">

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
                  <?php
                    if (isset($menu) && !is_null($menu)) {
                        //pr($menu);
                        //echo $menu;
                        if (isset($menu['lateral']) && !empty($menu['lateral'])) {
                            echo render_menu_no_sesion($menu['lateral'], null);
                        }
                    }
                  ?>
                </div>
            </header>
            <!-- end HEADER -->

            <!-- Content area -->
            <div class="content-area" style="margin-top: 70px;">

                <!-- <div id="main"> -->
                <section class="page-section background-img">
                    <div class="container">
                        <div class="row">
                          <?php echo $main_content; ?>
                        </div>
                    </div>
                </section>
            </div>
            <span class="copyright" data-animation="fadeInUp" data-animation-delay="100"></span>

            <!-- </div> -->
            <!-- /Content area -->
            <!-- FOOTER -->
            <footer class="footer">

            </footer>
            <!-- /FOOTER -->

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
