<div id="secBuscador">
    <div id="titulos" class="row">
      <br>
      <h3>Busqueda por csv</h3>
      <br><br>
      <!-- <h3>de búsqueda de nómina</h3> -->
    </div>
    <p>Suba el archivo a validar con la siguiente estructura de cabeceras en órden: ANIO, VUELTA, DUR_ANIO, DELEGACION, SEDE, GRADO,
      CARRERA, CURP,	MATRICULA,AP_PATERNO,	AP_MATERNO,	NOMBRE,	INSTITUCION,	CORREO.</p><br>

      <?php echo form_open_multipart('buscador/cargar_csv', array("accept-charset"=>"utf-8")); ?>
        Tipo de Busqueda:
                                      <?php
                                echo $this->form_complete->create_element(
                                        array('id' => 'tipo_b',
                                            'type' => 'dropdown',
                                            'options' => array(1=> 'Matricula',2 =>'Curp'),
                                            'attributes' => array('name' => 'tipo_b',
                                                'class' => 'form-control  form-control input-sm',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'top',
                                                'title' => 'Número de registros a mostrar')
                                        )
                                );
                                ?>
                                <br>
            <input type="file" name="userfile">  <br>
                    <?php
                    if (isset($status) && $status != null)
                    {
                         switch ($status)
                        {
                            case '2':
                                echo html_message('Datos inválidos', 'danger');
                                break;
                            case '3':
                                echo html_message('Archivo inválido', 'danger');
                                break;
                            case '4':
                                echo html_message('Acceso denegado', 'danger');
                                break;
                        }
                    }
                    ?>

           <input type="submit" name="submit" value="Cargar archivo" class="btn btn-primary">
                        <?php echo form_close(); ?>

     
</div>

