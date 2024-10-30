<?php

namespace CentralHubb\Mvc\Controllers;

/**
 * Class BaseController
 *
 */
class BaseController {

    /** @var $model */
    protected $model;

    /**
     * BaseController constructor.
     *
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }
}
