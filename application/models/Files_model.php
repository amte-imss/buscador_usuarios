<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author: LEAS
 * @version: 1.0
 * @desc: Clase modelo de consultas para de obtener archivos
 * */
class Files_model extends MY_Model {

    public function __construct() {
        // Call the padre constructor
        parent::__construct();
    }

    /**
     * @author LEAS
     * @param type $id_file identificador del archivo en la base de datos
     * @return type array vacio si no existe el id del archivo, si no retorna un array 
     * con un registro de el archivo, con los siguientes identificadores
     * 'id_file', 'nombre_fisico', 'ruta'
      , 'id_extencion_file', 'nombre nombre_extencion',
     */
    public function get_file($id_file) {
        $this->db->flush_cache();
        $this->db->reset_query();
        $select = array(
            "id_archivo", "nombre_fisico", "ruta", "folio_investigacion"
        );
        $this->db->select($select);
        $this->db->where('f.id_archivo', $id_file);
        $resultado = $this->db->get('public.archivos f');
//        pr($this->db->last_query());
        $this->db->flush_cache();
        $this->db->reset_query();
        return $resultado->result_array();
    }

}
