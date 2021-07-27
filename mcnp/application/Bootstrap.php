<?php
require_once 'util/Utils.php';
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initAppAutoload() {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('ZendX_');
        return $autoloader;
    }

    protected function _initView() {
        $view = new Zend_View();
        $view->doctype('XHTML1_STRICT');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8')
                ->appendHttpEquiv('Content-Language', 'fr-FR');
        $view->setEncoding('UTF-8');
        //... code de paramétrage de votre vue : titre, doctype ...
        $templatePath = APPLICATION_PATH . "/layout/scripts/";
        $layout = Zend_Layout::startMvc()->setLayout('layout')->setLayoutPath($templatePath)->setContentKey('content');
        $view->setBasePath($templatePath);
        $view->setScriptPath(APPLICATION_PATH);
        $view->addHelperPath('ZendX/JQuery/View/Helper', 'ZendX_JQuery_View_Helper');
        $view->jQuery()->setLocalPath('/js/jquery-1.8.3.min.js')
                ->setUILocalPath('/js/jquery-ui-1.9.2.custom.min.js');
        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer ();
        $viewRenderer->setView($view);
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
        return $this;
    }
    protected function _initAutoloadRessource()
{
	//configuration de l'Autoload
	$ressourceLoader = new Zend_Loader_Autoloader_Resource(array(
		'namespace' => 'Default',
		'basePath'  => dirname(__FILE__),
	));
 
	//permet d'indiquer les répertoires dans lesquels se trouveront nos classes:
	//notamment, l'ACL et le pugin
	$ressourceLoader->addResourceType('form', 'forms/', 'Form')
					->addResourceType('acl', 'acls/', 'Acl')
					->addResourceType('model', 'models/', 'Model')
					->addResourceType('plugin', 'plugins/', 'Controller_Plugin')
					//ajout du nouveau dossier pdfs pour l'autoload
					->addResourceType('pdf', 'pdfs/', 'Pdf');
 
	return $ressourceLoader;
}

}

