<script src="<?php echo asset_url(); ?>js/detalle/detalle.js"></script>
<?php
  if(isset($historico)){
    if(count($historico) > 0){
?>
      <table class="table table-hover" style="margin-bottom:100px;">
        <thead>
          <tr>
            <th scope="col">Matrícula</th>
            <th scope="col">Nombre completo</th>
            <th scope="col">Correo</th>
            <th scope="col">Delegación</th>
            <th scope="col">Unidad</th>
            <th scope="col">Categoría</th>
            <th scope="col">Departamento</th>
            <th scope="col">Mes</th>
            <th scope="col">Año</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($historico as $value)
          {
          ?>
            <tr class='clickable-row'>
              <td><?php echo $value['matricula'];?></td>
              <td><?php echo $value['nombre'].' '.$value['apellido_paterno'].' '.$value['apellido_materno'];?></td>
              <td><?php if($value['correo'] == ''){echo $value['correo'];}else{echo $value['correo'].'@imss.gob.mx';}?></td>
              <td><?php echo $value['delegacion'];?></td>
              <td><?php echo $value['unidad'];?></td>
              <td><?php echo $value['categoria'];?></td>
              <td><?php echo $value['departamento'];?></td>
              <td><?php echo obtener_mes($value['mes']);?></td>
              <td><?php echo $value['anio'];?></td>
            </tr>
          <?php
          } ?>
        </tbody>
      </table>

<?php
    }else{
?>
      <h1>NO SE ENCONTRARON RESULTADO</h1>
<?php
    }
  }else{
?>
      <h1>NO SE ENCONTRARON RESULTADO</h1>
<?php
  }
?>
