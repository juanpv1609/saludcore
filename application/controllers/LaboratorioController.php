<?php

class LaboratorioController extends Zend_Controller_Action
{

    public function init()
    {
        $this->initView();
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->view->user = Zend_Auth::getInstance()->getIdentity();
    }

    public function indexAction()
    {
        // action body
    }

    public function preDispatch()
    {
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

    public function pedidoAction()
    {
        // action body
    }

    public function listarAction()
    {
        // action body
        $this->view->data = $this->tabla_pedidos_todo();
        
        //$this->view->pruebas = $this->tabla_pruebas();
    }
    public function buscaAction()
    {
        // action body
        $this->_helper->viewRenderer->setNoRender(); //No necesitamos el render de la vista en una llamada ajax.
        $this->_helper->layout->disableLayout(); // Solo si estas usando Zend_Layout
        if ($this->getRequest()->isXmlHttpRequest()) {//Detectamos si es una llamada AJAX
            $id = $this->getRequest()->getParam('id');
            
            echo $this->tabla_pruebas($id);
            
        }
       
    }
    public function buscadatosAction()
    {
        // action body
        $this->_helper->viewRenderer->setNoRender(); //No necesitamos el render de la vista en una llamada ajax.
        $this->_helper->layout->disableLayout(); // Solo si estas usando Zend_Layout
        if ($this->getRequest()->isXmlHttpRequest()) {//Detectamos si es una llamada AJAX
            $id = $this->getRequest()->getParam('id');
            $table = new Application_Model_DbTable_Laboratorio();
            $datos =$table->datosPersonales($id);
            $response = array(); //Declaro un array para enviar los datos a la vista
        }
        $response['data'] = $datos;
        $json = json_encode($response);
        echo $json;
       
    }
    public function tabla_pedidos_todo() {//muestra informacion del pedido por el numero de pedido
      $table_m = new Application_Model_DbTable_Laboratorio(); //objeto del modelo historial
      $datosarea = $table_m->buscarPruebasTodo();

      $Listaarea = '';

      if (!$datosarea) {
          $Listaarea.="<p class='alert alert-danger'> No se han encontrado registros </p>";
      } else {
          $Listaarea.= '
              
              <table name="tabla_pedidos" id="tabla_pedidos" class="table table-bordered table-condensed table-hover table-sm" >
                               <thead ><tr>
                               
                                  <td> <strong>N. ARCHIVO</strong></td>
                                  <td><strong>CEDULA</strong></td>
                                  <td> <strong>APELLIDOS</strong></td>
                                  <td><strong>NOMBRES</strong></td>
                                  <td><strong>SEXO</strong></td>
                                  <td><strong>FECHA-PEDIDO</strong></td>
                                  <td><strong>FECHA-TURNO</strong></td>
        <td><strong>SOLICITANTE</strong></td>
                                  <td> <strong>PRIORIDAD</strong></td>
                                  <td> <strong>ESTADO</strong></td>
                                  <td> <strong>ACCION</strong></td>
                              </tr></thead>
                             <tbody >';
          foreach ($datosarea as $item):
            
              $boton = "";
              $tipo = $item->tipo_pedido;
              if ($tipo == 0) {
                  $boton = "";
              } else {
                  $boton = 'disabled="true"';
              }
              $Listaarea.= "<tr> ";
              $Listaarea.= "<td>" . $item->w . "</td>";
              $Listaarea.= "<td>" . $item->e . "</td>";
              $Listaarea.= "<td>" . $item->r . " " . $item->t . "</td>";
              $Listaarea.= "<td>" . $item->y . " " . $item->u . "</td>";
              $Listaarea.= "<td>" . $item->o . "</td>";
              $Listaarea.= "<td>" . $item->a . "</td>";
              $Listaarea.= "<td>" . $item->fecha_agenda_laboratorio . "</td>";
              $Listaarea.= "<td>" . $item->solicitante . "</td>";
              $Listaarea.= "<td>" . $item->s . "</td>";
              $Listaarea.= "<td>" . $item->estado_atencion_descripcion . "</td>";
              $Listaarea.= '<td> <button id="eligir" class="btn btn-warning btn-sm" 
              title="Clic para visualizar pedido"  onclick="busca_examenes('. $item->q .')" >
              <i class="fa fa-search"></i></button>
              </td>'; //abre el modal con informacion del pedido
              $Listaarea.= '</tr>';
          endforeach;

          $Listaarea.= '</tbody></table>';
      }

      return $Listaarea;
  }
  public function tabla_pruebas($id) {
    $table_m = new Application_Model_DbTable_Laboratorio();
    $cuenta = $table_m->cuenta($id);
    $Listaarea = '';
    if ((!$cuenta)) {
        $Listaarea.="<p class='alert alert-danger'> No se han encontrado registros </p>";
    } else if ($cuenta) {
        $Listaarea.='<small><div class="row" >';
        foreach ($cuenta as $item2):
            $Listaarea.= '<div id="tarjeta" class="col-sm-4">
                <ul class="list-group">
                     <li class="list-group-item bg bg-gray">' . $item2->d . '</li>';
            $datosarea = $table_m->detallePruebas($id, $item2->t);
            foreach ($datosarea as $item):
                //$Listaarea.= ' <li id="a" name="a" title="Doble clic para eliminar" class="list-group-item list-group-item-action" style="height: 4px" value="' . $item->examen_laboratorio_id . '"><strong>' . $item->examen_laboratorio_id . " / " . $item->d . '</strong></li>';
                $Listaarea.= '<li class="list-group-item">'  . $item->d . '
                <span class="badge badge-primary badge-pill">'. $item->examen_laboratorio_id .'</span></li>';
            endforeach;
            $Listaarea.= '</ul></div>';
        endforeach;
        $Listaarea.= '</div></small>';
    }
    return $Listaarea;
  }
  
}








