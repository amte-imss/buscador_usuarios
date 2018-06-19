<link href="<?php echo asset_url(); ?>css/detalle.css" rel="stylesheet">
<div id="titulos" class="row">
  <h3>Histórico del usuario</h3>
</div>
<div id="secInfoGeneral" class="row">
  <div class="col-md-6">
    <?php $actual = $historico[0]; ?>
    <h3 id="subtitulo">Información actual del usuario</h3>
    <br>
    <p><strong>Matrícula:</strong> <?php echo $actual['matricula'];?></p>
    <p><strong>Nombre:</strong> <?php echo $actual['nombre'].' '.$actual['apellido_paterno'].' '.$actual['apellido_materno'];?></p>
    <p><strong>Correo:</strong> <?php echo ($actual['correo'] != '')? $actual['correo'].'@imss.gob.mx':"";?></p>
    <p><strong>CURP:</strong> <?php echo $actual['curp'];?></p>
    <p><strong>RFC:</strong> <?php echo $actual['rfc'];?></p>
  </div>
  <div class="col-md-6">
    <br>
    <br>
    <br>
    <br>
    <p><strong>Delegación:</strong> <?php echo $actual['matricula'];?></p>
    <p><strong>Unidad:</strong> <?php echo $actual['unidad'];?></p>
    <p><strong>Departamento:</strong> <?php echo $actual['departamento'];?></p>
    <p><strong>Categoría:</strong> <?php echo $actual['categoria'];?></p>
  </div>
</div>
<hr>
<div class="row">
  <div id="historicoHeader">
    <h3 style="margin-bottom: 21px;">Historial</h3>
    <select id="selectMes" class="custom-select" onchange="cambiarHistorial(this)">
      <option selected value="0">Mes</option>
      <?php
        foreach ($meses as $key => $value) {
      ?>
          <option value="<?php echo $value;?>"><?php echo $key;?></option>
      <?php
        }
      ?>

    </select>
    <select id="selectAnio" class="custom-select" onchange="cambiarHistorial(this)">
      <option selected value="0">Año</option>
      <?php
        foreach ($anios as $value) {
      ?>
          <option value="<?php echo $value;?>"><?php echo $value;?></option>
      <?php
        }
      ?>
    </select>
  </div>
  <div id="cargador" style="display:none;">
    <div id="ajax_loader" align="center" style="padding-top:50px;"><img src="<?php echo base_url('assets/img/cargador.gif'); ?>" alt="Cargando..." title="Cargando..." /></div>
  </div>
  <div id="secHistorico">
    <?php
      if(isset($tabla)){
        echo $tabla;
      }
    ?>
  </div>
</div>