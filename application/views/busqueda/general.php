<?php echo js('paginacion/general.js'); ?>
<?php
      echo form_open('buscador/busqueda_general/', array('id' => 'form_paginacion'));
?>
<div id="titulos" class="row">
  <h3>Busqueda General</h3>
</div>
<div id="secInfoGeneral" class="row">
  <div class="col-md-6">
    <h3 id="subtitulo">Información actual del usuario</h3>
    <br>
                            <div class="input-group">
                                <div class="input-group-btn">

<button id="btn-filtro-tablero" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<?php echo (isset($type) && !is_null($type)) ? $type : 'curp'; ?>    
<span class="caret"></span>
</button>
                                    <ul class="dropdown-menu">
            <li><a class="option-input-tablero" data-id="curp" href="#">CURP</a></li>
            <li><a class="option-input-tablero" data-id="matricula" href="#">Matrícula</a></li>
            <li><a class="option-input-tablero" data-id="nombre" href="#">Nombre(s)</a></li>
                                    </ul>

                                </div><!-- /btn-group -->
<input type="text" class="form-control" aria-label="..." name="keyword" 
value="<?php echo (isset($keyword) && !is_null($keyword)) ? $keyword : ''; ?>">

<input type="hidden" id="filtro_texto" name="filtro_texto" 
    value="<?php echo (isset($type) && !is_null($type)) ? $type : 'curp'; ?>">
                            </div><!-- /input-group -->
 
    <label id="lape_pat" name="lape_pat" style="display:none;"><p><strong>Apellido Paterno: </strong></label> 
    <input type="text" id="apellido_paterno" name="apellido_paterno"  style="display:none;"
    value="">
    <label id="lape_mat" name="lape_mat" style="display:none;"><p><strong>Apellido Materno: </strong></label>
    <input type="text" id="apellido_materno" name="apellido_materno"  style="display:none;"
    value="">
    

    <p><strong>Número de registros a mostrar:</strong> 
                                <?php
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
    <p><strong>Tipo de orden:</strong> 

                                <?php
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
                     } 
                     echo form_error_format('per_page'); ?>


      <p><p><p><?php echo 'Total: ' . $departamentos['total']; ?></p><br>
  </div>   
  <div id="cargador" >
     
 
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

                                 }else{

                                     //echo "<h1>NO SE ENCONTRARON RESULTADO</h1>";
                                      
          

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
                        </tbody>
                    </table>

  </div>
</div>

