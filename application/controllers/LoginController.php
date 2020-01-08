<?php

class LoginController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->initView();
        $this->view->baseUrl = $this->_request->getBaseUrl();
    }

    public function indexAction()
    {
        // action body
        $this->_helper->layout->disableLayout();
        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_StripTags'); //Filtro para parametros de imgreso
            $f = new Zend_Filter_StripTags();
            $usuario = $f->filter($this->_request->getPost('user')); //capturamos y filtramos el nombre de usuario
            $clave = $f->filter($this->_request->getPost('clave')); //capturamos y filtramos el password del usuario

            if (empty($usuario)) {//Verificamos el user name si es vacio enviamos un error
                $this->view->message = '<div class="alert alert-danger alert-dismissible">
                    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="icon fa fa-ban"></i>Por favor ingrese su nombre de usuario</div>';
            } else { //Declaro un array para enviar los datos a la vista
                Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable'); //Cargamos laclase  de Zend Auth
                $dbAdapter = Zend_Registry::get('pgdb'); //a traves de la variable de registro de la conexion creamos el adpatador
                $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
                $authAdapter->setTableName('usuarios');  //configuramos la tabla de usuarios
                $authAdapter->setIdentityColumn('usuario'); //configuramos el nombre de usuario para su verificacion
                $authAdapter->setCredentialColumn('clave'); // configuramos el password para su verificacion

                $authAdapter->setIdentity($usuario);   //registramos el username enviado para su validacion
                $authAdapter->setCredential(md5($clave)); //registramos contraseña enviado para su validacion

                $auth = Zend_Auth::getInstance(); //creamos una intancia de Zend Auth
                $result = $auth->authenticate($authAdapter); // enviamos los parametros para su validacion


                if ($result->isValid()) {
                    $data = $authAdapter->getResultRowObject(null, 'clave'); //almacenamos los datos excepto el password
                    $auth->getStorage()->write($data); //creamos la sesion para el usuario
                    $this->_helper->redirector('index', 'index'); //direccionamos al menu de inicio
                } else {// //Si las credenciales no son validas mostramos un error
                    $this->view->message = '<div class="alert alert-danger alert-dismissible">
                        <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-ban"></i>Las credenciales de autenticación no son validas</div>';
                }
            }
        } else { //Recibo un error por Gets
            $error = $this->_getParam('e', 1);
            if ($error == 0) {
                $this->view->message = '<div class="alert alert-danger alert-dismissible">
                    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
                    Las credenciales de autenticación proporcionadas no tienen permiso para acceder a este módulo</div>';
            }
        }
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity(); //cerramos la sesion del usuario
               $this->_redirect('login/index'); // direccionamos al login
    }

    public function registroAction()
    {
        $this->_helper->layout->disableLayout(); // Solo si estas usando Zend_Layout
        
    
    }
    public function agregarAction()
    {
        $this->_helper->viewRenderer->setNoRender(); //No necesitamos el render de la vista en una llamada ajax.
        $this->_helper->layout->disableLayout(); // Solo si estas usando Zend_Layout
        if ($this->getRequest()->isXmlHttpRequest()) {//Detectamos si es una llamada AJAX
            $usuario = $this->getRequest()->getParam('usuario');
            $correo = $this->getRequest()->getParam('correo');
            $clave = $this->getRequest()->getParam('clave');
            $table = new Application_Model_DbTable_Usuario();
            $datoshc = $table->insertarusuario($usuario, $correo, $clave);
                    $response = array(); //Declaro un array para enviar los datos a la vista
        }
        $response['data'] = $datoshc;
        $json = json_encode($response);
        echo $json;
    
    }

}



