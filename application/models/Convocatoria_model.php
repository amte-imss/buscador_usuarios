<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Convocatoria_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Devuelve los datos de la convocatoria que se encuentra activa
     */
    public function get_activa($obtiene_datos_completos = FALSE) {
        $salida = false;
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->where('activo', true);
        $res = $this->db->get('foro.convocatoria')->result_array();
        
        $this->db->flush_cache();
        $this->db->reset_query();

        if (!$obtiene_datos_completos && !empty($res)) {
            return $res[0]['revision'];
        } else {
            return $res;
        }
    }

    /**
     * Desactiva el registro, la revision o ambos de la convocatoria activa
     * @author clapas
     * @param boolean registro
     * @param boolean revision
     * @return boolean
     */
    public function estados_convocatoria($registro, $revision) {
        $salida = false;
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->trans_begin();

        $this->db->set(array('registro' => $registro, 'revision' => $revision));
        $this->db->where('activo', true);
        $this->db->update('foro.convocatoria');

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

}
