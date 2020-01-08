<?php

class PacienteController extends Zend_Controller_Action
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
    }

public function preDispatch(){
    $auth = Zend_Auth::getInstance();
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

