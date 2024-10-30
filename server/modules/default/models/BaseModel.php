<?php

namespace CentralHubb\Mvc\Models;

/**
 * Class BaseModel
 *
 * @package CentralHubb\Mvc\Models
 */
class BaseModel {

    /** @var string $table */
	public $table = 'table1';

    /**
     * Base constructor.
     *
     */
	public function __construct() {
		$this->wpdb = $GLOBALS['wpdb'];
	}

    /**
     * getResults.
     *
     * @return mixed
     */
	public function getResults() {
		// return $this->wpdb->get_results("select * from ".$this->table);
	}
}
