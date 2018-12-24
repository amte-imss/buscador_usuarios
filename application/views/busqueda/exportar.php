<meta charset="UTF-8">
<div id="secHistorico">
 <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tipo Nom.</th> 
                                <th>CURP</th>                                
                                <th>Matricula</th>
                                <th>Nombre completo</th>
                                <th>Correo</th>
                                <th>Delegacion</th>
                                <th>Unidad</th>
                                <th>Categoria</th>
                                <th><?php echo 'Año'; ?></th>
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


