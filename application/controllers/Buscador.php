<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene el dashboard del sistema
 * @version 	: 1.0.0
 * @author      : LEAS
 * */
class Buscador extends MY_Controller {

    const LISTA = 'lista', NUEVA = 'agregar', EDITAR = 'editar',
            CREAR = 'crear', LEER = 'leer', ACTUALIZAR = 'actualizar', ELIMINAR = 'eliminar',
            EXPORTAR = 'exportar';

    function __construct() {
        parent::__construct();
    }

    function index() {
        $output = [];
        $main_content = $this->load->view('buscador/buscador.tpl.php', $output, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

    function informacion($tipo = 'lista') {
        $output['data'] = $this->trabajo->listado_trabajos_autor_general();
//        pr($output['data']);
        header('Content-Type: application/json; charset=utf-8;');
        echo json_encode($output);

    }

}
