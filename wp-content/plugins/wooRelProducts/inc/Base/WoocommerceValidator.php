<?php
/**
 * @package wooRelProducts
 */
namespace wooRelProducts\Base;

if(! defined('ABSPATH')) exit();
class WoocommerceValidator extends PluginController
{
    public function register()
    {
        add_action( 'admin_init', array($this,'validate_woocommerce') );
    }

    public function validate_woocommerce()
    {
        if(!$this->woocommerceExists())
        {
            add_action( 'admin_notices', array($this,'activateErrorMessage'));
            deactivate_plugins($this->plugin,true);
        }
    }


    /**
     * Validates if woocommerce plugin is activated
     */
    public function woocommerceExists()
    {
        return ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) );
    }

    /**
     * Error message in case woocommerce is not activated
     */
    public function activateErrorMessage()
    {
        $clase ='notice notice-error';
        $mensaje ='Error: You need to install woocommerce first';
    
        printf('<div class="%1s"><p>%2s</p></div>',esc_attr($clase), esc_html($mensaje) );
    
     }
}