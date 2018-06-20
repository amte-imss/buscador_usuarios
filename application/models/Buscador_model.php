<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Buscador_model extends MY_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /**
     * Función que realiza la busqueda conforme a los filtros
     * @author Cheko
     * @date 14/06/2018
     * @return array $resultado resultado de la busqueda
     */
     public function obtener_busqueda($tipo="",$busqueda="",$filtros = []){
       switch ($tipo) {
         case 'matricula':
           $filtros['matricula'] = $busqueda;
           return $this->obtener_usuarios($filtros,"general");
           break;
         case 'correo':
           $filtros['dat_valpar'] = explode("@",$busqueda)[0];
           return $this->obtener_usuarios($filtros,"general");
           break;
         case 'nombre':
           $filtros['P.nombre'] = $busqueda;
           $filtros['P.apellido_paterno'] = $busqueda;
           $filtros['P.apellido_materno'] = $busqueda;
           return $this->obtener_usuarios($filtros,"avanzada");
         case 'delegacion':
           $filtros['D.nombre'] = $busqueda;
           $filtros['D.nombre_grupo_delegacion'] = $busqueda;
           return $this->obtener_usuarios($filtros,"avanzada");
         case 'unidad':
           $filtros['U.nombre'] = $busqueda;
           return $this->obtener_usuarios($filtros,"general");
         case 'departamento':
           $filtros['DP.nombre'] = $busqueda;
           return $this->obtener_usuarios($filtros,"general");
         case 'categoria':
           $filtros['C.nombre'] = $busqueda;
           return $this->obtener_usuarios($filtros,"general");
         case 'avanzada':
           $filtros_query = [];
           if(isset($filtros['limit']) && isset($filtros['offset'])){
               $filtros_query['limit'] = $filtros['limit'];
               $filtros_query['offset'] = $filtros['offset'];
           }

           if(isset($filtros['correo'])){
             $filtros_query['dat_valpar'] = explode("@",$filtros['correo'])[0];
           }
           if(isset($filtros['matricula'])){
             $filtros_query['P.matricula'] = $filtros['matricula'];
           }
           if(isset($filtros['nombre'])){
             $filtros_query['P.nombre'] = $filtros['nombre'];
           }
           if(isset($filtros['apellido_paterno'])){
              $filtros_query['P.apellido_paterno'] = $filtros['apellido_paterno'];
           }
           if(isset($filtros['apellido_paterno'])){
             $filtros_query['P.apellido_paterno'] = $filtros['apellido_paterno'];
           }
           if(isset($filtros['departamento'])){
             $filtros_query['DP.clave_departamental'] = $filtros['departamento'];
           }
           if(isset($filtros['categoria'])){
             $filtros_query['C.id_categoria'] = $filtros['categoria'];
           }
           if(isset($filtros['delegacion'])){
             $filtros_query['D.id_delegacion'] = $filtros['delegacion'];
           }
           if(isset($filtros['unidad'])){
             $filtros_query['U.clave_unidad'] = $filtros['unidad'];
           }
           $general = $this->obtener_usuarios($filtros_query,"general");
           $avanzada = $this->obtener_usuarios($filtros_query,"avanzada");
           $resultado['general'] = $general;
           $resultado['avanzada'] = $avanzada;
           return $resultado;
         default:
           return $this->obtener_usuarios($filtros,"avanzada");
           break;
       }
       return $this->obtener_usuarios($filtros,"general");
     }

     /**
      * Función que obtiene los usuarios
      * dependiendo los filtros y el tipo de
      * busqueda (avanzada, general)
      * @author Cheko
      * @date 14/06/2018
      * @param array $filtros para la busqueda de usuarios
      * @param string $tipo_buscador el tipo de buscador (avanzada o general)
      * @return array $resultado resultado del resultado de la consulta
      *
      */
     private function obtener_usuarios($filtros = [], $tipo_buscador=""){
         $this->db->reset_query();
         $select = array('P.matricula','P.nombre','P.apellido_paterno','P.apellido_materno','P.dat_valpar correo','U.nombre unidad'
         ,'D.nombre_grupo_delegacion delegacion','C.nombre categoria','DP.nombre departamento');
         $this->db->select($select);
         $this->db->join('catalogo.unidad U', 'U.clave_unidad = P.clave_unidad', 'left');
         $this->db->join('catalogo.delegaciones D', 'D.id_delegacion = U.id_delegacion', 'left');
         $this->db->join('catalogo.categorias C', 'C.clave_categoria = P.clave_puesto', 'left');
         $this->db->join('catalogo.departamento DP', 'DP.clave_departamental = P.clave_depto', 'left');
         if($tipo_buscador == "general"){
           if (!is_null($filtros) && !empty($filtros)) {
               foreach ($filtros as $key => $value) {
                    if($key == 'P.nombre' || $key == 'P.apellido_paterno' || $key == 'P.apellido_materno' ||
                      $key == 'D.nombre' || $key == 'D.nombre_grupo_delegacion' || $key == 'U.nombre' || $key == 'DP.nombre' ||
                      $key == 'C.nombre' || $key == 'dat_valpar'){
                      $this->db->or_like($key,$value);
                    }else{
                      if($key != 'limit' && $key != 'offset'){
                          $this->db->where($key, $value);
                      }
                    }
               }
           }
         }
         if($tipo_buscador == "avanzada"){
           if (!is_null($filtros) && !empty($filtros)) {
               foreach ($filtros as $key => $value) {
                   if($key != 'limit' && $key != 'offset'){
                     if($key == 'P.nombre' || $key == 'P.apellido_paterno' || $key == 'P.apellido_materno' || $key == 'dat_valpar'){
                       $this->db->or_like($key,$value);
                     }else{
                       $this->db->or_where($key, $value);
                     }
                   }
               }
           }
         }
         $this->db->order_by("P.matricula", "desc");
         if(isset($filtros['limit']) && isset($filtros['offset'])){
           $resultado = $query = $this->db->get_where('nomina.concentrado_nomina P',[],$filtros['limit'],$filtros['offset']);
         }else{
           $resultado = $this->db->get('nomina.concentrado_nomina P');
         }
         //pr($this->db->last_query());
         $this->db->reset_query();
         return $resultado->result_array();
     }

     /**
      * Función que obtiene el historico
      * de un usuario
      * @author Cheko
      * @date 18/06/2018
      * @param type $matricula, matricula del usuario
      * @param array $filtros, filtrod para buscar el usuario
      * @return array $resultado arreglo de datos de historico de un usuario
      *
      */
     public function obtener_info_usuario($filtros=NULL){
       $this->db->reset_query();
       $select = array('P.matricula','P.nombre','P.apellido_paterno','P.apellido_materno','P.dat_valpar correo','P.curp','P.rfc','U.nombre unidad'
       ,'D.nombre_grupo_delegacion delegacion','C.nombre categoria','DP.nombre departamento', 'P.mes', 'P.anio');
       $this->db->select($select);
       $this->db->join('catalogo.unidad U', 'U.clave_unidad = P.clave_unidad', 'left');
       $this->db->join('catalogo.delegaciones D', 'D.id_delegacion = U.id_delegacion', 'left');
       $this->db->join('catalogo.categorias C', 'C.clave_categoria = P.clave_puesto', 'left');
       $this->db->join('catalogo.departamento DP', 'DP.clave_departamental = P.clave_depto', 'left');

       if (!is_null($filtros) && !empty($filtros)) {
           foreach ($filtros as $key => $value) {
               $this->db->where($key, $value);
           }
       }

       $this->db->order_by("P.anio", "desc");
       $this->db->order_by("P.mes", "desc");

       $resultado = $this->db->get('nomina.concentrado_nomina P');
       $this->db->reset_query();
       return $resultado->result_array();
     }
}
