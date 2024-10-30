<?php

namespace CentralHubb\Mvc\Controllers;

/**
 * Class IndexController
 *
 * @package CentralHubb\Mvc\Controllers
 */
class IndexController extends BaseController {

    /**
     * indexAction.
     */
	public function indexAction() {
        return [
            'data' => true
        ];
	}
}
