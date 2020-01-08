<?php

class Application_Model_DbTable_Usuario extends Zend_Db_Table_Abstract
{

    protected $_name = 'usuarios';

    public function listar_usuarios() {//carga el select con todos los tipos de muestra desde la bdd
        $db = Zend_Registry::get('pgdb');
        //opcional, esto es para que devuelva los resultados como objetos $row->campo
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $select = "SELECT * FROM usuarios u
            join perfil_usuario p
            on p.perfil_usuario_id=u.perfil
            join estado e
            on e.estado_id=u.estado";
        return $db->fetchAll($select);
    }
    public function contar_usuarios() {//carga el select con todos los tipos de muestra desde la bdd
        $db = Zend_Registry::get('pgdb');
        //opcional, esto es para que devuelva los resultados como objetos $row->campo
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $select = "SELECT count(*) FROM usuarios";
        return $db->fetchRow($select);
    }
    public function insertarusuario($usuario,$correo,$clave) {
        $db = Zend_Registry::get('pgdb');
        //opcional, esto es para que devuelva los resultados como objetos $row->campo
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $select = "INSERT INTO usuarios(usuario, email, clave, perfil,fecha_creacion,estado)
    VALUES ('".$usuario."','".$correo."' ,MD5('".$clave."'),1,(select now()),0); ";
        return $db->fetchRow($select);
    }

}

