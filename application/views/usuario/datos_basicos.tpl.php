<?php
if (isset($status) && $status)
{
    echo html_message('Usuario actualizado con éxito', 'success');
}
// pr($usuario);
?>

<div class="col-md-12 form-inline" role="form" id="informacion_general">
  <!--<form class="form-horizontal" id="form_datos_generales" method="post" accept-charset="utf-8">-->
<?php 
  if($usuario['es_imss']){
?>
  <div class="col-sm-12">
    <div class="col-sm-4">
      <label> Matrícula: </label>
      <br>
      <?php
        echo $this->form_complete->create_element(array(
            'id' => 'matricula',
            'type' => 'text',
            'value' => $usuario['matricula'],
            'attributes' => array(
                'readonly' => '',
                'class' => 'form-control',
                'style' => 'color: #6d7a83'
            )));
      ?>
    </div>
    <div class="col-sm-4">
      <label> RFC: </label>
      <br>
      <?php
        echo $this->form_complete->create_element(array(
            'id' => 'rfc',
            'type' => 'text',
            'value' => $usuario['rfc'],
            'attributes' => array(
                'readonly' => '',
                'class' => 'form-control',
                'style' => 'color: #6d7a83'
            )));
      ?>
    </div>
    <div class="col-sm-4">
      <label> CURP: </label>
      <br>
      <?php
        echo $this->form_complete->create_element(array(
            'id' => 'curp',
            'type' => 'text',
            'value' => $usuario['curp'],
            'attributes' => array(
                'readonly' => '',
                'class' => 'form-control',
                'style' => 'color: #6d7a83'
            )));
      ?>
    </div>
  </div>
<?php
  }
?>
  <div class="col-sm-12"><br></div>
  <div class="col-sm-12">
    <div class="col-sm-4">
      <label> Nombre: </label>
      <br>
      <?php
      echo $this->form_complete->create_element(array(
          'id' => 'nombre',
          'type' => 'text',
          'value' => $usuario['nombre'],
          'attributes' => array('class' => 'form-control')));
      ?>
      <?php echo form_error_format('nombre');?>
    </div>
    <div class="col-sm-4">
      <label> Apellido paterno: </label>
      <br>
      <?php
      echo $this->form_complete->create_element(array(
          'id' => 'apellido_paterno',
          'type' => 'text',
          'value' => $usuario['apellido_paterno'],
          'attributes' => array('class' => 'form-control')));
      ?>
      <?php echo form_error_format('apellido_paterno');?>
    </div>
    <div class="col-sm-4">
      <label> Apellido materno: </label>
      <br>
      <?php
      echo $this->form_complete->create_element(array(
          'id' => 'apellido_materno',
          'type' => 'text',
          'value' => $usuario['apellido_materno'],
          'attributes' => array('class' => 'form-control')));
      ?>
      <?php echo form_error_format('apellido_materno');?>
    </div>
  </div>
  <div class="col-sm-12"><br></div>
  <div class="col-sm-12">
    <div class="col-sm-8">
        <div class="col-sm-12" style="padding-left:  0;">
          <label> Genero: </label>
        </div>
        <div class="col-sm-12">
          <div class="col-md-3">
              <?php echo form_radio(array('name' => 'sexo', 'value' => En_sexo::MASCULINO, 'checked' => (isset($usuario['sexo']) && $usuario['sexo'] == 'M') ? true : false, 'id' => 'sexo')) . form_label($language_text['registro_usuario']['ext_sexo_m'], 'male'); ?>
          </div>
          <div class="col-md-3">
              <?php echo form_radio(array('name' => 'sexo', 'value' => En_sexo::FEMENINO, 'checked' => (isset($usuario['sexo']) && $usuario['sexo'] == 'F') ? true : false, 'id' => 'sexo')) . form_label($language_text['registro_usuario']['ext_sexo_f'], 'female'); ?>
          </div>
          <div class="col-md-3">
              <?php echo form_radio(array('name' => 'sexo', 'value' => En_sexo::OTRO, 'checked' => (isset($usuario['sexo']) && $usuario['sexo'] == 'O') ? true : false, 'id' => 'sexo')) . form_label($language_text['registro_usuario']['ext_sexo_o'], 'otro'); ?>
          </div>
      </div>
      <?php echo form_error_format('sexo');?>
    </div>
    <div class="col-sm-4">
      <label> País: </label>
      <br>
      <?php
        echo $this->form_complete->create_element(array('id' => 'clave_pais',
          'type' => 'dropdown',
          'first' => array('' => $language_text['registro_usuario']['pais_origen']),
          'options' => $paises,
          'value' => isset($usuario['clave_pais']) ? $usuario['clave_pais'] : 'MX',
          'attributes' => array(
              'class' => 'form-control',
              'style' => 'max-width:210px'
        )));
      ?>
      <?php echo form_error_format('clave_pais');?>
    </div>
  </div>
  <div class="col-sm-12"><br></div>
  <div class="col-sm-12">
    <div class="col-sm-4">
      <label> Correo electrónico: </label>
      <br>
      <?php
      echo $this->form_complete->create_element(array(
          'id' => 'email',
          'type' => 'text',
          'value' => $usuario['email'],
          'attributes' => array('class' => 'form-control')));
      ?>
      <?php echo form_error_format('email');?>
    </div>
    <div class="col-sm-4">
      <label> Teléfono personal: </label>
      <br>
      <?php
      echo $this->form_complete->create_element(array(
          'id' => 'telefono_personal',
          'type' => 'text',
          'value' => $usuario['telefono_personal'],
          'attributes' => array('class' => 'form-control')));
      ?>
      <?php echo form_error_format('telefono_personal');?>
    </div>
    <div class="col-sm-4">
      <label> Teléfono oficina: </label>
      <br>
      <?php
      echo $this->form_complete->create_element(array(
          'id' => 'telefono_oficina',
          'type' => 'text',
          'value' => $usuario['telefono_oficina'],
          'attributes' => array('class' => 'form-control')));
      ?>
      <?php echo form_error_format('telefono_oficina');?>
    </div>
  </div>
<?php if(!$usuario['es_imss']){ ?>
  <div class="col-sm-12"><br></div>
  <div class="col-sm-12">
    <div class="col-sm-4">
      <label> País de institución: </label>
      <br>
      <?php
        echo $this->form_complete->create_element(array('id' => 'pais_institucion',
          'type' => 'dropdown',
          'first' => array('' => $language_text['registro_usuario']['pais_institucion']),
          'options' => $paises,
          'value' => isset($usuario['pais_institucion']) ? $usuario['pais_institucion'] : 'MX',
          'attributes' => array(
              'class' => 'form-control',
              'style' => 'max-width:210px'
        )));
      ?>
      <?php echo form_error_format('pais_institucion');?>
    </div>
    <div class="col-sm-4">
      <label> Institución: </label>
      <br>
      <?php
      echo $this->form_complete->create_element(array(
          'id' => 'institucion',
          'type' => 'text',
          'value' => $usuario['institucion'],
          'attributes' => array('class' => 'form-control')));
      ?>
      <?php echo form_error_format('institucion');?>
    </div>
  </div>
<?php } ?>
<?php if($usuario['es_imss']){ ?>
  <div class="col-sm-12"><br></div>
  <div class="col-sm-12">
    <div class="col-sm-4">
      <label> Categoría: </label>
      <br>
      <?php
      echo $this->form_complete->create_element(array(
          'id' => 'categoria',
          'type' => 'text',
          'value' => $usuario['categoria'],
          'attributes' => array(
                'readonly' => '',
                'class' => 'form-control',
                'style' => 'color: #6d7a83'
            )));
      ?>
    </div>
    <div class="col-sm-4">
      <label> Unidad: </label>
      <br>
      <?php
      echo $this->form_complete->create_element(array(
          'id' => 'unidad',
          'type' => 'text',
          'value' => $usuario['unidad'],
          'attributes' => array(
                'readonly' => '',
                'class' => 'form-control',
                'style' => 'color: #6d7a83'
            )));
      ?>
    </div>
    <div class="col-sm-4">
      <label> Departamento: </label>
      <br>
      <?php
      echo $this->form_complete->create_element(array(
          'id' => 'departamento',
          'type' => 'text',
          'value' => $usuario['departamento'],
          'attributes' => array(
                'readonly' => '',
                'class' => 'form-control',
                'style' => 'color: #6d7a83'
            )));
      ?>
    </div>
  </div>
<?php } ?>
  <!--</form>-->
</div>
<div class="col-sm-12"><br></div>
<div class="col-md-12">
  <div class="col-md-5"></div>
  <div class="col-md-1">
    <button name="submit" type="submit" class="btn btn-success"  style=" background-color:#008EAD">Guardar <span class=""></span></button>
  </div>
</div>
