<?php
/**
 * @package wooRelProducts
 */
namespace wooRelProducts\Base;

class Deactivate{

    /**
     * Deactivate the plugin
     */
    public static function deactivate() 
    {       
        flush_rewrite_rules();
    }
}