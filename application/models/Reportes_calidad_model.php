<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes_calidad_model extends MY_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /**
     * @author LEAS
     * @fecha 07/06/2018
     * @return type Array
     * 
     */
    public function get_total_trabajos_nacionales_extranjeros() {
        $this->db->flush_cache();
        $this->db->reset_query();
        $select = array(
            "sum(case when iu.clave_pais = 'MX' and iu.es_imss then 1 else 0 end) as trabajos_nacionales_imss"
            , "sum(case when iu.clave_pais <> 'MX' and iu.es_imss then 1 else 0 end) as trabajos_extranjeros_imss"
            , "sum(case when iu.clave_pais = 'MX' and iu.es_imss = false then 1 else 0 end) as trabajos_nacionales_no_imss"
            , "sum(case when iu.clave_pais <> 'MX' and iu.es_imss = false then 1 else 0 end) as trabajos_extranjeros_no_imss"
            , "count(distinct ti.folio) total_trabajos"
        );
        $this->db->select($select);
        $this->db->join("foro.dictamen d", "d.folio = ti.folio", "inner");
        $this->db->join("foro.autor au", "au.folio_investigacion = ti.folio and au.registro", "inner", false);
        $this->db->join("sistema.informacion_usuario iu", "iu.id_informacion_usuario = au.id_informacion_usuario", "inner");
             $this->db->join("foro.convocatoria c", "c.id_convocatoria = ti.id_convocatoria", "inner");
        $result = $this->db->get("foro.trabajo_investigacion ti")->result_array();
        $this->db->flush_cache();
        $this->db->reset_query();
        return $result;
    }

    /**
     * @author LEAS
     * @fecha 07/06/2018
     * @return type Array
     * 
     */
    public function get_calidad_institucion_externos_nacionales_extranjeros($param) {
        $this->db->flush_cache();
        $this->db->reset_query();
        $select = array(
            "round(avg(d.promedio)::numeric, 2) promedio"
            , "count(distinct ti.folio) total_trabajos"
        );
        $this->db->select($select, FALSE);
        $this->db->join("foro.dictamen d", "d.folio = ti.folio", "inner");
        $this->db->join("foro.autor au", "au.folio_investigacion = ti.folio and au.registro", "inner", false);
        $this->db->join("sistema.informacion_usuario iu", "iu.id_informacion_usuario = au.id_informacion_usuario", "inner");
        $this->db->join("foro.convocatoria c", "c.id_convocatoria = ti.id_convocatoria", "inner");

        foreach ($param as $value) {
            $this->db->where($value);
        }

        $result = $this->db->get("foro.trabajo_investigacion ti")->result_array();
        $this->db->flush_cache();
        $this->db->reset_query();
        return $result;
    }

    /**
     * @author LEAS
     * @fecha 07/06/2018
     * @return type Array obtiene la calidad por genero
     * 
     */
    public function get_calidad_por_genero() {
        $this->db->flush_cache();
        $this->db->reset_query();
        $select = array(
            "iu.sexo", "round(avg(d.promedio)::numeric, 2) promedio"
            , "count(distinct ti.folio) total_trabajos"
        );
        $this->db->select($select, FALSE);
        $this->db->join("foro.dictamen d", "d.folio = ti.folio", "inner");
        $this->db->join("foro.autor au", "au.folio_investigacion = ti.folio and au.registro", "inner", false);
        $this->db->join("sistema.informacion_usuario iu", "iu.id_informacion_usuario = au.id_informacion_usuario", "inner");
        $this->db->join("foro.convocatoria c", "c.id_convocatoria = ti.id_convocatoria", "inner");

        $this->db->group_by("iu.sexo");

        $result_sub = $this->db->get("foro.trabajo_investigacion ti")->result_array();
        $this->db->flush_cache();
        $this->db->reset_query();
        $result = [];
        if (!empty($result_sub)) {
            foreach ($result_sub as $value) {
                $result[$value['sexo']] = $value;
                unset($result[$value['sexo']]['sexo']);
            }
        }

        return $result;
    }

    /**
     * @author LEAS
     * @fecha 07/06/2018
     * @return type Array
     * 
     */
    public function get_calidad_nacionales_institucion_delegacion($nacional = true) {
        $this->db->flush_cache();
        $this->db->reset_query();
        $select = array(
            "del.clave_delegacional", "del.nombre", "avg(d.promedio) promedio", "count(distinct ti.folio) total_trabajos"
        );
        $this->db->select($select);
        $this->db->join("foro.dictamen d", "d.folio = ti.folio", "inner");
        $this->db->join("foro.autor au", "au.folio_investigacion = ti.folio and au.registro", "inner", false);
        $this->db->join("sistema.informacion_usuario iu", "iu.id_informacion_usuario = au.id_informacion_usuario", "inner");
        $this->db->join("sistema.historico_informacion_usuario hiu", "hiu.id_informacion_usuario = iu.id_informacion_usuario and hiu.actual", "left");
        $this->db->join("catalogo.delegaciones del", "del.clave_delegacional = substring(hiu.clave_departamental , 0,3)", "left", FALSE);
        if ($nacional) {
            $this->db->where("iu.clave_pais", "MX");
        } else {
            $this->db->where("iu.clave_pais <> 'MX'");
        }
        $this->db->where("iu.es_imss", true);
        $this->db->group_by("del.clave_delegacional, del.nombre");
        $this->db->order_by("del.nombre");
        $result = $this->db->get("foro.trabajo_investigacion ti")->result_array();
        $this->db->flush_cache();
        $this->db->reset_query();
        return $result;
    }

}
