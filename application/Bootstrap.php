<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
protected function _initView()
   {
//original
     $view = new Zend_View();
     $view->setEncoding('UTF-8');
     $view->doctype('XHTML1_STRICT');
     $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
     //Agrego el path de ZendX para poder usar JQuerry
     $view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
     $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
     $viewRenderer->setView($view);


     return $view;
   }

}

