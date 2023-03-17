<?php
/**
 * @package wooRelProducts
 */
namespace wooRelProducts\Base;

if(! defined('ABSPATH')) exit();

class PostType extends PluginController{
    
   
    /**
     * Adds the PostType to Plugin
     */
    public function register()    
    {
        add_action('init', array($this, 'registerPostype'));
    }

    /**
     * Get the arguments of the postType
     */
    public function getArguments()
    {
        return $this->posttypeArgs;
    }
    
    /**
     * Get the unique name of Posttype
     */
    public function getName()
    {
        return $this->posttypeName;
    } 

    /**
     * Register the posttype with arguments
     */
    public function registerPostype()
    {        
        if(!$this->isRegisteredPostType())
        {
           register_post_type( $this->getName(), $this->getArguments() );
                  
        }        
    }    

    /**
     * Verify if posttype is registered
     */
    public function isRegisteredPostType()
    {
        return post_type_exists( $this->posttypeName );
    }

    /**
     * Verify if arguments are defined for the postType
     */
    public function argumentsExists()
    {
        return ($this->posttypeArgs!=NULL);
    }
   

    

}