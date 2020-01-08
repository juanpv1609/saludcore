<?php

class Application_Model_DbTable_Paciente extends Zend_Db_Table_Abstract
{

    protected $_name = 'paciente';
     public function listar_pacientes() {//carga el select con todos los tipos de muestra desde la bdd
        $db = Zend_Registry::get('pgdb');
        //opcional, esto es para que devuelva los resultados como objetos $row->campo
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $select = "SELECT * FROM paciente";
        return $db->fetchAll($select);
    }
    public function contar_pacientes() {//carga el select con todos los tipos de muestra desde la bdd
        $db = Zend_Registry::get('pgdb');
        //opcional, esto es para que devuelva los resultados como objetos $row->campo
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $select = "SELECT count(*) FROM paciente";
        return $db->fetchRow($select);
    }

}

