<?php
/**
 * @package wooRelProducts
 */
namespace wooRelProducts;

if(! defined('ABSPATH')) exit();

final class Init{
    
    /**
     * Stores clases in an array
     * @return array array of stored clases
     */
    public static function get_services()
    {
        return [      
            Base\WoocommerceValidator::class,      
            Base\PostType::class,
            Base\EnqueueScripts::class,
            Base\Metabox::class,
            Base\CptApiFields::class,
            Base\GutenbergBlock::class           
        ];
    }

    /**
     * Instantiate avery stored class and call the register method
     * @param string $plugin Unique route of the plugin, will serve as the plugin Id should be passed plugin_basename(__FILE__) in the root plugin file
     */
    public static function register_services(string $plugin)
    {
        foreach(self::get_services() as $clase)
        {
            $servicio=self::instanciate_clase($clase,$plugin);
            if(method_exists($servicio,'register'))
            {
                $servicio->register();
            }
        }
    }

    /**
     * Create a new instance of the class that receives as parameter
     * @param class $clase  class to instanciate
     * @param string $plugin unique route of the plugin 
     * @return object Returns an instance of the class.
     */
    private static function instanciate_clase($clase,$plugin)
    {
        $servicio = new $clase($plugin);
        return $servicio;
    }
}