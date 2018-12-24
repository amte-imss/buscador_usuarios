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
                                <th>Año</th>
                                <th>Mes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                          if(isset($complemento_info) && count($complemento_info) > 0){  
                             foreach ($complemento_info as $key_matricula => $row)
                                     {
                             
                             ?>
                                <tr>
                                    
                    <td><?php echo (isset($row['tipo_nomina']))?$row['tipo_nomina']:'Sin Resultado'; ?></td>
                    <td><?php echo (isset($row['curp']))?$row['curp']:''; ?></td>
                    <td><?php echo (isset($row['matricula']))?$row['matricula']:$key_matricula; ?></td>
                    <td><?php echo (isset($row['nombre']))?$row['nombre']:''; ?> 
                        <?php echo (isset($row['apellido_paterno']))?$row['apellido_paterno']:''; ?>
                        <?php echo (isset($row['apellido_materno']))?$row['apellido_materno']:''; ?>
                    </td>
                    <td><?php echo (isset($row['correo']))?$row['correo']:''; ?></td>
            <td><?php echo (isset($row['delegacion']))?$row['delegacion']:''; ?></td>
            <td><?php echo (isset($row['unidad']))?$row['unidad']:''; ?></td>
            <td><?php echo (isset($row['categoria']))?$row['categoria']:''; ?></td>
            <td><?php echo (isset($row['anio']))?$row['anio']:''; ?></td>
            <td><?php echo (isset($row['mes']))?$row['mes']:''; ?></td>
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


