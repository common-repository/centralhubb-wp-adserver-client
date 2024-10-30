<?php

namespace CentralHubb;

/**
 * Class CentralHubbPlugin
 *
 * @package CentralHubb
 */
class CentralHubbPlugin extends CentralhubbBase
{
    /**
     * CentralHubbWordpressPlugin constructor.
     */
    public function __construct()
    {
        parent::__construct();

        add_action('admin_menu', array( $this, 'adminMenu' ));
        add_action('wp_footer', array( $this, 'enqueueJs' ));

        add_shortcode( 'central-hubb-image-playlist', array( $this, 'getShortCodeImagePlaylist' ));
        add_shortcode( 'central-hubb-video', array( $this, 'getShortCodeVideo' ));
    }

    /**
     * adminMenu
     */
    public function adminMenu()
    {
        add_menu_page( 'CentralHubb', 'CentralHubb', 'manage_options', 'central-hubb-ad-server', array( $this, 'adminPages' ), 'dashicons-chart-bar');
        add_submenu_page( 'central-hubb-ad-server', 'Advertisers', 'Advertisers', 'manage_options', 'central-hubb-ad-server', array( $this, 'adminPages' ));
        add_submenu_page( 'central-hubb-ad-server', 'Publishers', 'Publishers', 'manage_options', 'central-hubb-ad-server-publishers', array( $this, 'adminPages' ));
        add_submenu_page( 'central-hubb-ad-server', 'Websites', 'Websites', 'manage_options', 'central-hubb-ad-server-websites', array( $this, 'adminPages' ));
        add_submenu_page( 'central-hubb-ad-server', 'Images', 'Images', 'manage_options', 'central-hubb-ad-server-images', array( $this, 'adminPages' ));
        add_submenu_page( 'central-hubb-ad-server', 'Videos', 'Videos', 'manage_options', 'central-hubb-ad-server-videos', array( $this, 'adminPages' ));
        add_submenu_page( 'central-hubb-ad-server', 'Placeholders', 'Placeholders', 'manage_options', 'central-hubb-ad-server-placeholders', array( $this, 'adminPages' ));
        add_submenu_page( 'central-hubb-ad-server', 'Placements', 'Placements', 'manage_options', 'central-hubb-ad-server-placements', array( $this, 'adminPages' ));
        add_submenu_page( 'central-hubb-ad-server', 'Placement Previews', 'Placement Previews', 'manage_options', 'central-hubb-ad-server-placement-previews', array( $this, 'adminPages' ));
        add_submenu_page( 'central-hubb-ad-server', 'Charts: Impressions', 'Charts: Impressions', 'manage_options', 'central-hubb-ad-server-analytics-charts-impressions', array( $this, 'adminPages' ));
        add_submenu_page( 'central-hubb-ad-server', 'Charts: Clicks', 'Charts: Clicks', 'manage_options', 'central-hubb-ad-server-analytics-charts-clicks', array( $this, 'adminPages' ));
        add_submenu_page( 'central-hubb-ad-server', 'Reports: Impressions', 'Reports: Impressions', 'manage_options', 'central-hubb-ad-server-analytics-reports-impressions', array( $this, 'adminPages' ));
        add_submenu_page( 'central-hubb-ad-server', 'Reports: Clicks', 'Reports: Clicks', 'manage_options', 'central-hubb-ad-server-analytics-reports-clicks', array( $this, 'adminPages' ));
        add_submenu_page( 'central-hubb-ad-server', 'Account Settings', 'Account Settings', 'manage_options', 'central-hubb-ad-server-my-account', array( $this, 'adminPages' ));
        add_submenu_page( 'central-hubb-ad-server', 'Wordpress Settings', 'Wordpress Settings', 'manage_options', 'central-hubb-ad-server-wp-settings', array( $this, 'adminPages' ));
    }

    /**
     * adminPages.
     */
    public function adminPages()
    {
        new CentralHubbMvc();
    }

    /**
     * enqueueJs.
     */
    public function enqueueJs()
    {
        wp_enqueue_script('jquery');
        wp_enqueue_script( 'centralhubb_js',
            _CENTRAL_HUBB_PLUGIN_PATH_HTML.'/sdk/sdk.min.js',
            array( 'jquery' ),
            '1.0',
            true);

        $data = array(
            'apiBaseUrl' => get_rest_url().'v1',
        );

        wp_localize_script( 'centralhubb_js', 'phpVars', $data );
    }

    /**
     * getShortCodeImagePlaylist.
     *
     * @param array $options
     * @param null $content
     * @return string
     */
    public function getShortCodeImagePlaylist( $options = [], $content = null )
    {
        $id = !empty($options['id']) ? $this->sanitizeAlphaNumeric($options['id']) : '';
        $width = !empty($options['width']) ? $this->sanitizeNumeric($options['width']) : '';
        $height = !empty($options['height']) ? $this->sanitizeNumeric($options['height']) : '';

        return '<div class="central-hubb-image-playlist" data-id="'.esc_attr($id).'" style="width:'.esc_attr($width).'px;height:'.esc_attr($height).'px;border:1px solid grey;z-index:-1;"></div>';
    }

    /**
     * getShortCodeVideo.
     *
     * @param array $options
     * @param null $content
     * @return string
     */
    public function getShortCodeVideo( $options = [], $content = null )
    {
        $id = !empty($options['id']) ? $this->sanitizeAlphaNumeric($options['id']) : '';
        $width = !empty($options['width']) ? $this->sanitizeNumeric($options['width']) : '';
        $height = !empty($options['height']) ? $this->sanitizeNumeric($options['height']) : '';
        $autoPlay = !empty($options['auto_play']) ? $this->sanitizeAlphaNumeric($options['auto_play']) : '';

        if($autoPlay) {
            $autoPlayString = 'allow="autoplay; encrypted-media"';
        } else {
            $autoPlayString = '';
        }

        return '<iframe width="'.esc_attr($width).'" height="'.esc_attr($height).'" src="https://www.youtube.com/embed/'.esc_attr($id).'" frameborder="0" '.$autoPlayString.' allowfullscreen></iframe>';
    }
}