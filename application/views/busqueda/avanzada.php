<?php echo js('paginacion/general.js'); ?>
<?php echo js('combobox/listas.js'); ?>
<?php
      echo form_open('buscador/busqueda_avanzada/', array('id' => 'form_paginacion'));
?>
<div id="titulos" class="row">
  <h3>Busqueda Avanzada</h3>
</div>
<div id="secInfoGeneral" class="row">
  <div class="col-md-6">
    <h3 id="subtitulo"> Por los siguientes campos</h3>
    <br>
    <p><strong>CURP:</strong> <?php
                                echo $this->form_complete->create_element(array('id' => 'curp', 'type' => 'text'));
                                ?></p>
    <p><strong>Matricula:</strong><?php
                                echo $this->form_complete->create_element(array('id' => 'matricula', 'type' => 'text'));
                                ?> </p>
    <p><strong>Nombre:</strong><?php
                                echo $this->form_complete->create_element(array('id' => 'nombre', 'type' => 'text'));
                                ?> </p>
    <p><strong>Apellido Paterno:</strong><?php
                                echo $this->form_complete->create_element(array('id' => 'apellido_paterno', 'type' => 'text'));
                                ?> </p>
    <p><strong>Apellido Materno:</strong><?php
                                echo $this->form_complete->create_element(array('id' => 'apellido_materno', 'type' => 'text'));
                                ?>  </p>
    <p><strong>Número de registros a mostrar:</strong>   <?php
                                echo $this->form_complete->create_element(
                                        array('id' => 'per_page',
                                            'type' => 'dropdown',
                                            'value' => $departamentos['per_page'],
                                            'options' => array(20 => 20, 30 => 30, 40 => 40, 50 => 50, 100 => 100),
                                            'attributes' => array('name' => 'per_page',
                                                'class' => 'form-control  form-control input-sm',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'top',
                                                'title' => 'Número de registros a mostrar')
                                        )
                                );
                                ?></p>                             
  </div>
  <div class="col-md-6">
    <br>
    <br>
    <br>
    <br>
    <p><strong>Delegación:</strong>  <?php
                                      echo $this->form_complete->create_element(
                                              array('id' => 'delegacion',
                                                  'type' => 'dropdown',
                                                  'first' => array('' => 'Seleccione...'),
                                                  'options' => $catalogos[Catalogo_listado::DELEGACIONES],
                                                  'attributes' => array(
                                                      'class' => 'form-control  form-control input-sm',
                                                      'data-toggle' => 'tooltip',
                                                      'data-placement' => 'top',
                                                      'onchange' => 'obtener_unidades_cbx(this)',
                                                      'title' => 'Delegaciones',
                                                      'selected' => 'Todos')
                                              )
                                      );
                                    ?> </p>
    <p><strong>Unidad:</strong> <?php
                                    echo $this->form_complete->create_element(
                                            array('id' => 'unidad',
                                                'type' => 'dropdown',
                                                'first' => array('' => 'Seleccione...'),
                                                'attributes' => array(
                                                    'class' => 'form-control  form-control input-sm',
                                                    'data-toggle' => 'tooltip',
                                                    'data-placement' => 'top',
                                                    'title' => 'unidad',
                                                )
                                            )
                                    );
                                    ?></p>
    <p><strong>Categoría:</strong>                              <?php
                                echo $this->form_complete->create_element(
                                        array('id' => 'categorias',
                                            'type' => 'dropdown',
                                            'first' => array('' => 'Seleccione...'),
                                            'options' => $catalogos[Catalogo_listado::CATEGORIAS],
                                            'attributes' => array('name' => 'categorias',
                                                'class' => 'form-control  form-control input-sm',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'top',
                                                'title' => 'Categorias')
                                        )
                                );
                                ?> </p>
    <p><strong>Tipo de orden:</strong>           <?php
                                echo $this->form_complete->create_element(
                                        array('id' => 'order',
                                            'type' => 'dropdown',
                                            'options' => array(1 => 'Ascendente', 2 => 'Descendente'),
                                            'attributes' => array('name' => 'order',
                                                'class' => 'form-control  form-control input-sm',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'top',
                                                'title' => 'Tipo de orden')
                                        )
                                );
                                ?></p>   

                            <?php echo form_error_format('order'); ?>

                            <?php
                            echo $this->form_complete->create_element(array(
                                'id' => 'btn_submit',
                                'type' => 'submit',
                                'value' => 'Buscar Dato',
                                'attributes' => array(
                                    'class' => 'btn btn-primary',
                                ),
                            ));
                            ?>

                    <?php echo form_close(); ?>                         
  </div>
</div>
<hr>


  <div class="row">

                    <?php
                    if (isset($departamentos['current_row']))
                    {
                        ?>

                        <input id="pagination_current_page" type="hidden" name="current_row" value="<?php echo $departamentos['current_row']; ?>" />
                        <input id="pagination_limit" type="hidden" name="pagination_limit" value="<?php echo $departamentos['per_page']; ?>" />
                     <?php
                     } echo form_error_format('per_page'); ?>


      <p><p><p><?php echo 'Total: ' . $departamentos['total']; ?></p><br>
      Nota: para el uso de Ñ o ñ escribe &
  </div>    

  <div id="secHistorico">
                    <?php  
                    echo $paginacion['links'];
                    ?></p>


                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>CURP</th>                                
                                <th>Matrícula</th>
                                <th>Nombre completo</th>
                                <th>Correo</th>
                                <th>Delegación</th>
                                <th>Unidad</th>
                                <th>Categoría</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                             $mensaje = "";  
                         if($departamentos['data']>0){

                            if (empty($departamentos['data'])) 
                               {
                                $mensaje = "<h3>NO SE ENCONTRARON RESULTADOS</h3>";
                               } 

                            foreach ($departamentos['data'] as $row)
                            {
                                ?>
                                <tr>
                                    <td><?php echo $row['curp']; ?></td>                                   
                                    <td><?php echo $row['matricula']; ?></td>
            <td><?php echo $row['nombre'].' '.$row['apellido_paterno'].' '.$row['apellido_materno']; ?></td>
                                    <td><?php echo $row['correo']; ?></td>
                                    <td><?php echo $row['delegacion']; ?></td>
                                    <td><?php echo $row['unidad']; ?></td>
                                    <td><?php echo $row['categoria']; ?></td>
            <td><a href="<?php echo site_url().'/buscador/detalle/'.$row['matricula'].'/3'; ?>">Ver detalle</a></td>
                                </tr>
                           <?php
                              }

                            } else {

                              //echo "<h3>NO SE ENCONTRARON RESULTADO</h3>";

                             }
                             
                              echo $mensaje; 

                            ?>
                        </tbody>
                    </table>
                    <?php
                    if (isset($paginacion))
                    {
                        echo $paginacion['links'];
                    }
                    ?>

  </div>
</div>

