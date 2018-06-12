<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Trabajo_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function nuevo($datos) {
        $salida = false;
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->trans_begin();

        // Agregamos informacion del trabajo
        $this->db->insert('foro.trabajo_investigacion', $datos['datos']);

        //Agregamos los datos del autor registrante
        $autor_registrante = array(
            'folio_investigacion' => $datos['datos']['folio'],
            'id_informacion_usuario' => $datos['registrante'],
            'registro' => true
        );
        $this->db->insert('foro.autor', $autor_registrante);

        //Agregamos los datos de los demas autores
        $autores = $datos['autores'];
        if (count($autores) > 0) {
            foreach ($autores as $key => $value) {
                $this->db->insert('sistema.informacion_usuario', $value);
                $insert_id = $this->db->insert_id();
                $coautor = array(
                    'folio_investigacion' => $datos['datos']['folio'],
                    'id_informacion_usuario' => $insert_id,
                    'registro' => false
                );
                $this->db->insert('foro.autor', $coautor);
            }
        }

        $this->db->insert('public.archivos', $datos['archivo']);
        $this->db->insert('foro.historico_revision', array(
            'folio' => $datos['datos']['folio'],
            'clave_estado' => 'sin_asignacion',
            'actual' => 'true'
                )
        );

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $salida = true;
        }

        $this->db->flush_cache();
        $this->db->reset_query();
        return $salida;
    }

    public function tipo_metodologia($filtros = null) {
        $this->db->flush_cache();
        $this->db->reset_query();

        if (!is_null($filtros))
            $this->db->where($filtros);

        $res = $this->db->get('foro.tipo_metodologia');

        $this->db->flush_cache();
        $this->db->reset_query();

        return $res->result_array();
    }

    public function numero_trabajos() {
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->select("max(substring(folio from '\d+$'))::numeric AS maximo_val", FALSE);
        $result = $this->db->get("foro.trabajo_investigacion")->result_array();
        if (empty($result)) {
            return 0;
        } else {

            return $result[0]['maximo_val'];
        }
        return $this->db->count_all('foro.trabajo_investigacion');
    }

//    public function numero_trabajos()
//    {
//    	$this->db->flush_cache();
//        $this->db->reset_query();
//
//    	return $this->db->count_all('foro.trabajo_investigacion');
//    }

    public function listado_trabajos_autor($id_informacion_usuario, $lang) {
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->select(array('ti.folio', 'ti.titulo', 'ti.id_tipo_metodologia', "m.lang nombre_metodologia", 'date(ti.fecha) fecha', 'hr.clave_estado', "et.lang estado"));
        $this->db->where(array(
            'a.id_informacion_usuario' => $id_informacion_usuario,
            'a.registro' => 'true',
            'hr.actual' => true,
            'c.activo' => true
        ));
        $this->db->join('foro.autor a', 'a.folio_investigacion = ti.folio', 'left');
        $this->db->join('foro.tipo_metodologia m', 'm.id_tipo_metodologia = ti.id_tipo_metodologia', 'left');
        $this->db->join('foro.historico_revision hr', 'ti.folio = hr.folio', 'inner');
        $this->db->join('foro.estado_trabajo et', 'hr.clave_estado = et.clave_estado');
        $this->db->join('foro.convocatoria c', 'ti.id_convocatoria = c.id_convocatoria');
        $this->db->order_by('ti.folio', 'desc');
        $res = $this->db->get('foro.trabajo_investigacion ti');

        $this->db->flush_cache();
        $this->db->reset_query();

        return $res->result_array();
    }

    /**
     * @author LEAS
     * @fecha 08/05/2018
     * @param type $condiciones
     * @return type
     */
    public function listado_trabajos_autor_general($condiciones = null) {
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->select(array(
            "ti.folio", "ti.titulo", "ti.id_tipo_metodologia", "m.lang nombre_metodologia",
            "date(ti.fecha) fecha", "hr.clave_estado", "et.lang estado"
            , "a.id_informacion_usuario", "iu.es_imss" 
            ,"case when uni.es_umae then 3 else uni.nivel_atencion end as nivel_atencion"
            , "concat(iu.nombre, ' ', iu.apellido_paterno, ' ', iu.apellido_materno) nombre_investigador"
        ), false);
        $this->db->where(array(
            'a.registro' => true,
            'hr.actual' => true,
            'c.activo' => true
        ));
        $this->db->join('foro.autor a', 'a.folio_investigacion = ti.folio', 'inner');
        $this->db->join('foro.tipo_metodologia m', 'm.id_tipo_metodologia = ti.id_tipo_metodologia', 'inner');
        $this->db->join('foro.historico_revision hr', 'ti.folio = hr.folio', 'left');
        $this->db->join('foro.estado_trabajo et', 'hr.clave_estado = et.clave_estado', 'left');
        $this->db->join('sistema.informacion_usuario iu', 'iu.id_informacion_usuario = a.id_informacion_usuario', 'inner');
        $this->db->join('sistema.historico_informacion_usuario h', 'h.actual = true and h.id_informacion_usuario = iu.id_informacion_usuario', 'left', FALSE);
        $this->db->join('catalogo.departamento dep', 'dep.clave_departamental = h.clave_departamental', 'left');
        $this->db->join('foro.convocatoria c', 'ti.id_convocatoria = c.id_convocatoria');
        $this->db->join('catalogo.unidad uni', 'uni.clave_unidad = dep.clave_unidad', 'left');
//        $this->db->join('catalogo.delegaciones del', 'del.id_delegacion = uni.id_delegacion', 'left');
        $this->db->order_by('ti.folio', 'desc');
        $res = $this->db->get('foro.trabajo_investigacion ti');
//        pr($this->db->last_query());
//        pr($this->db->last_query());
        $this->db->flush_cache();
        $this->db->reset_query();

        return $res->result_array();
    }

    public function autores_trabajo_folio($folio, $lang, $autor = null) {
        $this->db->flush_cache();
        $this->db->reset_query();

        if (!is_null($autor)) {
            $where = array('a.folio_investigacion' => $folio, 'a.id_informacion_usuario' => $autor);
        } else {
            $where = array('a.folio_investigacion' => $folio);
        }
        $this->db->where($where);

        $this->db->select(array('iu.*', 'p.*', 'a.*', "p.lang pais_nombre"));
        $this->db->join('sistema.informacion_usuario iu', 'a.id_informacion_usuario = iu.id_informacion_usuario');
        $this->db->join('catalogo.pais p', 'p.clave_pais=iu.clave_pais', 'left');
        $this->db->order_by('a.registro', 'desc');
        $res = $this->db->get('foro.autor a');

        $this->db->flush_cache();
        $this->db->reset_query();
        //pr($this->db->last_query());
        return $res->result_array();
    }

    public function trabajo_investigacion_folio($folio, $lang) {
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->select(array('ti.*', "m.lang tipo_metodologia", "f.id_archivo", "f.nombre_fisico", "m.id_tipo_metodologia"));
        $this->db->where(array('ti.folio' => $folio));
        $this->db->join('foro.tipo_metodologia m', 'm.id_tipo_metodologia = ti.id_tipo_metodologia');
        //$this->db->join('foro.historico_revision hr','ti.folio = hr.folio','inner');
        //$this->db->join('foro.estado_trabajo et','hr.clave_estado = et.clave_estado', 'left');
        $this->db->join('public.archivos f', 'f.folio_investigacion = ti.folio', 'left');
        $res = $this->db->get('foro.trabajo_investigacion ti');

//        pr($this->db->last_query());
//        pr($this->db->last_query());
        $this->db->flush_cache();
        $this->db->reset_query();

        return $res->result_array();
    }

}
