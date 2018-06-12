<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluacion_revision_model extends MY_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }

    /**
     * Devuelve la información de los registros de la tabla catalogos
     * @author LEAS
     * @date 22/05/2018
     * @return array
     */
    public function get_configuracion_dias_revision() {
        $this->db->flush_cache();
        $this->db->reset_query();
        $conf = 3;
        $select = array(
            "llave", "valor"
        );
        $this->db->select($select);
        $this->db->where("llave", "dias_revision");
        $result = $this->db->get("foro.configuracion")->result_array();
        if (!empty($result)) {
            $result = json_decode($result[0]["valor"], true);
            $conf = $result['dias'];
        }
        return $conf;
    }

    /**
     * Devuelve la información de los registros de la tabla catalogos
     * @author LEAS
     * @date 22/05/2018
     * @return array
     */
    public function get_secciones($param = null, $idioma = 'es') {
        $this->db->flush_cache();
        $this->db->reset_query();
        $select = array(
            "id_seccion", "descripcion"
        );
        $this->db->select($select);
        foreach ($param as $key => $val) {
            foreach ($val as $keyp => $valp) {
                $name = $key . "";
                if (is_null($valp) || $valp == "") {
                    $this->db->{$name}($keyp, null);
                } else {
                    $this->db->{$name}($keyp, $valp);
                }
            }
        }
        $result = $this->db->order_by('id_seccion');
        $result = $this->db->get('foro.seccion')->result_array();
        $lang = [];
        foreach ($result as &$value) {
            $lang = json_decode($value['descripcion'], true);
            $value['descripcion'] = $lang[$idioma];
        }
        return $result;
    }

    /**
     * Devuelve la información de los registros de la tabla catalogos
     * @author LEAS
     * @date 22/05/2018
     * @return array
     */
    public function get_opciones_secciones($param = null, $idioma = 'es') {
        $this->db->flush_cache();
        $this->db->reset_query();
        $select = array(
            "id_opcion", "id_seccion", "descripcion", "id_rango"
        );
        $result = [];
        $this->db->select($select);
        foreach ($param['where'] as $key => $val) {
            $this->db->where($key, $val);
        }
        $result_prima = $this->db->get('foro.opcion')->result_array();
        $lang = [];
        foreach ($result_prima as &$value) {
            $lang = json_decode($value['descripcion'], true);
            $value['descripcion'] = $lang[$idioma];
            $result[$value['id_seccion']][] = $value;
        }
        return $result;
    }

    /**
     * Devuelve la información de los registros de la tabla catalogos
     * @author LEAS
     * @date 22/05/2018
     * @return array
     */
    public function get_secciones_detalle($param = null, $idioma = 'es') {
        $this->db->flush_cache();
        $this->db->reset_query();
        $select = array(
            "s.id_seccion", "o.id_opcion", "o.descripcion", "r.cualitativa", "r.minimo", "r.maximo"
        );
        $this->db->select($select);
        foreach ($param as $key => $val) {
            foreach ($val as $keyp => $valp) {
                $name = $key . "";
                if (is_null($valp) || $valp == "") {
                    $this->db->{$name}($keyp, null);
                } else {
                    $this->db->{$name}($keyp, $valp);
                }
            }
        }
        $this->db->join('foro.opcion o', 's.id_seccion=o.id_seccion', 'inner');
        $this->db->join('foro.rango r', 'o.id_rango=r.id_rango', 'inner');
        $this->db->order_by("s.id_seccion, o.id_opcion asc");

        $result_prima = $this->db->get('foro.seccion s')->result_array();
        $lang = [];
        $result = [];
        foreach ($result_prima as &$value) {
            $lang = json_decode($value['descripcion'], true);
            $value['descripcion'] = $lang[$idioma];
            $result[$value['id_seccion']][] = $value;
        }
        return $result;
    }

    /**
     * Valida que el rango de la calificacion se encuentre entre la opción seleccionada
     * @author LEAS
     * @date 24/05/2018
     * @param type $id_opcion
     * @param type $calificacion
     * @return type
     */
    public function is_valido_rango_calificacion($id_opcion, $calificacion) {
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->select(["count(*) total"]);
        $this->db->join('foro.rango r', 'r.id_rango = o.id_rango', 'inner');
        $this->db->where($calificacion . " between r.minimo and r.maximo and id_opcion = " . $id_opcion);
        $this->db->where("id_opcion", $id_opcion);
        $result = $this->db->get('foro.opcion o')->result_array();
//        pr($this->db->last_query());
        return ($result[0]['total'] > 0);
    }

    /**
     * 
     * @param type $id_opcion
     * @param type $calificacion
     */
    public function update_conflicto_sn_tema_educacion($folio, $user_revisor, $datos, $language_text = null) {
        $this->db->trans_begin();
        $this->db->where('folio', $folio);
        $this->db->where('id_usuario', $user_revisor);
        $this->db->set($datos, FALSE);
        $this->db->update('foro.revision');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $resultado[En_tpmsg::__default] = En_tpmsg::DANGER;
            $resultado['message'] = $language_text['evaluacion']['danger_update'];
//            $resultado['msg'] = $language_text['registro_usuario']['user_registro_problem'];
        } else {
            $result = $this->actualizar_estado_evaluacion($folio);
            if ($result) {
                $this->db->trans_commit();
                $resultado[En_tpmsg::__default] = En_tpmsg::SUCCESS;
                $resultado['message'] = $language_text['evaluacion']['success_update'];
            } else {
                $resultado[En_tpmsg::__default] = En_tpmsg::DANGER;
                $resultado['message'] = $language_text['evaluacion']['danger_update'];
            }
        }

//                $this->db->last_query();
        return $resultado;
    }

    /**
     * @author LEAS
     * @param type $folio
     * @param type $user_revisor
     * @param type $dias_revisar
     * @return type
     */
    public function get_detalle_revision($folio, $user_revisor, $dias_revisar = 3) {
        $this->db->flush_cache();
        $this->db->reset_query();

        $select = ["rn.id_revision", "rn.id_usuario", "rn.folio", "rn.fecha_asignacion", "rn.fecha_revision",
            "rn.revisado", "rn.conflicto_interes", "rn.tema_educacion",
            "case when (now() <=CAST(rn.fecha_asignacion AS timestamp) + CAST('" . $dias_revisar . " days' AS INTERVAL)) then 1 else 0 end dentro_fecha_limite"
            , "clave_estado"];
        $this->db->select($select);
        $this->db->join('foro.historico_revision hr', 'rn.folio=hr.folio', 'inner');
        $this->db->join('foro.trabajo_investigacion ti', 'hr.folio = ti.folio', 'left');
        $this->db->join('foro.convocatoria cc', 'cc.id_convocatoria = ti.id_convocatoria', 'inner');
        $this->db->where('cc.activo', true);
        $this->db->where('cc.revision', true);
        $this->db->where("rn.id_usuario", $user_revisor);
        $this->db->where("hr.actual", TRUE);
        $this->db->where("rn.activo", TRUE);
        $this->db->where("rn.folio", $folio);
        $result = $this->db->get('foro.revision rn')->result_array();
//        pr($this->db->last_query());
//        pr($this->db->last_query());
//        pr($result);
        return $result;
    }

    /**
     * @author LEAS
     * @param type $folio
     * @param type $dias_revisar
     * @return type
     */
    public function get_general_revision($folio, $dias_revisar = 3) {
        $this->db->flush_cache();
        $this->db->reset_query();

        $select = ["rn.id_revision", "rn.id_usuario", "rn.folio", "rn.fecha_asignacion", "rn.fecha_revision",
            "rn.revisado", "rn.conflicto_interes", "rn.tema_educacion",
            "case when (now() <=CAST(rn.fecha_asignacion AS timestamp) + CAST('" . $dias_revisar . " days' AS INTERVAL)) then 1 else 0 end dentro_fecha_limite"
            , "clave_estado", "rn.promedio_revision"];
        $this->db->select($select);
        $this->db->join('foro.historico_revision hr', 'rn.folio=hr.folio', 'inner');
        $this->db->join('foro.trabajo_investigacion ti', 'hr.folio = ti.folio', 'left');
        $this->db->join('foro.convocatoria cc', 'cc.id_convocatoria = ti.id_convocatoria', 'inner');
        $this->db->where('cc.activo', true);
        $this->db->where('cc.revision', true);
        $this->db->where("hr.actual", TRUE);
        $this->db->where("rn.activo", TRUE);
        $this->db->where("rn.revisado", TRUE);
        $this->db->where("rn.folio", $folio);
        $result = $this->db->get('foro.revision rn')->result_array();
//        pr($this->db->last_query());
        return $result;
    }

    /**
     * 
     * @param type $folio Folio de la investigación
     * @param type $estado_transicion estado de transición actual
     * @return boolean true si se guardosatisfactoriamente
     * Actualiza el último estado de la revision a false y agrega la el nuevo estado.
     * 
     */
    public function guardar_historico_estado($folio, $estado_transicion) {
        $estado = TRUE;
        $this->db->where("folio", $folio);
        $this->db->update("foro.historico_revision", ["actual" => FALSE]);
        if ($this->db->trans_status() === FALSE) {
            $estado = FALSE;
        } else {
            $datos = ["folio" => $folio, "clave_estado" => $estado_transicion, "actual" => true];
            $this->db->insert("foro.historico_revision", $datos);
            if ($this->db->trans_status() === FALSE) {
                $estado = FALSE;
            }
        }
        return $estado;
    }

    /**
     * @author LEAS 
     * @fecha 25/05/2018
     * @param type $folio folio de la investigación
     * @param type $promedio promedio de la revisión
     * @return boolean si se guardo satisfactoriamente
     * Genera el dictamen
     */
    public function genera_dictamen($folio, $promedio) {
        $estado = TRUE;
        $datos = ["folio" => $folio, "promedio" => $promedio];
        $this->db->insert("foro.dictamen", $datos);
        if ($this->db->trans_status() === FALSE) {
            $estado = FALSE;
        }
        return $estado;
    }

    public function guardar_evaluacion($datos_revision, $language_text = null) {
        $this->db->trans_begin();
//        pr($datos_revision);
        foreach ($datos_revision['revision']['condicion'] as $key => $value) {
            $this->db->where($key, $value);
        }

        $this->db->set($datos_revision['revision']['datos'], FALSE);
        $this->db->update('foro.revision');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $resultado[En_tpmsg::__default] = En_tpmsg::DANGER;
            $resultado['message'] = $language_text['evaluacion']['danger_update'];
//            $resultado['msg'] = $language_text['registro_usuario']['user_registro_problem'];
        } else {
            $status = TRUE;
            /* Guarda el detalle de la revision */
            foreach ($datos_revision['detalle_revision'] as $val) {
                $this->db->insert('foro.detalle_revision', $val);
                if ($this->db->trans_status() === FALSE) {
                    $status = FALSE;
                    break;
                }
            }
            if ($status === FALSE) {
                $this->db->trans_rollback();
                $resultado[En_tpmsg::__default] = En_tpmsg::DANGER;
                $resultado['message'] = $language_text['evaluacion']['danger_update'];
            } else {
                $result = $this->actualizar_estado_evaluacion($datos_revision['folio']);
                if ($result[En_tpmsg::SUCCESS]) {
                    $this->db->trans_commit();
                    $resultado[En_tpmsg::__default] = En_tpmsg::SUCCESS;
                    $resultado['message'] = $language_text['evaluacion']['success_update'];
                    $resultado['genero_dictamen'] = $result['genero_dictamen'];
                } else {
                    $resultado[En_tpmsg::__default] = En_tpmsg::DANGER;
                    $resultado['message'] = $language_text['evaluacion']['danger_update'];
                }
            }
        }

//        pr($this->db->reset_query());
        return $resultado;
    }

    /**
     * 
     * @param type $folio
     * @param type $language_text
     * @return type
     */
    public function actualizar_estado_evaluacion($folio, $language_text = null) {
        $actualizacion_estado = [En_estado_revision::EVALUADO => 1, En_estado_revision::DISCREPANCIA => 1, En_estado_revision::CONFLICTO_INTERES => 1, En_estado_revision::RECHAZADO => 1,];
        $result['success'] = true;
        $result['genero_dictamen'] = FALSE;
        $result_estado = $this->obtener_estado_general_revision($folio);
//        pr($result_estado);
//        $this->db->trans_begin();
        if (isset($actualizacion_estado[$result_estado['estado_trancicion']])) {//Estados que pasan validación
//        pr($folio);
//        pr($result_estado);
            $result['success'] = $this->guardar_historico_estado($folio, $result_estado['estado_trancicion']);
            if ($result && $result_estado['estado_trancicion'] == En_estado_revision::EVALUADO) {//Evaluación, agerega promedio
                $result['success'] = $this->genera_dictamen($folio, $result_estado['promedio_general']);
                $result['genero_dictamen'] = true;
            }
//            if ($result) {
//                $this->db->trans_commit();
//            } else {
//            $this->db->trans_rollback();
//            }
        }

        return $result;
    }

    /**
     * 
     * @author LEAS type $diferencia_conf diferencia entre seleccion de opciones de las secciones, por default es de 1 arriba u abajo
     * @author fecha 25/05/2018
     * @param type $revisiones
     * @param type $diferencia_conf
     * @return si es evaluacion o discrepancia según la comparación entre los revisores 1 y dos
     */
    public function obtener_estado_general_revision($folio) {
        $general_revisiones = $this->get_general_revision($folio);
//        pr($folio);
//        pr($general_revisiones);
        $total_revisores = count($general_revisiones);
        $result["estado_trancicion"] = En_estado_revision::__default;
        switch ($total_revisores) {
            case 1:
                $result = $this->un_revisor($general_revisiones);
                break;
            case 2:
                $result = $this->dos_revisores($general_revisiones);
                break;
            case 3:
                $result = $this->tres_revisores($general_revisiones);
                break;
        }
//        pr($general_revisiones);
//        pr($result);
        return $result;
    }

    private function un_revisor($revisiones) {
        $result = ['estado_trancicion' => En_estado_revision::__default];
        $revisiones = $revisiones[0];
//        pr($revisiones);
        if ($revisiones['revisado'] == 1) {
            if ($revisiones['conflicto_interes'] == true) {
                $result["estado_trancicion"] = En_estado_revision::CONFLICTO_INTERES;
            }
        }
        return $result;
    }

    private function dos_revisores($revisiones) {
        $result = ['estado_trancicion' => En_estado_revision::__default];
        $validaciones = ['revisado' => 1, 'conflicto_interes' => 0, 'total_no_tema_educacion' => 0,
            'tema_educacion' => 1, 'dentro_fecha_limite' => 1, 'revisiones_ids' => [], 'suma_promedio' => 0];
        foreach ($revisiones as $value) {
            if (is_numeric($value['promedio_revision'])) {
                $validaciones['suma_promedio'] += floatval($value['promedio_revision']);
            }
            if ($value['revisado'] == 0) {
                $validaciones['revisado'] = 0;
            }
            if ($value['conflicto_interes'] == true) {
                $validaciones['conflicto_interes'] = 1;
            }
            if ($value['tema_educacion'] == 0) {
                $validaciones['tema_educacion'] = 0;
                $validaciones['total_no_tema_educacion'] += 1;
            }
            if ($value['dentro_fecha_limite'] == 0) {
                $validaciones['dentro_fecha_limite'] = 0;
            }
            $validaciones['revisiones_ids'][] = $value['id_revision']; //Obtiene revisiones
        }
        if ($validaciones['revisado'] == 1) {//ya fueron evaluados
            if ($validaciones['conflicto_interes'] == 1) {//tiene por lo menos un conflicto de interes
                $result["estado_trancicion"] = En_estado_revision::CONFLICTO_INTERES;
            } else if ($validaciones['tema_educacion'] == 0) {//existe un "No tema de educación "
                if ($validaciones['total_no_tema_educacion'] == 2) {//Si no existen temas de educación, es automaticamente rechazado
                    $result["estado_trancicion"] = En_estado_revision::RECHAZADO;
                } else {//Por lo menos existe un registro sin tema de interes
                    $result["estado_trancicion"] = En_estado_revision::DISCREPANCIA;
                }
            } else {//deberá hacer una evaluación
                $result["estado_trancicion"] = $this->validar_discrepancia_o_evaluacion($validaciones['revisiones_ids']);
                $result["suma_calificacion"] = $validaciones["suma_promedio"];
                $result["promedio_general"] = $validaciones["suma_promedio"] / 2;
            }
        } else {
            $result["estado_trancicion"] = En_estado_revision::__default;
        }
        return $result;
    }

    private function tres_revisores($revisiones) {
        $result = ['estado_trancicion' => En_estado_revision::__default];
        $validaciones = ['revisado' => 1, 'conflicto_interes' => 0, 'total_no_tema_educacion' => 0,
            'tema_educacion' => 0, 'dentro_fecha_limite' => 1, 'revisiones_ids' => [], 'suma_promedio' => 0];
        foreach ($revisiones as $value) {
            if ($value['revisado'] == 0) {
                $validaciones['revisado'] = 0;
            }
            if ($value['conflicto_interes'] == true) {
                $validaciones['conflicto_interes'] = 1; //detecta un conflicto de interes, lo envíara a conflicto de interes
            }
            if ($value['tema_educacion'] == 0) {//Alguno no es tema relacionado
                $validaciones['total_no_tema_educacion'] += 1; //suma de los temas de educacion 
            } else {
                $validaciones['tema_educacion'] += 1; //no es un tema de educación
                if (is_numeric($value['promedio_revision'])) {//valida que el promedio de la revision sea numerico
                    $validaciones['suma_promedio'] += floatval($value['promedio_revision']);
                }
            }
            $validaciones['revisiones_ids'][] = $value['id_revision']; //Obtiene revisiones
        }
        if ($validaciones['revisado'] == 1) {//ya fueron evaluados
            if ($validaciones['conflicto_interes'] == 1) {//tiene por lo menos un conflicto de interes
                $result["estado_trancicion"] = En_estado_revision::CONFLICTO_INTERES;
            } else if ($validaciones['total_no_tema_educacion'] > 1) {//Existe más de un "No tema de educación "
                $result["estado_trancicion"] = En_estado_revision::RECHAZADO;
            } else {//deberá hacer una evaluación
                $result["suma_calificacion"] = $validaciones["suma_promedio"];
                $result["promedio_general"] = $validaciones["suma_promedio"] / $validaciones['tema_educacion'];
                $result["estado_trancicion"] = En_estado_revision::EVALUADO;
            }
        } else {
            $result["estado_trancicion"] = En_estado_revision::__default;
        }
        return $result;
    }

    /**
     * 
     * @author LEAS type $diferencia_conf diferencia entre seleccion de opciones de las secciones, por default es de 1 arriba u abajo
     * @author fecha 25/05/2018
     * @param type $revisiones
     * @param type $diferencia_conf
     * @return si es evaluacion o discrepancia según la comparación entre los revisores 1 y dos
     */
    private function validar_discrepancia_o_evaluacion($revisiones, $diferencia_conf = 1) {
        $estado = En_estado_revision::__default;
        if (!empty($revisiones) && count($revisiones) == 2) {//valida que se vayan a revisar o a comparar dos revisiones, ya que es el punto donde se ve si existe discrepancia
            $select = ["r.id_revision", "r.id_usuario",
                "dr.id_detalle", "dr.id_seccion", "dr.id_opcion", "dr.valor"];
            $this->db->select($select);
            $this->db->join('foro.revision r', 'r.id_revision = dr.id_revision', 'inner');
            $this->db->where_in("dr.id_revision", $revisiones);
            $this->db->where("r.activo", TRUE);
            $result = $this->db->get('foro.detalle_revision dr')->result_array();

            if (!empty($result)) {
                $detalle_evaluacion = [];
                $secciones = [];
                foreach ($result as $evaluacion) {//Recorre para buscar diferencias
                    $secciones[$evaluacion['id_seccion']][] = $evaluacion['id_opcion'];
                }
                $estado = En_estado_revision::EVALUADO;
                foreach ($secciones as $key => $data) {//Compara resultados de opción, la regla dice que sie existe una diferencia de 1 entre seleccion de las opciones es considerado discrepancia
                    $resta[$key] = abs($data[0] - $data[1]);
                    if ($resta[$key] > $diferencia_conf) {//Valida que la diferencia de selección de opciones no sea mayor que el configurador
                        $estado = En_estado_revision::DISCREPANCIA;
                        break;
                    }
                }
            }
        }
//        pr($estado);
        return $estado;
    }

}
