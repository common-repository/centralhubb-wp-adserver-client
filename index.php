<?php
/*
Plugin Name: Centralhubb - WP Adserver Client
Plugin URI: https://github.com/central-hubb/central-hubb-adserver
Description: This is a advert management system which can be used to provide placement of banners, to track banner impressions and clicks and to display analytics charts. This is the ultimate solution in banner management, tracking, clicks, impressions, graphs, charts, all in one simple admin interface.
Author: www.centralhubb.com
Version: 1.0
Author URI: http://www.centralhubb.com
*/

namespace CentralHubb;

require_once 'config/settings.php';
require_once 'classes/attributes.php';
require_once 'classes/base.php';
require_once 'classes/plugin.php';
require_once 'classes/api.php';
require_once 'classes/settings.php';
require_once 'classes/mvc.php';

add_action('init','CentralHubb\centralHubbInit');

function centralHubbInit()
{
    // public
    new CentralHubbApi();

    // admin only
    if(current_user_can('administrator')) {
        new CentralHubbPlugin();
    }

    // admin only
    if(current_user_can('administrator')) {
        new CentralHubbSettings();
    }
}