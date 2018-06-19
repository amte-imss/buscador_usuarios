<link href="<?php echo asset_url(); ?>css/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo asset_url(); ?>css/buscador.css" rel="stylesheet">
<link href="<?php echo asset_url(); ?>fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
<script src="<?php echo asset_url(); ?>js/buscador/buscador.js"></script>

<div id="secBuscador">
    <div id="titulos" class="row">
      <h3>Sistema</h3>
      <h3>de búsqueda de nómina</h3>
    </div>
    <?php echo form_open('buscador/obtener_busqueda', array('id' => 'form_buscador_general', 'autocomplete' => 'off', 'class' => 'registration-form alt')); ?>
      <div class="row" id="buscador">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <select class="custom-select" id="selectBusqueda" onchange="cambiarPlaceholder(this)" name="tipo">
              <option value="matricula" selected >Matrícula</option>
              <option value="nombre">Nombre</option>
              <option value="correo">Correo</option>
              <option value="delegacion">Delegación</option>
              <option value="unidad">Unidad</option>
              <option value="departamento">Departamento</option>
              <option value="categoria">Categoría</option>
            </select>
          </div>
          <input name="busqueda" onkeyup="convertirMayusculas(this)" type="text" id="buscadorGeneral" class="form-control" aria-label="Text input with dropdown button" placeholder="Búsqueda por matrícula">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" id="btnBuscadorGeneral" type="submit"><i class="fas fa-search"></i></button>
          </div>
        </div>
      </div>
    <?php echo form_close(); ?>
    <button type="button" class="btn btn-link" id="btnBuscar">Búsqueda avanzada <i class="fas fa-angle-double-right"></i></button>
    <div id="secBusquedaAvanzada">
      <div id="error" class="alert alert-danger" role="alert"><strong>Error</strong>: debes seleccionar o escribir en al menos en un campo</div>
      <?php echo form_open('buscador/obtener_busqueda', array('id' => 'form_buscador_avanzado', 'autocomplete' => 'off', 'class' => 'alt')); ?>
          <div class="form-row">
            <div class="col-md-3 mb-3">
              <label for="validationCustom01">Matrícula</label>
              <input type="text" onkeyup="convertirMayusculas(this)" class="form-control inputAll" id="validationCustom01" placeholder="Escribe matrícula ..." value="" name="matricula">
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="validationCustom02">Nombre</label>
              <input type="text" onkeyup="convertirMayusculas(this)" class="form-control inputAll" id="validationCustom02" placeholder="Escribe nombre ..." value="" name="nombre">
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="validationCustom02">Apellido paterno</label>
              <input type="text" onkeyup="convertirMayusculas(this)" class="form-control inputAll" id="validationCustom02" placeholder="Escribe apellido paterno ..." value="" name="apellido_paterno">
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="validationCustom02">Apellido materno</label>
              <input type="text" onkeyup="convertirMayusculas(this)" class="form-control inputAll" id="validationCustom02" placeholder="Escribe apellido materno ..." value="" name="apellido_materno">
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="validationCustom02">Correo</label>
              <input type="text" class="form-control inputAll" id="validationCustom02" placeholder="Escribe correo ..." value="" name="correo">
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="validationCustom02">Categoría</label>
              <select class="custom-select mr-sm-2 selectAll" id="inlineFormCustomSelectPref" name="categoria">
                <option selected>Seleccione...</option>
                <?php if(isset($categorias)){
                  if(count($categorias) > 0 ){
                    foreach ($categorias as $value) {
                ?>
                      <option value="<?php echo $value['id_categoria'];?>"><?php echo $value['nombre'];?></option>
                <?php
                    }
                  }
                }
                ?>
              </select>
            </div>
            <div class="col-md-3 mb-3">
              <label for="validationCustom02">Delegación</label>
              <select class="custom-select mr-sm-2 selectAll" onchange="mostrarUnidades(this)" id="inlineFormCustomSelectPref" name="delegacion">
                <option selected>Seleccione...</option>
                <?php if(isset($delegaciones)){
                  if(count($delegaciones) > 0 ){
                    foreach ($delegaciones as $value) {
                ?>
                      <option value="<?php echo $value['id_delegacion'];?>"><?php echo $value['nombre_grupo_delegacion'];?></option>
                <?php
                    }
                  }
                }
                ?>
              </select>
            </div>
            <div class="col-md-3 mb-3" id="secSelectUnidad">
              <label for="validationCustom02">Unidad</label>
              <select class="custom-select mr-sm-2 selectAll" onchange="mostrarDepartamentos(this)" id="selectUnidad" name="unidad">
              </select>
            </div>
            <div class="col-md-3 mb-3" id="secSelectDepartamento">
              <label for="validationCustom02">Departamento</label>
              <select class="custom-select mr-sm-2 selectAll" id="selectDepartamento" name="departamento">
              </select>
            </div>
        </div>
        <button class="btn btn-primary" id="btnBavanzada" type="submit">Buscar</button>
      <?php echo form_close(); ?>
    </div>
    <div id="cargador" style="display:none;">
      <div id="ajax_loader" align="center" style="padding-top:50px;"><img src="<?php echo base_url('assets/img/cargador.gif'); ?>" alt="Cargando..." title="Cargando..." /></div>
    </div>
    <div id="secRespuestaBusqueda">
    </div>
</div>
