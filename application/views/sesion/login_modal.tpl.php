
<div class="col positionCenter">
    <h1 class="section-title">
        <span data-animation="flipInY" data-animation-delay="300" class="icon-inner animated flipInY visible">
            <span class="fa-stack">
                <i class="fa rhex fa-stack-2x"></i><i class="fa fa-sign-in fa-stack-1x"></i>
            </span>
        </span>
        <span data-animation="fadeInRight" data-animation-delay="500" class="title-inner animated fadeInRight visible">Iniciar Sesion</span>
    </h1>
    <div class="form-background">
        <?php echo form_open('inicio/index', array('id' => 'session_form', 'autocomplete' => 'off', 'class' => 'registration-form alt')); ?>
        <!-- <form id="registration-form-alt" name="registration-form-alt" class="registration-form alt" action="#" method="post"> -->
        <div class="row">
            <div class="col-sm-12 form-alert"></div>
            <div class="col-sm-12" style="margin-bottom: 15px;">
                <div class="form-group">
                    <div class="col-lg-5">
                        <label for="user" class="formulario">Matrícula o correo:</label>
                    </div>
                    <div class="col-lg-7">
                        <input id="usuario" name="usuario"
                               type="text" class="form-control input-name"
                               data-toggle="tooltip" title="Matrícula o correo electrónico es requerido"
                               placeholder=""
                               value="<?php echo set_value('usuario'); ?>"/>
                    </div>
                </div><div class="clearfix"></div>
                <?php
                echo form_error_format('usuario');
                ?>
            </div>
            <div class="col-sm-12" style="margin-bottom: 15px;">
                <div class="form-group">
                    <div class="col-lg-5">
                        <label for="user" class="formulario">Contraseña:</label>
                    </div>
                    <div class="col-lg-7">
                        <input id="password" name="password"
                               type="password" class="form-control input-name"
                               data-toggle="tooltip" title="Contraseña es requerida"
                               placeholder=""/>
                    </div>
                </div><div class="clearfix"></div>
                <?php
                echo form_error_format('password');
                ?>
            </div>
            <div class="col-sm-12" style="margin-bottom: 15px;">
                <div class="form-group">
                    <div class="col-lg-5">
                        <label for="user" class="formulario">CAPTCHA:</label>
                    </div>
                    <div class="col-lg-7">
                        <input id="captcha" name="captcha"
                               type="text" class="form-control input-name"
                               data-toggle="tooltip" title="Código de verificación es requerido"
                               placeholder=""/>
                    </div>
                    <div class="captcha-container" id="captcha_first">
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-6">
                            <img class="captcha" id="captcha_img" src="<?php echo site_url(); ?>/inicio/captcha" alt="CAPTCHA Image" />
                        </div>
                        <div class="col-lg-3 text-right">
                            <a class="btn btn-lg btn-theme" onclick="new_captcha()" style="padding: 10px 30px;">
                                <span class="glyphicon glyphicon-refresh"></span>
                            </a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <?php
                    echo form_error_format('captcha');
                    if (isset($errores) && !is_null($errores)) {
                        ?>
                        <div class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        <?php echo $errores; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <br>
            <div class="col-sm-12">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <button
                    data-animation="flipInY" data-animation-delay="100"
                    class="btn_is" type="submit"
                    > Iniciar Sesion <i class="fa fa-arrow-circle-right"></i></button>
                </div>
                <div class="col-sm-2"></div>

            </div>
            <div class="col-sm-12">
                <div class="text-center"><br><label for="user" class="formulario">¿Olvido su contraseña? <a href="http://11.32.41.238:9000/2018/sbn/index.php/inicio/recuperar_password" class="liga-login">Solicitela aquí</a></label></div>
            </div>
        </div>
        <!-- </form> -->
        <?php echo form_close(); ?>
    </div>
</div>

<script src="<?php echo asset_url(); ?>js/captcha.js"></script>
<script type="text/javascript">
$(function () {
    new_captcha();
});
<?php
if (isset($errores)) {
    ?>
    $('#login-modal').modal({show: true});
    <?php
}

if (isset($user_recovery) || isset($code_recovery)) {
    ?>
    $('#modalRecovery').modal({show: true});
    <?php
}
?>
</script>
