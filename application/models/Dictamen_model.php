<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dictamen_model extends MY_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /**
    * Devuelve la informacion de los trabajos que han sido evaluados
    * @author clapas
    * @date 25/05/2018
    * @return array
    */
    public function get_trabajos_evaluados($param = [])
    {
      try{
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->select(array('hr.folio','ti.titulo','tm.lang metodologia','d.promedio', 'd.sugerencia', 'd.orden','iu.nombre', 'iu.apellido_paterno','iu.apellido_materno','iu.email'));

        $this->db->join('foro.trabajo_investigacion ti','hr.folio = ti.folio','inner');
        $this->db->join('foro.tipo_metodologia tm','ti.id_tipo_metodologia = tm.id_tipo_metodologia','inner');
        $this->db->join('foro.autor a','ti.folio = a.folio_investigacion','inner');
        $this->db->join('sistema.informacion_usuario iu', 'iu.id_informacion_usuario = a.id_informacion_usuario', 'inner');
        $this->db->join('foro.dictamen d','hr.folio = d.folio','inner');
        $this->db->join('foro.convocatoria c','ti.id_convocatoria = c.id_convocatoria','inner');

        $this->db->where(
          array(
            'c.activo'=>true,
            'hr.clave_estado' => 'evaluado',
            'hr.actual' => true,
            'a.registro' => true,
          )
        );
        
        if(isset($param['where']))
        {
          $this->db->where($param['where']);
        }

        if(isset($param['where_in']))
        {
          $this->db->where_in($param['where_in'][0],$param['where_in'][1]);
        }

        if(isset($param['order_by']))
        {
          $this->db->order_by($param['order_by'],'desc');
        }

        $res = $this->db->get('foro.historico_revision hr');
        $this->db->flush_cache();
        $this->db->reset_query();    
        $reusltado = $res->result_array();
        return $reusltado;

      }catch(Exception $ex){
        return [];
      }
    }

    /**
    * Devuelve la informacion de los trabajos que han sido o no se asignaron 
    * para el envio de correo
    * @author clapas
    * @date 25/05/2018
    * @return array
    */
    public function get_trabajos_rechazados_sa($param = [])
    {
      try{
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->select(array('hr.folio','ti.titulo','iu.nombre', 'iu.apellido_paterno','iu.apellido_materno','iu.email'));

        $this->db->join('foro.trabajo_investigacion ti','hr.folio = ti.folio','inner');
        $this->db->join('foro.autor a','ti.folio = a.folio_investigacion','inner');
        $this->db->join('sistema.informacion_usuario iu', 'iu.id_informacion_usuario = a.id_informacion_usuario', 'inner');
        $this->db->join('foro.convocatoria c','ti.id_convocatoria = c.id_convocatoria','inner');

        $this->db->where(
          array(
            'c.activo'=>true,
            'hr.actual' => true,
            'a.registro' => true
          )
        );
        
        if(isset($param['where']))
        {
          $this->db->where($param['where']);
        }

        if(isset($param['where_in']))
        {
          $this->db->where_in($param['where_in'][0],$param['where_in'][1]);
        }

        if(isset($param['order_by']))
        {
          $this->db->order_by($param['order_by'],'desc');
        }

        $res = $this->db->get('foro.historico_revision hr');
        $this->db->flush_cache();
        $this->db->reset_query();    
        pr($this->db->last_query());
        $reusltado = $res->result_array();
        return $reusltado;

      }catch(Exception $ex){
        return [];
      }
    }

    public function get_revisores($param)
    {
      try{
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->select(array('hr.folio', 'r.id_usuario', 'r.sugerencia', 'concat(iu.nombre, \' \', iu.apellido_paterno, \' \', iu.apellido_materno) nombre_revisor', 'r.fecha_asignacion'));

        $this->db->join('foro.trabajo_investigacion ti','hr.folio = ti.folio','inner');
        $this->db->join('foro.revision r','hr.folio = r.folio','inner');
        $this->db->join('sistema.informacion_usuario iu','r.id_usuario = iu.id_usuario','left');
        $this->db->join('foro.dictamen d','hr.folio = d.folio','inner');
        $this->db->join('foro.convocatoria c','ti.id_convocatoria = c.id_convocatoria','inner');

        $this->db->where(
          array(
            'c.activo'=>true,
            'hr.clave_estado' => 'evaluado',
            'hr.actual' => true
          )
        );
        
        if(isset($param['where']))
        {
          $this->db->where($param['where']);
        }

        if(isset($param['where_in']))
        {
          $this->db->where_in($param['where_in'][0],$param['where_in'][1]);
        }

        if(isset($param['order_by']))
        {
          $this->db->order_by($param['order_by'],'desc');
        }

        $res = $this->db->get('foro.historico_revision hr');
        $this->db->flush_cache();
        $this->db->reset_query();    

        return $res->result_array();

      }catch(Exception $ex){
        return [];
      } 
    }

    /**
     * Devuelve la información de los registros de la tabla catalogos
     * @author 
     * @date 21/05/2018
     * @return array
     */
    public function get_detalle_dictamen($param) {
        $resut = [];
        return $resut;
    }

    /**
     * Devuelve la información de los registros de la tabla catalogos
     * @author 
     * @date 21/05/2018
     * @return array
     */
    public function get_listado_dictamen($param) {
        $resut = [];
        return $resut;
    }

    /**
     * Devuelve la información de los registros de la tabla catalogos
     * @author 
     * @date 21/05/2018
     * @return array
     */
    public function insert_dictamen($param) {

        $resut = [];
        return $resut;
    }

    /**
    * Devuelve el cupo maximo
    * @author clapas
    * @date 25/05/2017
    */
    public function get_cupo()
    {
      try{
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->where(array('llave'=>'cupo'));
        $res = $this->db->get('foro.configuracion');

        $this->db->flush_cache();
        $this->db->reset_query();    

        return $res->result_array()['0']['valor'];
      }catch(Exception $ex){
        return [];
      }
    }

    /**
    * Devuelve la configuracion de la asignacion
    * @author clapas
    * @date 25/05/2017
    */
    public function config_asignacion()
    {
      try{
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->where(array('llave'=>'ordenamiento'));
        $res = $this->db->get('foro.configuracion');

        $this->db->flush_cache();
        $this->db->reset_query();    

        return $res->result_array()['0']['valor'];
      }catch(Exception $ex){
        return [];
      }
    }

    /**
    * Activa algun tipo de asignacion
    * @author clapas
    * @date 29/05/2018
    * @param char A si es automatica, M si es manual
    * @return boolean true si se pudo realizar el cambio, false en otro caso 
    */
    public function activar_asignacion($tipo)
    {
      $salida = false;
      $this->db->flush_cache();
      $this->db->reset_query();
      $this->db->trans_begin();

      $config = '{"manual" : false, "sistema" : false }';
      switch ($tipo) {
        case 'A':
          $config = '{"manual" : false, "sistema" : true }';
          break;

        case 'M':
          $config = '{"manual" : true, "sistema" : false }';
          break;
      }

      $this->db->set(array('valor'=>$config));
      $this->db->where('llave','ordenamiento');
      $this->db->update('foro.configuracion');
      if ($this->db->trans_status() === FALSE)
      {
          $this->db->trans_rollback();
      } else
      {
          $this->db->trans_commit();
          $salida = true;
      }

      $this->db->flush_cache();
      $this->db->reset_query();
      return $salida;
    }

    /**
    * Devuelve los trabajos que podran ser asignados de manera automatica
    * @author clapas
    * @date 28/05/2018
    * @param int Cantidad de trabajos a devolver
    * @param int offset, uno antes de los que se toman en cuenta
    * @return array
    */
    public function trabajos_candidatos($cupo_total,$offset=0)
    {
      $res = [];
      try{
        $this->db->flush_cache();
        $this->db->reset_query();

        $this->db->select('d.folio');

        $this->db->join('foro.historico_revision hr','d.folio = hr.folio');
        $this->db->join('foro.trabajo_investigacion ti','d.folio = ti.folio');
        $this->db->join('foro.convocatoria c','ti.id_convocatoria = c.id_convocatoria');

        $this->db->where(array(
            'd.sugerencia'=>null,
            'd.folio_dictamen'=>null,
            'c.activo'=>true,
            'hr.clave_estado'=>'evaluado',
            'hr.actual' => true
          )
        );
        $this->db->order_by('d.promedio, ti.fecha','desc');

        if(!is_null($offset))
        {
          $res = $this->db->get('foro.dictamen d',$cupo_total,$offset);
        }else
        {
          $res = $this->db->get('foro.dictamen d',$cupo_total);
        }
        return $res->result_array();

      }catch(Exception $ex){
        return $res;
      }
    }

    /**
    * Actualiza los trabajos evaluados
    * @author clapas
    * @date 28/05/2018
    * @param array param = (where_in, values, where)
    * @return boolean True si logro actualizar los datos, false en otro caso
    */
    public function actualizar_registro($param)
    {
      $salida = false;
      $this->db->flush_cache();
      $this->db->reset_query();
      $this->db->trans_begin();

      $this->db->set($param['values']);
      
      if(isset($param['where_in']))
      {
        $this->db->where_in($param['where_in'][0],$param['where_in'][1]);
      }

      if(isset($param['where']))
      {
        $this->db->where($param['where']);
      }

      $this->db->update('foro.dictamen');
      if ($this->db->trans_status() === FALSE)
      {
          $this->db->trans_rollback();
      } else
      {
          $this->db->trans_commit();
          $salida = true;
      }

      $this->db->flush_cache();
      $this->db->reset_query();
      return $salida;
    }

    /**
    * Borra la sugerencia y el orden de los trabajos evaluados
    * @author clapas
    * @date 28/05/2018
    * @return boolean True si logro hacer la actualizacion, false en otro caso
    */
    public function reset_orden()
    {
      $salida = false;
      $this->db->flush_cache();
      $this->db->reset_query();
      $this->db->trans_begin();

      $valores = array(
          'sugerencia'=> null,
          'orden' => null,
          'aceptado' => null,
          'id_usuario' => null
        );


      $this->db->set($valores);
      $this->db->where(array('folio_dictamen'=>null,'aceptado'=>true));
      $this->db->update('foro.dictamen');

      if ($this->db->trans_status() === FALSE)
      {
          $this->db->trans_rollback();
      } else
      {
          $this->db->trans_commit();
          $salida = true;
      }

      $this->db->flush_cache();
      $this->db->reset_query();
      return $salida; 
    }


    /**
    * Devuelve el numero de trabajos en la tabla de dictamen
    * @author clapas
    * @date 28/05/2018
    * @param boolean true si ya fue dictaminado, false si solo se tomara la sugerencia
    * @param char O si es oratoria, C si es cartel, R si es rechazado, Q si esta sin asignarse
    * @return int
    */
    public function count_registros_dictamen($dictaminado,$filtro)
    {

      $this->db->flush_cache();
      $this->db->reset_query();

      $filtros = [];

      if($dictaminado)
      {
        switch ($filtro) {
          case 'R':
            $filtros = array('aceptado'=>false);
            break;

          case 'Q':
            return 0;
            break;
          
          default:
            $filtros = array('aceptado'=>true,'tipo_exposicion'=>$filtro);
            break;
        }
      }else
      {
        switch ($filtro) {
          case 'R':
            return 0;
            break;

          case 'Q':
            $filtros = array('aceptado'=>null,'sugerencia'=>null);
            break;
          
          default:
            $filtros = array('aceptado'=>true,'sugerencia'=>$filtro);
            break;
        }
      }

      $this->db->where($filtros);
      $this->db->from('foro.dictamen');

      return $this->db->count_all_results();
    }


    /**
    * Asigna los datos de dictamen a un trabajo
    * @author clapas
    * @date 30/05/2018
    * @param folio_actual
    * @param folio_dictamen
    * @param sugerencia
    */ 
    public function dictaminar($folio_actual, $folio_dictamen, $sugerencia)
    {
      $salida = false;
      $this->db->flush_cache();
      $this->db->reset_query();
      $this->db->trans_begin();

      $valores = array(
        'folio_dictamen' => $folio_dictamen,
        'tipo_exposicion' => $sugerencia,
        'fecha' => 'now()' 
        );
      $this->db->set($valores,false);
      $this->db->where('folio',$folio_actual);
      $this->db->update('foro.dictamen');

      if ($this->db->trans_status() === FALSE)
      {
          $this->db->trans_rollback();
      } else
      {
          $this->db->trans_commit();
          $salida = true;
      }

      $this->db->flush_cache();
      $this->db->reset_query();
      return $salida; 
      //return false;
    }
}
