<?php

namespace CentralHubb;

/**
 * Class CentralHubbApi
 *
 * @package CentralHubb
 */
class CentralHubbApi extends CentralhubbBase
{
    /** @var string $accessToken */
    protected $accessToken = null;

    /** @var string $baseUrl */
    protected $baseUrl = null;

    /** @var string $response */
    protected $response = null;

    /**
     * CentralHubbApi constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $settings = get_option('central_hubb_settings');

        $this->accessToken = !empty($settings['access_token']) ? $this->sanitizeAlphaNumeric($settings['access_token']) : null;
        $this->baseUrl = _CENTRAL_HUBB_PLUGIN_API_URL_;

        add_action('rest_api_init', function () {
            register_rest_route('v1', '.*', array(
                'methods' => 'GET',
                'callback' => array($this, 'getResponseBody'),
            ));

            register_rest_route('v1', '.*', array(
                'methods' => 'POST',
                'callback' => array($this, 'getResponseBody'),
            ));
        });
    }

    /**
     * getResponseBody.
     */
    public function getResponseBody()
    {
        $uriSegments = explode('v1/', !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null);
        $uri = !empty($uriSegments[1]) ? $this->baseUrl . '/' . $uriSegments[1] : null;

        if (strlen(strstr($uri,'?')) > 0) {
            $uri .= '&access_token='.$this->accessToken;
        } else {
            $uri .= '?access_token='.$this->accessToken;
        }

        if (!empty($_POST)) {

            $response = wp_remote_post($uri, ['body' => $this->getSanitizedPost()]);

        } else {
            $response = wp_remote_get($uri);
        }

        echo !empty($response['body']) ? $response['body'] : '';
        exit;
    }
}
