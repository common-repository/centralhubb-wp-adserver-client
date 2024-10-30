<?php

namespace CentralHubb;

/**
 * Class CentralHubbAttributes
 *
 * @package CentralHubb
 */
class CentralHubbAttributes {

    /** @var array $data */
    protected $data = [];

    /**
     * CentralHubbBase constructor.
     */
    public function  __construct()
    {
        $this->initData();
    }

    /**
     * initData.
     */
    public function initData()
    {
        $data = [];
        $data = array_merge($data, !empty($_GET) ? $_GET : []);
        $data = array_merge($data, !empty($_POST) ? $_POST : []);
        $this->data = $data;
    }

    /**
     * sanitizeAlphaNumeric.
     *
     * @param $value
     * @return mixed
     */
    public function sanitizeAlphaNumeric($value)
    {
        return preg_replace("/[^A-Za-z0-9-., ]/", '', $value);
    }

    /**
     * sanitizeAlpha.
     *
     * @param $value
     * @return mixed
     */
    public function sanitizeAlpha($value)
    {
        return preg_replace("/[^A-Za-z]/", '', $value);
    }

    /**
     * sanitizeNumeric.
     *
     * @param $value
     * @return mixed
     */
    public function sanitizeNumeric($value)
    {
        return preg_replace("/[^0-9]/", '', $value);
    }

    /**
     * sanitizeUrl.
     *
     * @param $value
     * @return mixed
     */
    public function sanitizeUrl($value)
    {
        return esc_url($value);
    }

    /**
     * getSanitizedPost.
     *
     * @return array
     */
    public function getSanitizedPost()
    {
        $post = !empty($_POST) ? $_POST : [];

        if(!empty($post)) {
            foreach($post as $key => $value) {
                $post[$key] = $this->sanitizeAlphaNumeric($value);
            }
        }

        return $post;
    }

    /**
     * getNonce.
     *
     * @return mixed|null
     */
    public function getNonce()
    {
        return !empty($this->data['ch_nonce']) ? $this->sanitizeAlphaNumeric($this->data['ch_nonce']) : null;
    }

    /**
     * getId.
     *
     * @return int|mixed
     */
    public function getId()
    {
        return !empty($this->data['id']) ? $this->sanitizeNumeric($this->data['id']) : null;
    }

    /**
     * getType.
     *
     * @return int|mixed
     */
    public function getType()
    {
        return !empty($this->data['type']) ? $this->sanitizeAlphaNumeric($this->data['type']) : null;
    }

    /**
     * getTokens.
     *
     * @return int|mixed
     */
    public function getTokens()
    {
        return !empty($this->data['tokens']) ? $this->sanitizeAlphaNumeric($this->data['tokens']) : null;
    }

    /**
     * getUrl.
     *
     * @return int|mixed
     */
    public function getUrl()
    {
        return !empty($this->data['url']) ? $this->sanitizeUrl($this->data['url']) : null;
    }

    /**
     * getModule.
     *
     * @return int|mixed
     */
    public function getModule()
    {
        return !empty($this->data['module']) ? $this->sanitizeAlpha($this->data['module']) : null;
    }

    /**
     * getController.
     *
     * @return int|mixed
     */
    public function getController()
    {
        return !empty($this->data['module']) ? $this->sanitizeAlpha($this->data['module']) : null;
    }

    /**
     * getAction.
     *
     * @return int|mixed
     */
    public function getAction()
    {
        return !empty($this->data['action']) ? $this->sanitizeAlpha($this->data['action']) : null;
    }

    /**
     * getPage.
     *
     * @return int|mixed
     */
    public function getPage()
    {
        return !empty($this->data['page']) ? $this->sanitizeAlphaNumeric($this->data['page']) : null;
    }

}