<?php
      if($actual['data']>0)
      {  
           foreach ($actual['data'] as $row1)
                   {

                   $matricula = $row1['matricula'];
                   $nombre =$row1['nombre'];
                   $apellido_paterno = $row1['apellido_paterno'];
                   $apellido_materno = $row1['apellido_materno'];   
                   $correo = $row1['correo'];
                   $curp=$row1['curp'];
                   $rfc=$row1['rfc'];  
                   $anti_anios =$row1['anti_anios'];
                   $delegacion =$row1['delegacion'];
                   $clave_delegacional =$row1['clave_delegacional'];
                   $tipo_nomina = $row1['tipo_nomina'];
                   $unidad = $row1['unidad'];
                   $clave_unidad= $row1['clave_unidad'];
                   $departamento= $row1['departamento'];
                   $categoria= $row1['categoria'];
                   $clave_categoria= $row1['clave_categoria'];
                   $genero=$row1['genero'];
                   }                   
       } 
?>
<div id="titulos" class="row">
  <h3>Histórico del usuario</h3>
</div>
<div id="secInfoGeneral" class="row">
  <div class="col-md-6">
    <h3 id="subtitulo">Información actual del usuario</h3>
    <br>
    <p><strong>Matrícula:</strong> <?php echo $matricula; ?></p>
    <p><strong>Nombre:</strong> <?php echo $nombre.' '.$apellido_paterno.' '.$apellido_materno; ?></p>
    <p><strong>Correo:</strong> <?php echo $correo; ?></p>
    <p><strong>CURP:</strong> <?php echo $curp; ?></p>
    <p><strong>RFC:</strong> <?php echo $rfc; ?></p>
    <p><strong>Antigüedad:</strong> <?php echo $anti_anios; ?> Años</p>
    <p><strong>Tipo de nómina:</strong> <?php echo $tipo_nomina; ?></p>

  </div>
  <div class="col-md-6">
    <br>
    <br>
    <br>
    <br>
    <p><strong>Delegación:</strong> <?php echo $delegacion.'  '.$clave_delegacional; ?> </p>
    <p><strong>Unidad:</strong> <?php echo $clave_unidad.' '.$unidad; ?> </p>
    <p><strong>Departamento:</strong> <?php echo $departamento; ?>  </p>
    <p><strong>Categoría:</strong> <?php echo $clave_categoria.' '.$categoria; ?> </p>
    <p><strong>Sexo:</strong> <?php echo $genero; ?>  </p>  
  </div>
</div>
<hr>
<div class="row">
    <h3 style="margin-bottom: 21px;">Historial &nbsp</h3>
    </div>     
<div class="row">
  <div id="historicoHeader">
  <div class="col-md-6">
    <!-- <strong>Año:</strong> --> 
      <?php
 /*  
        echo $this->form_complete->create_element(
        array('id' => 'anio',
            'type' => 'dropdown',
         'options' => $anios,
      'attributes' => array('name' => 'anio',
           'class' => 'form-control  form-control input-sm',
     'data-toggle' => 'tooltip',
  'data-placement' => 'top',
           'title' => 'Años')
                                        )
                                );
 */       
      ?>
    </div>  
    <div class="col-md-6">
    <!-- <strong>Mes:</strong> -->       
    <?php
    /*
        echo $this->form_complete->create_element(
        array('id' => 'mes',
            'type' => 'dropdown',
         'options' => $meses,
      'attributes' => array('name' => 'mes',
           'class' => 'form-control  form-control input-sm',
     'data-toggle' => 'tooltip',
  'data-placement' => 'top',
           'title' => 'Mes')
                                        )
                                );
        */
    ?>
    </div>
   </div>
  </div>
  <div class="row" align="right">

      <!--
      <p><p><p>Se debe seleccionar primero el año de busqueda y después el mes para que la busqueda le muestre resultados.</p><br> 
      -->
       
    <a href="<?php echo site_url().'/buscador/exportar_datos_user/'.$matricula.'/3'; ?>"> Exportar</a>
  </div>    
  <div id="cargador" style="display:none;">
    <div id="ajax_loader" align="center" style="padding-top:50px;"><img src="<?php //echo base_url('assets/img/cargador.gif'); ?>" alt="Cargando..." title="Cargando..." /></div>
  </div>
  <div id="secHistorico">
<script src="<?php //echo asset_url(); ?>js/detalle/detalle.js"></script>
 <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tipo Nom.</th> 
                                <th>CURP</th>                                
                                <th>Matrícula</th>
                                <th>Nombre completo</th>
                                <th>Correo</th>
                                <th>Delegación</th>
                                <th>Unidad</th>
                                <th>Categoría</th>
                                <th>Año</th>
                                <th>Mes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                          if($actual['detal']>0){  
                             foreach ($actual['detal'] as $row)
                                     {
                             
                             ?>
                                <tr>
                                    <td><?php echo $row['tipo_nomina']; ?></td>
                                    <td><?php echo $row['curp']; ?></td>                                   
                                    <td><?php echo $row['matricula']; ?></td>
            <td><?php echo $row['nombre'].' '.$row['apellido_paterno'].' '.$row['apellido_materno']; ?></td>
                                    <td><?php echo $row['correo']; ?></td>
                                    <td><?php echo $row['delegacion']; ?></td>
                                    <td><?php echo $row['unidad']; ?></td>
                                    <td><?php echo $row['categoria']; ?></td>
                                    <td><?php echo $row['anio']; ?></td>
                                    <td><?php echo $row['mes']; ?></td>
                                </tr>
                                <?php

                                 }

                            ?>
                        </tbody>
                    </table>

<?php
    }else{
?>
      <h1>NO SE ENCONTRARON RESULTADO</h1>
<?php
    }
?>
    


  </div>
</div>


