<?php
defined("BASEPATH") OR die("El acceso al script no está permitido");

class Pdf_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
    *
    * @author clapas
    * @date 25/05/2017
    */

    public function get_info_pdf()
    {
      try{
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->select('CONCAT (iu.nombre,' ',iu.apellido_paterno,' ',iu.apellido_materno) AS Participante');
        $this->db->from('foro.dictamen dn');
        $this->db->join('sistema.informacion_usuario iu ON dn.id_usuario=iu.id_usuario');
        $this->db->where('dn.aceptado', TRUE);
        $result = $this->db->get('');
        $salida = $result->result_array();
        $result->free_result();
        $this->db->flush_cache();
        $this->db->reset_query();
      }catch(Exception $ex){
        return [];
      }
    }
}
