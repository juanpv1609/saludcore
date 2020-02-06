<?php

class Application_Model_DbTable_Laboratorio extends Zend_Db_Table_Abstract
{

    protected $_name = 'laboratorio';
    public function contar_pedidos() {//carga el select con todos los tipos de muestra desde la bdd
        $db = Zend_Registry::get('pgdb');
        //opcional, esto es para que devuelva los resultados como objetos $row->campo
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $select = "SELECT count(*) FROM pedido_examen";
        return $db->fetchRow($select);
    }
    public function buscarPruebasTodo() {//busca la informacion del pedido de acuerdo al numero de pedido

        $db = Zend_Registry::get('pgdb');
        //opcional, esto es para que devuelva los resultados como objetos $row->campo
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $select = "select e.tipo_pedido,l.fecha_agenda_laboratorio,e.pedido_examen_id as q,e.hc_digital as w,a.ci as e,a.apellido_paterno as r,a.apellido_materno as t,
                    a.primer_nombre as y,a.segundo_nombre as u,a.fecha_nacimiento as i,a.sexo as o,
                    e.periodo_gestacion as p,to_char(e.fecha_pedido, 'DD/MM/YYYY HH12:MI:SS') as a,p.descripcion as s,i.estado_atencion_descripcion,
			e.solicitante
                    from pedido_examen e
                    join prioridad p
                    on p.prioridad_id=e.prioridad
                    join paciente a
                    on a.hc_digital=e.hc_digital
                    join estado_atencion i
                    on i.estado_atencion_id=e.estado_atencion
                    join turno_laboratorio t
                    on t.id_turno_laboratorio=turno
                    join agenda_laboratorio l
                    on l.id_agenda_laboratorio=t.id_agenda
                    order by 3";
        return $db->fetchAll($select);
    }
    public function cuenta($id) {
        $db = Zend_Registry::get('pgdb');
        //opcional, esto es para que devuelva los resultados como objetos $row->campo
        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $select = "select e.id_tipo as t,t.descripcion as d
            from examen_laboratorio e
                    join tipo_examen t
                    on t.tipo_examen_id=e.id_tipo
                    where examen_laboratorio_id IN (select d.examen_id
                    from detalle_pedido d
                    where d.pedido_id=".$id.")
                        group by e.id_tipo,t.descripcion
                            order by 2";
        return $db->fetchAll($select);
    }
    public function datosPersonales($id) {
        $db = Zend_Registry::get('pgdb');
        //opcional, esto es para que devuelva los resultados como objetos $row->campo
        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        $select = "select p.* ,to_char(e.fecha_pedido, 'DD/MM/YYYY') as fecha
        from pedido_examen e
        join paciente p on p.hc_digital=e.hc_digital
        where e.pedido_examen_id=".$id;
        return $db->fetchRow($select);
    }
    public function detallePruebas($id, $d) {//muestra las tarjetas de pruebas dependiendo del ID del pedido seleccionado
        $db = Zend_Registry::get('pgdb');
        //opcional, esto es para que devuelva los resultados como objetos $row->campo
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $select = "select e.cod_grupo,e.examen_laboratorio_id,e.id_tipo as t,t.tipo_examen_id,e.descripcion as d,t.descripcion as s ,e.cod_roche
            from examen_laboratorio e
                    join tipo_examen t
                    on t.tipo_examen_id=e.id_tipo
                    where t.tipo_examen_id=".$d."
                    and examen_laboratorio_id IN (select d.examen_id
                    from detalle_pedido d
                    where d.pedido_id=".$id.")
                    group by e.cod_grupo,e.examen_laboratorio_id,e.id_tipo,t.tipo_examen_id,e.descripcion,t.descripcion,e.cod_roche
                    order by 5";
        return $db->fetchAll($select);
    }
}

