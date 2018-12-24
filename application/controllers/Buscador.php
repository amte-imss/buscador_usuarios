<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que maneja la funcionalidad del buscador
 * @version 	: 1.1.0
 * @author      : Lima
 * */
class Buscador extends MY_Controller {

    const LISTA = 'lista', NUEVA = 'agregar', EDITAR = 'editar',
            CREAR = 'crear', LEER = 'leer', ACTUALIZAR = 'actualizar', ELIMINAR = 'eliminar',
            EXPORTAR = 'exportar';

    function __construct() {

        parent::__construct();
        $this->load->library('form_complete');
        $this->load->library('form_validation');
        $this->load->library('csvimport');
        $this->load->library('Catalogo_listado');
        $this->load->model('Catalogo_model', 'catalogo');
        $this->load->model('Buscador_model','buscador');
    }

    /**
     * Función Obtiene (Curp, Matricula, Nombre, Apellidos)
     * @author Lima
     * @date 21/12/2018
     * @return Busqueda General
     *
     */
    public function busqueda_general($status = null){


        $filtros['current_row'] = 0;
        $filtros['per_page'] = 0;
        $filtros['keyword'] = '';
        $output['current_row'] = $filtros['current_row'];
        $output['departamentos'] = array('data'=>0, 'total'=>0, 'per_page'=>0);
        $output['paginacion'] =  0;
        $filtros['tipo_busqueda'] = 1;


        if ($this->input->post())
        {

            $filtros['order'] = $this->input->post('order', true);
            $filtros['per_page'] = $this->input->post('per_page', true);
            $filtros['keyword'] = $this->input->post('keyword', true);
            $filtros['apellido_paterno'] = $this->input->post('apellido_paterno', true);
            $filtros['apellido_materno'] = $this->input->post('apellido_materno', true);
            $filtros['type'] = $this->input->post('filtro_texto', true); 
/*
        if(!empty($filtros['keyword']))
           {
            */
            $output['departamentos'] = $this->buscador->get_busqueda_general($filtros);
            $paginacion = $this->template->pagination_data($output['departamentos']);
            $output['paginacion'] = $paginacion;
            $output['keyword'] = $filtros['keyword'];
            $output['type'] = $filtros['type'];
            $output['current_row'] = $filtros['current_row'];
           /*
           } else {
            $filtros['current_row'] = 0;
            $filtros['per_page'] = 0;
            $filtros['keyword'] = '';
            $output['current_row'] = $filtros['current_row'];
            $output['departamentos'] = array('data'=>0, 'total'=>0, 'per_page'=>0);
            $output['paginacion'] =  0;
            $filtros['tipo_busqueda'] = 1;
           }
           */
        } 

        #
        $view = $this->load->view('busqueda/general', $output, true);
        $this->template->setMainContent($view);
        // $this->template->setSubTitle('Busqueda General');
        $this->template->getTemplate();

    }
    
     /**
     * Función Obtiene (Curp, Matricula, Nombre, Apellidos)
     * @author Lima
     * @date 21/12/2018
     * @return Busqueda Avanzada
     *
     */
    public function busqueda_avanzada($status = null){

        $filtros['current_row'] = 0;
        $filtros['curp'] = '';
        $filtros['matricula'] = '';
        $filtros['delegacion'] = '';
        $filtros['unidad'] = '';
        $filtros['categorias'] = '';
        $output['current_row'] = $filtros['current_row'];
        $output['departamentos'] = array('data'=>0, 'total'=>0, 'per_page'=>0);
        $output['paginacion'] =  0;

        if ($this->input->post())
        {
            $filtros['order'] = $this->input->post('order', true);
            $filtros['per_page'] = $this->input->post('per_page', true);
            $filtros['curp'] = $this->input->post('curp', true);
            $filtros['matricula'] = $this->input->post('matricula', true);
            $filtros['delegacion'] = $this->input->post('delegacion', true);
            $filtros['unidad'] = $this->input->post('unidad', true);
            $filtros['categorias'] = $this->input->post('categorias', true); 
            $filtros['nombre'] = $this->input->post('nombre', true); 
            $filtros['apellido_paterno'] = $this->input->post('apellido_paterno', true); 
            $filtros['apellido_materno'] = $this->input->post('apellido_materno', true); 

        }
          
        if(!empty($filtros['curp']) || !empty($filtros['matricula']) || !empty($filtros['delegacion']) || !empty($filtros['unidad']) || !empty($filtros['categorias']) || !empty($filtros['apellido_materno']) || !empty($filtros['nombre']) || !empty($filtros['apellido_paterno']))
           {

               $output['departamentos'] = $this->buscador->get_bavanzasa($filtros);
               $paginacion = $this->template->pagination_data($output['departamentos']);        
               $output['paginacion'] = $paginacion;
           }  else {

              $filtros['current_row'] = 0;
              $filtros['curp'] = '';
              $filtros['matricula'] = '';
              $filtros['delegacion'] = '';
              $filtros['unidad'] = '';
              $filtros['categorias'] = '';
              $output['current_row'] = $filtros['current_row'];
              $output['departamentos'] = array('data'=>0, 'total'=>0, 'per_page'=>0);
              $output['paginacion'] =  0;

           }

    
       $cat_list = new Catalogo_listado();
       $output['catalogos'] = $cat_list->obtener_catalogos(
            array(
                Catalogo_listado::DELEGACIONES => array('condicion' =>''),
                Catalogo_listado::CATEGORIAS => array('condicion' => '')
                )
            );
      
        # vista
        $view = $this->load->view('busqueda/avanzada', $output, true);
        $this->template->setMainContent($view);
        //$this->template->setSubTitle('Busqueda Avanzada');
        $this->template->getTemplate();

    }

     /**
     * Función Obtiene (Curp, Matricula, Nombre, Apellidos)
     * @author Lima
     * @date 21/12/2018
     * @return Busqueda CSV
     *
     */
     public function busqueda_csv($status = null){
                       
        $output['status'] = $status;
        $main_content = $this->load->view('busqueda/csv', $output, true);
        $this->template->setMainContent($main_content);
        //$this->template->setSubTitle('Nuevo hecho');
        $this->template->getTemplate();

    }


    public function cargar_csv($status = null)
    {

 /*       
        $data_sesion = $this->get_datos_sesion();
    pr($data_sesion);
        $filtros['tipo_b'] = $this->input->post('tipo_b', true);
        
        if ($this->input->post())
        {     // SI EXISTE UN ARCHIVO EN POST
            $config['upload_path'] = './uploads/';      // CONFIGURAMOS LA RUTA DE LA CARGA PARA LA LIBRERIA UPLOAD
            $config['allowed_types'] = 'csv';           // CONFIGURAMOS EL TIPO DE ARCHIVO A CARGAR
            $config['max_size'] = '4000';               // CONFIGURAMOS EL PESO DEL ARCHIVO
            $this->load->library('upload', $config);    // CARGAMOS LA LIBRERIA UPLOAD
            if ($this->upload->do_upload())
            {
                $csv = $this->buscador->get_content_csv();
               
                if ($this->buscador->valid_csv($csv)['status'])
                {
                    pr('valido el csv');
                    $resultado = $this->buscador->insert_data_csv($csv);
                    if ($resultado['result'])
                    {
                      $resultado = $this->buscador->insert_data_csv($csv);
                    } else
                    {

                        redirect(site_url() . '/buscador/busqueda_csv/3');
                    }
                } else
                {
           
                     $resultado = $this->buscador->insert_data_csv($csv, $data_sesion['id_usuario']);
                    redirect(site_url() . '/buscador/busqueda_csv/3');
                }
            } else
            {
                redirect(site_url() . '/buscador/busqueda_csv/2');
            }
        } else
        {
            redirect(site_url() . '/buscador/busqueda_csv');
        }


*/

        if ($this->input->post())
        {     
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = '1000';
            $this->load->library('upload', $config);

            if ($this->upload->do_upload())
            {   
            
             $csv = $this->buscador->get_content_csv();
                if ($this->buscador->valid_csv($csv)['status']=true)
                {
                    $filtros['tipo_b'] = $this->input->post('tipo_b', true);

                    if($filtros['tipo_b']==1)
                      {
                        $resultado = $this->buscador->buscar_csv_bd($csv); 
                      }

                    if($filtros['tipo_b']==2)
                      {
                        $resultado = $this->buscador->buscar_csv_curp($csv); 
                      }
              
                    if (!$resultado['result'])
                    {
                        //redirect(site_url() . '/buscador/get_lista/1');
                        //$this->reporte_registro($resultado);
                    }
                     else
                    {

                    if($filtros['tipo_b']==1)
                      {
                            $output['datos_csv'] = $resultado;
                            $main_content = $this->load->view('busqueda/csv', $output, true);
                            $filename= "resultado_matricula_csv_" . date("d-m-Y_H-i-s") . ".xls";
                            $output_['complemento_info'] =  $resultado['data'];
                            $view = $this->load->view('busqueda/reporte_csv', $output_, true);
                            //echo $view;
                            $this->exportar($filename, $output_, 'busqueda/reporte_csv');
                            $this->template->setMainContent($main_content);
                      }

                    if($filtros['tipo_b']==2)
                      {
                            $output['datos_csv'] = $resultado;
                            $main_content = $this->load->view('busqueda/csv', $output, true);
                            $filename= "resultado_curp_csv_" . date("d-m-Y_H-i-s") . ".xls";
                            $output_['complemento_info'] =  $resultado['data'];
                            $view = $this->load->view('busqueda/reporte_curp', $output_, true);
                            //echo $view;
                            $this->exportar($filename, $output_, 'busqueda/reporte_csv');
                            $this->template->setMainContent($main_content);
                      }    

                    }
                } else {
                    //redirect(site_url() . '/buscador/busqueda_csv/3');
                }
              } else {
                redirect(site_url() . '/buscador/busqueda_csv/2');
            }
        } else {
            redirect(site_url() . '/buscador/busqueda_csv');
      }


    }


/* Ajax  - Delegaciones */
  /**
   * Funcion que realiza el resuelve la peticion de get tipos de unidades
   * @author Lima
   * @param string $nivel Nivel de atencion para obtener los tipos de unidades
   */

  public function obtener_unidades($delegacion)
  {
    
      if($this->input->is_ajax_request())
      {
        
          $Unidades = $this->buscador->ms_del_bd($delegacion);
          $this->agregar_cabeceras();
          echo json_encode($Unidades);
        
      }
      
  }

  /**
   * Funcion agregar las cabeceras a la peticion
   * @author lima
   *
   */
  private function agregar_cabeceras(){
      header('Content-Type: application/json; charset=utf-8;');
  }

    /**
     * Función Obtiene (Curp, Matricula, Nombre, Apellidos)
     * @author Lima
     * @date 21/12/2018
     * @return Busqueda General
     *
     */
    public function detalle($matricula,$tipo_busqueda,$filtros = null){

        $output['paginacion'] =  0;
        $filtros['tipo_busqueda'] = $tipo_busqueda;
        $filtros['matricula'] = $matricula;
        $output['anios'] =  array(2018 => 2018,2017 => 2017);
        $output['meses'] = array(1 => 'Enero',2 => 'Febrero',3 => 'Marzo',4 => 'Abril',5 => 'Mayo',6 => 'Junio',
              7 => 'Julio',8 => 'Agosto',9 => 'Septiembre',10 => 'Octubre',
              11 => 'Noviembre',12 => 'Diciembre');
        $output['actual'] = $this->buscador->get_busqueda_detalle($filtros);
        
        //pr($output);
        //exit();

        $view = $this->load->view('busqueda/detalle', $output, true);
        $this->template->setMainContent($view);
        // $this->template->setSubTitle('Busqueda General');
        $this->template->getTemplate();

    }

   public function exportar_datos_user($matricula,$tipo_busqueda,$filtros = null){
        $filtros['tipo_busqueda'] = $tipo_busqueda;
        $filtros['matricula'] = $matricula;
        $filename = "historico_".$matricula.'_'. date("d-m-Y_H-i-s") . ".xls";
        $output['actual'] = $this->buscador->get_busqueda_detalle($filtros);
        $this->exportar($filename, $output, 'busqueda/exportar');

    }

       protected function exportar( $filename = 'output.xls', $data = null, $vista  = 'busqueda/exportar'){

        if(is_null($data)){
            echo '';
        }    
                
        //header("Content-Type: application/vnd.ms-excel;charset=UTF-8");
        
        header("Content-type: application/x-msexcel;charset=UTF-8");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        
        $view = $this->load->view($vista, $data, true);
        echo $view;
        //exit();


    }

}
