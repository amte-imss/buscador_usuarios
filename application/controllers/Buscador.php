<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que maneja la funcionalidad del buscador
 * @version 	: 1.0.0
 * @author      : Cheko
 * */
class Buscador extends MY_Controller {

    const LISTA = 'lista', NUEVA = 'agregar', EDITAR = 'editar',
            CREAR = 'crear', LEER = 'leer', ACTUALIZAR = 'actualizar', ELIMINAR = 'eliminar',
            EXPORTAR = 'exportar';

    function __construct() {
        parent::__construct();
        $this->load->library('form_complete');
        $this->load->library('form_validation');
        $this->load->model('Catalogo_model', 'catalogo');
        $this->load->model('Buscador_model','buscador');
    }

    /**
     * Función que muestra la vista del buscador
     * o si la matricula existe el detalle historico
     * de un usuario
     * @author Cheko
     * @date 18/06/2018
     * @param type $matricula, matricula de un usuario
     *
     */
    public function index($matricula = NULL) {
      if($matricula == NULL){
        $output = [];
        $output['delegaciones'] = $this->obtenerDelegaciones();
        $output['unidades'] = $this->obtenerUnidades();
        $output['departamentos'] = $this->obtenerDepartamentos();
        $output['categorias'] = $this->obtenerCategorias();
        $main_content = $this->load->view('buscador/buscador.tpl.php', $output, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
      }else{
        $output = [];
        $calendario = $this->config->load('general');
        $output['meses'] = $this->config->item('meses');
        $output['anios'] = $this->config->item('anios');
        $output['historico'] = $this->buscador->obtener_info_usuario(array('matricula'=>$matricula));
        $output['tabla'] = $this->load->view('buscador/detalle_tabla.tpl.php', $output, true);
        $main_content = $this->load->view('buscador/detalle.tpl.php', $output, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
      }
    }

    /**
     * Función auxiliar para mostrar
     * la nueva tabla del historico dependiendo lso filtros
     * @author Cheko
     * @date 18/06/2018
     * @param type $matricula, matricula de un usuario
     *
     */
    public function historico() {
        $output = [];
        if ($this->input->is_ajax_request()) {
            $calendario = $this->config->load('general');
            $output['meses'] = $this->config->item('meses');
            $output['anios'] = $this->config->item('anios');
            $matricula = $this->input->post('matricula', TRUE);
            $mes = $this->input->post('mes', TRUE);
            $anio = $this->input->post('anio', TRUE);
            if($mes != 0 && $anio != 0){
              $output['historico'] = $this->buscador->obtener_info_usuario(array('matricula'=>$matricula,'P.mes'=>$mes,'P.anio'=>$anio));
            }else{
              if($mes != 0){
                $output['historico'] = $this->buscador->obtener_info_usuario(array('matricula'=>$matricula,'P.mes'=>$mes));
              }
              if($anio != 0){
                $output['historico'] = $this->buscador->obtener_info_usuario(array('matricula'=>$matricula,'P.anio'=>$anio));
              }
              if($anio == 0 && $mes == 0){
                $output['historico'] = $this->buscador->obtener_info_usuario(array('matricula'=>$matricula));
              }
            }
            $resultado['data'] = $this->load->view('buscador/detalle_tabla.tpl.php', $output, true);
            $resultado['resultado'] = true;
            echo json_encode($resultado);
            exit();
        }
    }

    /**
     * Función que obtiene la información
     * de la busqueda general por una petición ajax
     * @author Cheko
     * @date 14/06/2018
     */
    public function obtener_busqueda_general(){
      $output = [];
      if ($this->input->is_ajax_request()) {
          $tipo = $this->input->post('tipo', TRUE);
          $busqueda = $this->input->post('busqueda',TRUE);
          $offset = $this->input->post('pagina',TRUE);
          $limit = $this->input->post('limite',TRUE);
          $total = count($this->buscador->obtener_busqueda($tipo,$busqueda,[]));
          $output['datos_busqueda'] = $this->input->post(NULL, TRUE);
          $this->load->library('pagination');
          $config['base_url'] = site_url('buscador/obtener_busqueda_general');
          $config['total_rows'] = $total;
          $config['per_page'] = $limit;
          $config['num_links'] = round($total/$limit);
          $this->pagination->initialize($config);
          $output['paginacion'] = $this->pagination->create_links();
          $output['resultado'] = $this->buscador->obtener_busqueda($tipo,$busqueda,array('limit'=>$limit, 'offset'=>$offset));
          $output['general'] = true;
          $output['total'] = $total;
          $output['num_renglones'] = $limit = $this->input->post('limite',TRUE);
          $resultado['data'] = $this->load->view('buscador/tabla.tpl.php', $output, true);
          $resultado['resultado'] = true;
          echo json_encode($resultado);
          exit();
      }
    }

    /**
     * Función que obtiene la información
     * de la busqueda avanzada por una petición ajax
     * @author Cheko
     * @date 14/06/2018
     */
    public function obtener_busqueda_avanzada(){
      $output = [];
      if ($this->input->is_ajax_request()) {
          $tipo = "avanzada";
          $busqueda = "";
          $output['datos_busqueda'] = $this->input->post(NULL, TRUE);
          $totalQuery = $output['datos_busqueda'];
          unset($totalQuery['offset']);
          unset($totalQuery['limit']);
          $totalArray = $this->buscador->obtener_busqueda($tipo,$busqueda,$totalQuery);
          $totalAnd = count($totalArray['general']);
          $totalOr = count($totalArray['avanzada']);
          $output['totalArray'] = $totalArray;
          $output['totalAnd'] = $totalAnd;
          $output['totalOr'] = $totalOr;
          $total = 0;
          $this->load->library('pagination');
          $config['base_url'] = site_url('buscador/obtener_busqueda_avanzada');
          if($totalAnd > 0){
            $total = $totalAnd;
          }else{
            if($totalOr > 0){
              $total = $totalOr;
            }
          }
          $output['total'] = $total;
          $config['total_rows'] = $total;
          $config['per_page'] = $output['datos_busqueda']['limit'];
          $config['num_links'] = round($total/$output['datos_busqueda']['limit']);
          $this->pagination->initialize($config);
          $output['paginacion'] = $this->pagination->create_links();
          $output['resultado'] = $this->buscador->obtener_busqueda($tipo,$busqueda,$output['datos_busqueda']);
          $output['avanzado'] = true;
          $output['num_renglones'] = $limit = $this->input->post('limite',TRUE);
          $resultado['data'] = $this->load->view('buscador/tabla.tpl.php', $output, true);
          $resultado['resultado'] = true;
          echo json_encode($resultado);
          exit();
      }
    }

    /**
     * Función que obtiene la delegaciones
     * @author Cheko
     * @date 14/06/2018
     * @return $delegaciones delegaciones obtenidas
     */
    private function obtenerDelegaciones(){
      $delegaciones = $this->catalogo->obtener_datos_tabla('delegaciones',array("activo"=>true));
      return $delegaciones;
    }

    /**
     * Función que obtiene las unidades por peticion ajax
     * @author Cheko
     * @date 14/06/2018
     * @return $unidades unidades obtenidas
     *
     */
    public function obtenerUnidades(){
      $output = array("success"=>true,"msj"=>"Peticion para obtener las unidades","datos"=>[]);
      if ($this->input->is_ajax_request()) {
          $id_delegacion = $this->input->post("id_delegacion", TRUE);
          $unidades = $this->catalogo->obtener_datos_tabla('unidad',array("activo"=>true,"anio"=>2018,'id_delegacion'=>$id_delegacion));
          $output['datos'] = $unidades;
          echo json_encode($output);
          exit();
      }
    }

    /**
     * Función que obtiene los departamentos del catalogo
     * por peticion ajax
     * @author Cheko
     * @date 14/06/2018
     * @return $departamentos departamentos obtenidas
     *
     */
     public function obtenerDepartamentos(){
       $output = array("success"=>true,"msj"=>"Peticion para obtener las unidades","datos"=>[]);
       if ($this->input->is_ajax_request()) {
           $clave_unidad = $this->input->post("clave_unidad", TRUE);
           $departamentos = $this->catalogo->obtener_datos_tabla('departamento',array("anio"=>2018,'clave_unidad'=>$clave_unidad));
           $output['datos'] = $departamentos;
           echo json_encode($output);
           exit();
       }
     }

     /**
      * Función que obtiene los categorias del catalogo
      * @author Cheko
      * @date 14/06/2018
      * @return $categorias categorias obtenidas
      *
      */
      private function obtenerCategorias(){
       $categorias = $this->catalogo->obtener_datos_tabla('categorias',array("activa"=>true));
       return $categorias;
      }

      /**
       * Funcion agregar las cabeceras a la peticion
       * @author Cheko
       *
       */
      private function agregar_cabeceras(){
          header('Content-Type: application/json; charset=utf-8;');
      }
}
