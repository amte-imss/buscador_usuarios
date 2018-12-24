<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Catalogo_model
 *
 * @author chrigarc
 */
class Buscador_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

     public function get_busqueda_detalle($filtros = array())
     {

       $this->db->start_cache();
        $select = array('P.matricula','P.nombre','P.apellido_paterno','P.apellido_materno','P.dat_valpar correo','P.curp','U.nombre unidad'
           ,'U.clave_unidad','D.nombre_grupo_delegacion delegacion','D.clave_delegacional','C.nombre categoria','C.clave_categoria','DP.nombre departamento','P.tipo_nomina','P.rfc','P.tipo_nomina','P.genero','P.anti_anios','P.mes');
        $this->db->select($select);
        $this->db->distinct();
        $this->db->join('catalogo.unidad U', 'U.clave_unidad = P.clave_unidad', 'left');
        $this->db->join('catalogo.delegaciones D', 'D.id_delegacion = U.id_delegacion', 'left');
        $this->db->join('catalogo.categorias C', 'C.clave_categoria = P.clave_puesto', 'left');
        $this->db->join('catalogo.departamento DP', 'DP.clave_departamental = P.clave_depto', 'left');
        $this->db->where('P.matricula',$filtros['matricula']);
        $rbusquedadet['data'] = $this->db->get('nomina.concentrado_nomina P')->result_array(); 
        #
        $this->db->stop_cache();
        $this->db->select(array('P.matricula','P.nombre','P.apellido_paterno','P.apellido_materno','P.dat_valpar correo','P.curp','U.nombre unidad'
           ,'U.clave_unidad','D.nombre_grupo_delegacion delegacion','D.clave_delegacional','C.nombre categoria','C.clave_categoria','DP.nombre departamento',
           "CASE ".'"'.'P'.'"."'.'mes'.'"'." WHEN  1  THEN 'Enero' ". 
                                           " WHEN  2  THEN 'Febrero' ".
                                           " WHEN  3  THEN 'Marzo' ".
                                           " WHEN  4  THEN 'Abril' ". 
                                           " WHEN  5  THEN 'Mayo' ".
                                           " WHEN  6  THEN 'Junio' ".
                                           " WHEN  7  THEN 'Julio' ".
                                           " WHEN  8  THEN 'Agosto' ".
                                           " WHEN  9  THEN 'Septiembre' ".
                                          " WHEN  10  THEN 'Octubre' ".
                                          " WHEN  11  THEN 'Noviembre' ".
                                          " WHEN  12  THEN 'Diciembre' ".
           "END AS mes",'P.anio'));
        $this->db->distinct();
        $this->db->join('catalogo.unidad U', 'U.clave_unidad = P.clave_unidad', 'left');
        $this->db->join('catalogo.delegaciones D', 'D.id_delegacion = U.id_delegacion', 'left');
        $this->db->join('catalogo.categorias C', 'C.clave_categoria = P.clave_puesto', 'left');
        $this->db->join('catalogo.departamento DP', 'DP.clave_departamental = P.clave_depto', 'left');
        $this->db->where('P.matricula',$filtros['matricula']);
           $this->db->order_by('P.mes', 'DESC');
        $this->db->stop_cache();
        $rbusquedadet['detal'] = $this->db->get('nomina.concentrado_nomina P')->result_array(); 
        $this->db->reset_query();

        $this->db->distinct();

        $sql_string = $this->db->get_compiled_select('nomina.concentrado_nomina P');

        $rbusquedadet['total'] = $this->db->query('select "count"(*) as total from ('.$sql_string.') as t')->result_array()[0]['total'];


 //      pr($rbusquedadet);
//        exit();
        return $rbusquedadet;

     }



public function get_busqueda_general($filtros = array())
    {

        $this->db->flush_cache();
        $this->db->reset_query();

        if (isset($filtros['per_page']) && $filtros['current_row'])
        {
            $this->db->limit($filtros['per_page'], $filtros['current_row'] * $filtros['per_page']);
        } else if (isset($filtros['per_page']))
        {
            $this->db->limit($filtros['per_page']);
        }

        if (isset($filtros['order']) && $filtros['order'] == 2)
        {
            $this->db->order_by('P.matricula', 'DESC');
        } else
        {
            $this->db->order_by('P.matricula', 'ASC');
        }

        $this->db->start_cache();
        $select = array('P.matricula','P.nombre','P.apellido_paterno','P.apellido_materno','P.dat_valpar correo','P.curp','U.nombre unidad'
           ,'U.clave_unidad','D.nombre_grupo_delegacion delegacion','D.clave_delegacional','C.nombre categoria','C.clave_categoria','DP.nombre departamento');
        $this->db->select($select);
        $this->db->distinct();
        $this->db->join('catalogo.unidad U', 'U.clave_unidad = P.clave_unidad', 'left');
        $this->db->join('catalogo.delegaciones D', 'D.id_delegacion = U.id_delegacion', 'left');
        $this->db->join('catalogo.categorias C', 'C.clave_categoria = P.clave_puesto', 'left');
        $this->db->join('catalogo.departamento DP', 'DP.clave_departamental = P.clave_depto', 'left');

/*
          if(!empty($filtros['type'])){
             $this->db->where('P.nombre',strtoupper($filtros['keyword']));
            } 
          if(!empty($filtros['apellido_paterno'])){
             $this->db->where('P.apellido_paterno',strtoupper($filtros['apellido_paterno']));
            } 
          if(!empty($filtros['apellido_materno'])){
             $this->db->where('P.apellido_materno',strtoupper($filtros['apellido_materno']));
            } 

           if(!empty($filtros['type'])=='curp' && !empty($filtros['keyword']))
              {
                $this->db->where($type,strtoupper($filtros['keyword']));
              }

*/



        switch ($filtros['type'])
               {

                case 'nombre': $type = 'P.nombre';

                if(!empty($filtros['keyword']))
                  {
                $this->db->where($type,strtoupper($filtros['keyword']));
                  } 
                if(!empty($filtros['apellido_paterno']))
                  {
                $this->db->where('P.apellido_paterno',strtoupper($filtros['apellido_paterno']));
                  } 
                if(!empty($filtros['apellido_materno']))
                  {
                $this->db->where('P.apellido_materno',strtoupper($filtros['apellido_materno']));
                  } 
                break;  

                case 'curp': 

                  if(!empty($filtros['keyword']))
                    {
                $this->db->where('P.curp',strtoupper($filtros['keyword']));
                    }

                break;

                case 'matricula': $type = 'P.matricula';
                $this->db->where($type,strtoupper($filtros['keyword']));
                    break;       
  
               }
              




          #  
            $this->db->stop_cache();
            $rbusquedag['data'] = $this->db->get('nomina.concentrado_nomina P')->result_array(); 
            $this->db->reset_query();
            $this->db->distinct();
            $sql_string = $this->db->get_compiled_select('nomina.concentrado_nomina P');
            $rbusquedag['total'] = $this->db->query('select "count"(*) as total from ('.$sql_string.') as t')->result_array()[0]['total'];
          #
            $rbusquedag['per_page'] = $filtros['per_page'];
            $rbusquedag['current_row'] = $filtros['current_row'];
            $this->db->flush_cache();
            $this->db->reset_query();
            

           //pr($rbusquedag);
           //exit();
            return $rbusquedag;
    }
    

     public function get_bavanzasa($filtros = array())
    {

        $this->db->flush_cache();
        $this->db->reset_query();

        if (isset($filtros['per_page']) && $filtros['current_row'])
        {
            $this->db->limit($filtros['per_page'], $filtros['current_row'] * $filtros['per_page']);
        } else if (isset($filtros['per_page']))
        {
            $this->db->limit($filtros['per_page']);
        }

        if (isset($filtros['order']) && $filtros['order'] == 2)
        {
            $this->db->order_by('P.matricula', 'DESC');
        } else
        {
            $this->db->order_by('P.matricula', 'ASC');
        }
        
        $this->db->start_cache();
        $select = array('P.matricula','P.nombre','P.apellido_paterno','P.apellido_materno','P.dat_valpar correo','P.curp','U.nombre unidad'
           ,'U.clave_unidad','D.nombre_grupo_delegacion delegacion','D.clave_delegacional','C.nombre categoria','C.clave_categoria','DP.nombre departamento','C.id_categoria');
        $this->db->select($select);
        $this->db->distinct();
        $this->db->join('catalogo.unidad U', 'U.clave_unidad = P.clave_unidad', 'left');
        $this->db->join('catalogo.delegaciones D', 'D.id_delegacion = U.id_delegacion', 'left');
        $this->db->join('catalogo.categorias C', 'C.clave_categoria = P.clave_puesto', 'left');
        $this->db->join('catalogo.departamento DP', 'DP.clave_departamental = P.clave_depto', 'left');

         if(!empty($filtros['curp'])){
             $this->db->where('P.curp',strtoupper($filtros['curp']));
            } 
         if(!empty($filtros['matricula'])){
             $this->db->where('P.matricula',$filtros['matricula']);
            } 
         if(!empty($filtros['delegacion'])){
             $this->db->where('U.id_delegacion',$filtros['delegacion']);
            }   
         if(!empty($filtros['unidad'])){
             $this->db->where('U.clave_unidad',$filtros['unidad']);
            } 
         if(!empty($filtros['categorias'])){
             $this->db->where('C.id_categoria',$filtros['categorias']);
            } 
          if(!empty($filtros['nombre'])){
             $this->db->where('P.nombre',strtoupper($filtros['nombre']));
            } 
          if(!empty($filtros['apellido_paterno'])){
             $this->db->where('P.apellido_paterno',strtoupper($filtros['apellido_paterno']));
            } 
          if(!empty($filtros['apellido_materno'])){
             $this->db->where('P.apellido_materno',strtoupper($filtros['apellido_materno']));
            } 
        
        $this->db->stop_cache();
        $rbusquedav['data'] = $this->db->get('nomina.concentrado_nomina P')->result_array(); 
        $this->db->reset_query();
        $this->db->distinct();
        $sql_string = $this->db->get_compiled_select('nomina.concentrado_nomina P');
        $rbusquedav['total'] = $this->db->query('select "count"(*) as total from ('.$sql_string.') as t')->result_array()[0]['total'];
        #
        $rbusquedav['per_page'] = $filtros['per_page'];
        $rbusquedav['current_row'] = $filtros['current_row'];
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->flush_cache();
        $this->db->reset_query();

        return $rbusquedav;
    }

     /**
      * Función que obtiene todas las delegaciones existentes
      * del catálogo por la region
      * @author Lima
      * @param string $region la region que se a pedido
      * @return array $estado estado de la repuesta al obtener
      * el listado de las delegaciones
      */
      public function ms_del_bd($delegacion)
      {
          $estado = array('success' => false, 'message' => 'No se obtuvo el listado', 'datos'=>[]);
          $unida_del = [];
          $this->db->flush_cache();
          $this->db->reset_query();
          try
          {
                $resultado = $this->db->query(
                  "SELECT I.clave_unidad,I.nombre,I.id_delegacion FROM catalogo.unidad I
                    WHERE I.id_delegacion = ".$delegacion." 
                 ORDER BY I.nombre");

             $unida_del = $resultado->result_array();
             $estado['success'] = true;
             $estado['message'] = "Se obtuvo el listado delas regiones con exito";
             array_push($unida_del, array('id_delegacion'=>"Todos",'delegacion'=>'Todos'));
             $estado['datos'] = $unida_del;

          }catch(Exception $ex)
          {
             $estado['datos'] = $ex;
          }
          return $estado;
      }

     /**
      * Función que obtiene todas las delegaciones existentes
      * del catálogo por la region
      * @author Lima
      * @param string $region la region que se a pedido
      * @return array $estado estado de la repuesta al obtener
      * el listado de las delegaciones
      */

    public function get_content_csv()
    {
        $file_data = $this->upload->data();     //BUSCAMOS LA INFORMACIÓN DEL ARCHIVO CARGADO
        $file_path = './uploads/' . $file_data['file_name'];         // CARGAMOS LA URL DEL ARCHIVO
        $csv_array = $this->csvimport->get_array($file_path);   //SI EXISTEN DATOS, LOS CARGAMOS EN LA VARIABLE
        return $csv_array;
    }


    public function valid_csv(&$contenido)
    {
        $salida['status'] = true;
        $headers = array(
            'matricula', 'curp'
        );
        foreach ($headers as $h)
        {
            if (!isset($contenido[0][$h]))
            {
                $salida['status'] = true;
            }
        }
        return $salida;
    }


public function buscar_csv_bd(&$contenido)
    {

        $resultado['result'] = true;
        $resultado['data'] = [];
/*
        if($filtros['tipo_b'] == 1)
        {
          */
            foreach ($contenido as $row)
            {
             $matricula[$row['matricula']] = $row['matricula'];
            }

            $bucar_matricula = $this->buscar_en_nomina($matricula);
            
            foreach ($bucar_matricula as $value) 
            {
             $maten[$value['matricula']] = $value;
            }
        //}
        /*

        if($filtros['tipo_b'] == 2)
        {
            foreach ($contenido as $row)
            {
             $matricula[$row['﻿curp']] = $row['﻿curp'];
            }

            $bucar_matricula = $this->buscar_en_nomina($matricula,$filtros);
            
            foreach ($bucar_matricula as $value) 
            {
             $maten[$value['﻿curp']] = $value;
            }
        }
        */

    $resultado['data'] = $maten + $matricula;
    $resultado['maten'] = $maten;

    return $resultado;

   }

public function buscar_csv_curp(&$contenido)
    {

        $resultado['result'] = true;
        $resultado['data'] = [];


            foreach ($contenido as $row)
            {
             $matricula[$row['﻿curp']] = $row['﻿curp'];
            }

            $bucar_matricula = $this->buscar_curp_bd($matricula);


            foreach ($bucar_matricula as $value) 
            {
             $maten[$value['curp']] = $value;
            }
            

    $resultado['data'] = $maten + $matricula;
    $resultado['maten'] = $maten;

    return $resultado;

   }   

   public function buscar_en_nomina(&$matricula)
   {
           
        /*   
        if($filtros['tipo_b'] == 1)
          {
            $buscarx = 'P.matricula';
            $this->db->select(array('P.matricula','P.nombre','P.apellido_paterno','P.apellido_materno','P.dat_valpar correo','P.curp','U.nombre unidad'
           ,'U.clave_unidad','D.nombre_grupo_delegacion delegacion','D.clave_delegacional','C.nombre categoria','C.clave_categoria','DP.nombre departamento','P.tipo_nomina','P.anio','P.mes'));

          }  

         if($filtros['tipo_b'] == 2)
          {
            $buscarx = 'P.curp';
            $this->db->select(array('P.curp','P.nombre','P.apellido_paterno','P.apellido_materno','P.dat_valpar correo','P.matricula','U.nombre unidad'
           ,'U.clave_unidad','D.nombre_grupo_delegacion delegacion','D.clave_delegacional','C.nombre categoria','C.clave_categoria','DP.nombre departamento','P.tipo_nomina','P.anio','P.mes'));
          }  

          */

          $this->db->select(array('P.matricula','P.nombre','P.apellido_paterno','P.apellido_materno','P.dat_valpar correo','P.curp','U.nombre unidad'
           ,'U.clave_unidad','D.nombre_grupo_delegacion delegacion','D.clave_delegacional','C.nombre categoria','C.clave_categoria','DP.nombre departamento','P.tipo_nomina','P.anio','P.mes'));
         $this->db->distinct();
         $this->db->join('catalogo.unidad U', 'U.clave_unidad = P.clave_unidad', 'left');
         $this->db->join('catalogo.delegaciones D', 'D.id_delegacion = U.id_delegacion', 'left');
         $this->db->join('catalogo.categorias C', 'C.clave_categoria = P.clave_puesto', 'left');
         $this->db->join('catalogo.departamento DP', 'DP.clave_departamental = P.clave_depto', 'left');
         $this->db->where_in('P.matricula',$matricula);
         $resultado = $this->db->get('nomina.concentrado_nomina P')->result_array();


         return  $resultado;
     }


   public function buscar_curp_bd(&$matricula)
   {
          $this->db->select(array('P.curp','P.nombre','P.apellido_paterno','P.apellido_materno','P.dat_valpar correo','P.matricula','U.nombre unidad'
           ,'U.clave_unidad','D.nombre_grupo_delegacion delegacion','D.clave_delegacional','C.nombre categoria','C.clave_categoria','DP.nombre departamento','P.tipo_nomina','P.anio','P.mes'));
         $this->db->distinct();
         $this->db->join('catalogo.unidad U', 'U.clave_unidad = P.clave_unidad', 'left');
         $this->db->join('catalogo.delegaciones D', 'D.id_delegacion = U.id_delegacion', 'left');
         $this->db->join('catalogo.categorias C', 'C.clave_categoria = P.clave_puesto', 'left');
         $this->db->join('catalogo.departamento DP', 'DP.clave_departamental = P.clave_depto', 'left');
         $this->db->where_in('P.curp',$matricula);
         $resultado = $this->db->get('nomina.concentrado_nomina P')->result_array();


         return  $resultado;
     }




}
