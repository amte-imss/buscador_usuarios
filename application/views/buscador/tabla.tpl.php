<div id="secInformacionBusqueda">
  <p><strong>Resultado de la búsqueda: </strong></p>
</div>
<div class="pagination">
  <?php echo $paginacion; ?>
</div>
<?php
if(count($resultado) > 0){
  if(isset($resultado['general']) && isset($resultado['avanzada'])){
    if(count($resultado['general']) > 0 ){
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
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($resultado['general'] as $value)
          {
          ?>
            <tr class='clickable-row' data-href="<?php echo site_url().'/buscador/index/'.$value['matricula']; ?>" style="cursor:pointer;">
              <td><?php echo $value['matricula'];?></td>
              <td><?php echo $value['nombre'].' '.$value['apellido_paterno'].' '.$value['apellido_materno'];?></td>
              <td><?php if($value['correo'] == ''){echo $value['correo'];}else{echo $value['correo'].'@imss.gob.mx';}?></td>
              <td><?php echo $value['delegacion'];?></td>
              <td><?php echo $value['unidad'];?></td>
              <td><?php echo $value['categoria'];?></td>
              <td><a href="<?php echo site_url().'/buscador/index/'.$value['matricula']; ?>">Ver detalle</a></td>
            </tr>
          <?php
          } ?>
        </tbody>
      </table>
<?php
    }else{
      if(count($resultado['avanzada']) > 0){
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
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($resultado['avanzada'] as $value)
            {
            ?>
              <tr class='clickable-row' data-href="<?php echo site_url().'/buscador/index/'.$value['matricula']; ?>" style="cursor:pointer;">
                <td><?php echo $value['matricula'];?></td>
                <td><?php echo $value['nombre'].' '.$value['apellido_paterno'].' '.$value['apellido_materno'];?></td>
                <td><?php if($value['correo'] == ''){echo $value['correo'];}else{echo $value['correo'].'@imss.gob.mx';}?></td>
                <td><?php echo $value['delegacion'];?></td>
                <td><?php echo $value['unidad'];?></td>
                <td><?php echo $value['categoria'];?></td>
                <td><a href="<?php echo site_url().'/buscador/index/'.$value['matricula']; ?>">Ver detalle</a></td>
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
    }
?>

<?php
  }else{
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
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($resultado as $value)
        {
        ?>
          <tr class='clickable-row' data-href="<?php echo site_url().'/buscador/index/'.$value['matricula']; ?>" style="cursor:pointer;">
            <td><?php echo $value['matricula'];?></td>
            <td><?php echo $value['nombre'].' '.$value['apellido_paterno'].' '.$value['apellido_materno'];?></td>
            <td><?php if($value['correo'] == ''){echo $value['correo'];}else{echo $value['correo'].'@imss.gob.mx';}?></td>
            <td><?php echo $value['delegacion'];?></td>
            <td><?php echo $value['unidad'];?></td>
            <td><?php echo $value['categoria'];?></td>
            <td><a href="<?php echo site_url().'/buscador/index/'.$value['matricula']; ?>">Ver detalle</a></td>
          </tr>
        <?php
        } ?>
      </tbody>
    </table>
<?php
  }
?>
<?php
}else{
?>
 <h1>NO SE ENCONTRARON RESULTADO</h1>
<?php
}
?>
<script>
  jQuery(document).ready(function($) {
      $(".clickable-row").click(function() {
          window.location = $(this).data("href");
      });
  });
</script>