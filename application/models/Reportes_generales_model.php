<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes_generales_model extends MY_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /**
    * Devuelve el total de aceptados para cartel y oratoria
    * @author AlesSpock
    * @date 06/06/2018
    * @return array
    **/
    public function total_exposiciones(){
      $this->db->flush_cache();
      $this->db->reset_query();
      $this->db->select(array('sugerencia', 'count(folio)'));
      $this->db->from('foro.dictamen');
      $this->db->where('sugerencia is not null', NULL, false);
      $this->db->group_by('sugerencia');
      $result = $this->db->get();
      // pr($result);
      return $result->result_array();
    }

    /**
    * Devuelve el total de rechazados y evaluados
    * @author AlesSpock
    * @date 06/06/2018
    * @return array
    **/

    public function total_rechazados_exposiciones(){
      $this->db->flush_cache();
      $this->db->reset_query();
      $this->db->select(array('count(folio)'));
      $this->db->from('foro.dictamen d');
      $this->db->where('aceptado = false');
      $result = $this->db->get();
      return $result->result_array();
    }

    /**
    * Devuelve el total de trabajos que no son de temas relacionados a la educación
    * @author AlesSpock
    * @date 06/06/2018
    * @return array
    **/
    public function total_rechazados_no_tema_educacion(){
      $this->db->flush_cache();
      $this->db->reset_query();
      $this->db->select(array('count (distinct rev.folio)'));
      $this->db->from('foro.revision rev');
      //$this->db->join("foro.historico_revision hr","on", "rev.folio=hr.folio and hr.clave_estado='rechazado'","inner", false);
      $this->db->join("foro.historico_revision hr", "rev.folio=hr.folio and hr.clave_estado='rechazado'","inner", false);
      $this->db->where('tema_educacion=false and revisado=true and rev.activo=true');
      $result = $this->db->get();
      return $result->result_array();
    }

    /**
    * Devuelve el total de registros por pais
    * @author AlesSpock
    * @date 06/06/2018
    * @return array
    **/

    public function total_nac_ext(){

      $this->db->flush_cache();
      $this->db->reset_query();
      $select = array(
          "sum(case when iu.clave_pais = 'MX' then 1 else 0 end) as trabajos_nacionales",
          "sum(case when iu.clave_pais <> 'MX' then 1 else 0 end) as trabajos_extranjeros"
      );
      $this->db->select($select);
      $this->db->join("foro.dictamen d", "d.folio = ti.folio", "inner");
      $this->db->join("foro.autor au", "au.folio_investigacion = ti.folio and au.registro", "inner", false);
      $this->db->join("sistema.informacion_usuario iu", "iu.id_informacion_usuario = au.id_informacion_usuario", "inner");
      $result = $this->db->get("foro.trabajo_investigacion ti")->result_array();
      $this->db->flush_cache();
      $this->db->reset_query();
      return $result;
    }

    /**
    * Devuelve el total de participantes por género
    * @author AlesSpock
    * @date 06/06/2018
    * @return array
    **/
    public function total_genero(){
      $this->db->flush_cache();
      $this->db->reset_query();
      $this->db->select(array('sexo', 'count(d.folio)'));
      $this->db->from('foro.dictamen d');
      $this->db->join('foro.trabajo_investigacion ti', 'd.folio = ti.folio', 'inner');
      $this->db->join('foro.autor au',  'ti.folio = au.folio_investigacion and au.registro = true', 'inner', false);
      //$this->db->join("foro.convocatoria c", "c.id_convocatoria = ti.id_convocatoria", "inner");
      $this->db->join('sistema.informacion_usuario iu', 'iu.id_informacion_usuario = au.id_informacion_usuario', 'inner');
      $this->db->join("foro.convocatoria c", "c.id_convocatoria = ti.id_convocatoria", "inner");
      $this->db->group_by('iu.sexo');
      $result = $this->db->get();
      return $result->result_array();
    }


}
