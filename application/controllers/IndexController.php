<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
       $this->initView();
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->view->user = Zend_Auth::getInstance()->getIdentity();
      
      
    }

    public function indexAction()
    {
        // action body
        $modelo = new Application_Model_DbTable_Usuario();
        $usuarios = $modelo->contar_usuarios();
        $this->view->total_usuarios = $usuarios->count;
        $modelo2 = new Application_Model_DbTable_Paciente();
        $pacientes = $modelo2->contar_pacientes();
        $this->view->total_pacientes = $pacientes->count;
        $modelo3 = new Application_Model_DbTable_Laboratorio();
        $pedidos_lab = $modelo3->contar_pedidos();
        $this->view->total_pedidos = $pedidos_lab->count;
    }
    function preDispatch()
    { $auth = Zend_Auth::getInstance();
      if (!$auth->hasIdentity()) {
       $this->_redirect('login/index');
      }
      /*else if($auth->hasIdentity()) {
        $user = $auth->getIdentity();
          if( $user->id_perfil == 4){
            Zend_Auth::getInstance()->clearIdentity();
            $this->_redirect('auth/login/e/0');
          }
       }*/
    }

}

