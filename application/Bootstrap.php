<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

	protected function _initAutoload() {
		$front = Zend_Controller_Front::getInstance();
		$front->registerPlugin(new Plugin_Authenticate());
	}

	protected function _initResourceLoader() {
		$resourceLoader = new Zend_Loader_Autoloader_Resource(array(
			'basePath'=>APPLICATION_PATH,
			'namespace'=>'',//would normally be "Application" leading to "Application_" prefixed to *all* classes
			'resourceTypes'=>array(
				'model'=>array(
					'path'=>'models/',
					'namespace'=>'Model',
				),
				'mapper'=>array(
					'path'=>'models/mappers/',
					'namespace'=>'Model_Mapper',
				),
				'form'=>array(
					'path'=>'forms/',
					'namespace'=>'Form',
				),
				'orm'=>array(
					'path'=>'models/orm/',
					'namespace'=>'ORM',
				),
			),
		));
		return $resourceLoader;
	}

	protected function _initDoctype() {
		$this->bootstrap('view');
		$view = $this->getResource('view');
		$view->doctype('HTML5');
	}

	protected function _initViewHelpers() {
		$view = $this->getResource('view');
		$view->addHelperPath('ZendX/JQuery/View/Helper', 'ZendX_JQuery_View_Helper');
		$view->jQuery()
			->addStylesheet('/js/jquery/css/cupertino/jquery-ui-1.8.23.custom.css')
			->setLocalPath('/js/jquery/js/jquery-1.8.0.min.js')
			->setUiLocalPath('/js/jquery/js/jquery-ui-1.8.23.custom.min.js')
			->addJavascriptFile('/js/jquery/js/jquery.ba-bbq.min.js');
		$view->jQuery()
			->enable()
			->uiEnable();
	}
}
