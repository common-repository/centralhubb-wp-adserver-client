<?php

namespace CentralHubb;

/**
 * Class CentralHubbMvc
 *
 * @package CentralHubb
 */
class CentralHubbMvc extends CentralhubbBase {

    /** @var string $domain */
    public $domain = '';

    /** @var string $moduleName */
	public $moduleName = 'default';

	/** @var string $controllerName */
	public $controllerName = 'index';

	/** @var string $actionName */
	public $actionName = 'index';

	/** @var string $modelName */
	public $modelName = 'BaseModel';

	/** @var $controllerClass */
	public $controllerClass;

	/** @var $modelClass */
	public $modelClass;

	/** @var $actionResponse */
	public $actionResponse;

    /**
     * Central_Hubb_Ad_Server_Bootstrap constructor.
     *
     */
	public function __construct() {

        parent::__construct();

	    $this->domain = _CENTRAL_HUBB_PLUGIN_APP_URL_;

		$this->initMvcRequest();
		$this->initModel();
        $this->initController();
        $this->initAction();
        $this->initView();
	}

    /**
     * initMvcRequest.
     */
	public function initMvcRequest() {
		$this->moduleName 		= !empty($this->getModule()) ? $this->getModule() : $this->moduleName;
		$this->controllerName 	= !empty($this->getController()) ? $this->getController() : $this->controllerName;
		$this->actionName 		= !empty($this->getAction()) ? $this->getAction() : $this->actionName;
	}

    /**
     * initModel.
     */
    public function initModel() {
        require_once _CENTRAL_HUBB_PLUGIN_PATH_.'/server/modules/'.$this->moduleName.'/models/'.$this->modelName.'.php';
        $modelName = '\\CentralHubb\Mvc\Models\\'.$this->modelName;
        $this->modelClass = new $modelName();
    }

    /**
     * initController.
     */
    public function initController() {
        require_once _CENTRAL_HUBB_PLUGIN_PATH_.'/server/modules/default/controllers/BaseController.php';
        require_once _CENTRAL_HUBB_PLUGIN_PATH_.'/server/modules/'.$this->moduleName.'/controllers/'.ucfirst($this->controllerName).'Controller.php';
        $controllerClass = '\\CentralHubb\Mvc\Controllers\\'.ucfirst($this->controllerName).'Controller';
        $this->controllerClass = new $controllerClass($this->modelClass);
    }


    /**
     * initAction.
     */
	public function initAction() {
		$actionMethod = $this->actionName.'Action';
		if(method_exists($this->controllerClass, $actionMethod)) {
			$this->actionResponse = $this->controllerClass->$actionMethod();
		}
	}

    /**
     * initView.
     */
	public function initView() {
		$file = _CENTRAL_HUBB_PLUGIN_PATH_.'/server/modules/'.$this->moduleName.'/views/'.$this->controllerName.'/'.$this->actionName.'.php';

        $domain = $this->domain;

        switch($this->getPage())
        {
            case 'central-hubb-ad-server-advertisers':
                $viewUrl = $domain.'/app/advertisers';
                break;

            case 'central-hubb-ad-server-publishers':
                $viewUrl = $domain.'/app/publishers';
                break;

            case 'central-hubb-ad-server-websites':
                $viewUrl = $domain.'/app/websites';
                break;

            case 'central-hubb-ad-server-images':
                $viewUrl = $domain.'/app/images';
                break;

            case 'central-hubb-ad-server-videos':
                $viewUrl = $domain.'/app/videos';
                break;

            case 'central-hubb-ad-server-placeholders':
                $viewUrl = $domain.'/app/placeholders';
                break;

            case 'central-hubb-ad-server-placements':
                $viewUrl = $domain.'/app/placements';
                break;

            case 'central-hubb-ad-server-placement-previews':
                $viewUrl = $domain.'/app/placement/previews';
                break;

            case 'central-hubb-ad-server-analytics-charts-impressions':
                $viewUrl = $domain.'/app/analytics/charts/impressions';
                break;

            case 'central-hubb-ad-server-analytics-charts-clicks':
                $viewUrl = $domain.'/app/analytics/charts/clicks';
                break;

            case 'central-hubb-ad-server-analytics-reports-impressions':
                $viewUrl = $domain.'/app/analytics/reports/impressions';
                break;

            case 'central-hubb-ad-server-analytics-reports-clicks':
                $viewUrl = $domain.'/app/analytics/reports/clicks';
                break;


            case 'central-hubb-ad-server-my-account':
                $viewUrl = $domain.'/app/my-account/update-account-info';
                break;

            case 'central-hubb-ad-server-wp-settings':
                $viewUrl = $domain.'/app/my-account/wp-settings';
                break;


            default:
                $viewUrl = $domain.'/app/advertisers';
                break;
        }

        require_once $file;
	}
}
