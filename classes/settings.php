<?php

namespace CentralHubb;

/**
 * Class CentralHubbSettings
 *
 * @package CentralHubb
 */
class CentralHubbSettings extends CentralhubbBase
{
    /** @var $options array  */
    private $options = [];

    /**
     * CentralHubbSettingsPage constructor.
     */
    public function __construct()
    {
        parent::__construct();

        add_action( 'admin_menu', array( $this, 'adminMenu' ) );
        add_action( 'admin_init', array( $this, 'pageInit' ) );
    }

    /**
     * adminMenu
     */
    public function adminMenu()
    {
        add_options_page(
            'CentralHubb Settings',
            'CentralHubb Settings',
            'manage_options',
            'central-hubb-settings',
            array( $this, 'createAdminPage' )
        );
    }

    /**
     * createAdminPage
     */
    public function createAdminPage()
    {
        if(!empty($_POST)) {
            if ( !($this->getNonce()) || ! wp_verify_nonce($this->getNonce(), 'central-hubb-update-settings' )) {
                print 'Sorry, your nonce did not verify.';
                exit;
            }
        }

        if(!empty($this->data['central_hubb_settings'])) {
            foreach($this->data['central_hubb_settings'] as $key => $value) {
                $this->data['central_hubb_settings'][$key] = $this->sanitizeAlphaNumeric($value);
                update_option('central_hubb_settings', $this->data['central_hubb_settings']);
            }
        }

        $this->options = get_option('central_hubb_settings');

        ?>
        <div class="wrap">
            <h1>Centralhubb Settings</h1>
            <form method="post" action="<?php echo admin_url('options-general.php?page=central-hubb-settings'); ?>">
                <?php wp_nonce_field( 'central-hubb-update-settings', 'ch_nonce' ); ?>
                <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' );
                do_settings_sections( 'central-hubb-settings' );
                submit_button();
                ?>
            </form>
        </div>
        <?php


    }

    /**
     * page_init
     */
    public function pageInit()
    {
        add_settings_section(
            'central_hubb_settings',
            '',
            array( $this, 'printSectionInfo' ),
            'central-hubb-settings'
        );

        add_settings_field(
            'client_id',
            'Client ID',
            array( $this, 'clientIdCallback' ),
            'central-hubb-settings',
            'central_hubb_settings'
        );

        add_settings_field(
            'client_secret',
            'Client Secret',
            array( $this, 'clientSecretCallback' ),
            'central-hubb-settings',
            'central_hubb_settings'
        );

        add_settings_field(
            'access_token',
            'Access Token',
            array( $this, 'accessTokenCallback' ),
            'central-hubb-settings',
            'central_hubb_settings'
        );
    }

    /**
     * printSectionInfo
     */
    public function printSectionInfo()
    {
        print 'Enter your settings below:';
    }

    /**
     * clientIdCallback
     */
    public function clientIdCallback()
    {
        printf(
            '<input type="text" id="client_id" name="central_hubb_settings[client_id]" value="%s" style="width:300px;" />',
            isset( $this->options['client_id'] ) ? esc_attr( $this->options['client_id']) : ''
        );
    }

    /**
     * clientSecretCallback
     */
    public function clientSecretCallback()
    {
        printf(
            '<input type="text" id="client_secret" name="central_hubb_settings[client_secret]" value="%s" style="width:300px;" />',
            isset( $this->options['client_secret'] ) ? esc_attr( $this->options['client_secret']) : ''
        );
    }

    /**
     * accessTokenCallback
     */
    public function accessTokenCallback()
    {
        printf(
            '<input type="text" id="access_token" name="central_hubb_settings[access_token]" value="%s" style="width:300px;" />',
            isset( $this->options['access_token'] ) ? esc_attr( $this->options['access_token']) : ''
        );
    }
}

