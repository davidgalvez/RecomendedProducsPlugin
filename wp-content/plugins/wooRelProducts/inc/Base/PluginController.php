<?php
/**
 * @package wooRelProducts
 */
namespace wooRelProducts\Base;

if(! defined('ABSPATH')) exit();
class PluginController
{

    protected $plugin;   
    protected $pluginPath;
    protected $pluginUrl;
    protected $posttypeArgs;
    protected $posttypeName;
    protected $metaboxArgs;


    /**
     * Controls global vars for the plugin
     * @param string $plugin unique name of the plugin path.
     */
    public function __construct(string $plugin)
    {
        
        $this->plugin=$plugin;           
        $this->pluginPath=plugin_dir_path(dirname( __FILE__, 2 ) );
        $this->pluginUrl=plugin_dir_url( dirname( __FILE__, 2 ) );
        $this->posttypeArgs=WOORELPRODS_POSTTYPE_ARGS;
        $this->posttypeName=WOORELPRODS_POSTTYPE_NAME;
        $this->metaboxArgs=WOORELPRODS_METABOX_ARGS;
    }
    
}