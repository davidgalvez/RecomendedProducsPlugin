<?php
/**
 * @package wooRelProducts
 */
namespace wooRelProducts\Base;

if(! defined('ABSPATH')) exit();

class EnqueueScripts extends PluginController
{
    private array $adminScripts;
    private array $frontEndScripts; 
    private array $adminStyles;
    private array $frontEndStyles;

     /**
     * Enqueue js scripts and css scripts to front and backend plugin interfaces
     */
    public function register()
    {
        $this->setFrontEndScriptsStyles();
        $this->setAdminScriptsStyles();
        add_action('wp_enqueue_scripts', array($this,'addFrontJsCssFiles'));
        add_action('admin_enqueue_scripts', array($this,'addAdminJsCssFiles'));
    }

    /**
     * Add styles and scripts to front end
     */
    public function addFrontJsCssFiles()
    {        
        $this->enqueueStyles($this->frontEndStyles);
        $this->enqueueScripts($this->frontEndScripts);  
    }

    /**
     * Add styles and scripts to admin
     */
    public function addAdminJsCssFiles(string $hook)
    {
        global $post;       

        if($this->isValidHook($hook) and $this->isValidPosttype())
        {
            
            $this->enqueueStyles($this->adminStyles);
            $this->enqueueScripts($this->adminScripts);  
        }
    }

    public function enqueueScripts($scripts)
    {
        foreach($scripts as $script)
            {
                wp_enqueue_script($script["handle"],$script["url"],$script["deps"], $script["ver"],$script["footer"]);
            }  
    }

    public function enqueueStyles($styles)
    {
        foreach($styles as $style)
            {
                wp_enqueue_style($style["handle"],$style["url"]);
            }  
    }

    /**
     * Validates if hook which calls the function is a post or post-new
     */
    function isValidHook(string $hook)
    {
        return ($hook == 'post-new.php' || $hook == 'post.php');
    }


    /**
     * Validates if the posttype corresponds to plugin postType 
     */
    function isValidPosttype()
    {
        global $post;       
        return ($post->post_type===$this->posttypeName);
    }

    /**
     * Gets the postType Name
     */
    function getPostTypeName()
    {
        return $this->posttypeName;
    }

    /**
     * Sets the admin scripts and styles to enqueue
     */
    public function setAdminScriptsStyles()
    {
        $this->adminStyles=array(
            array(
                "handle"=>"chosen_css",
                "url"=> $this->pluginUrl.'/assets/css/chosen.min.css'
            )
        );
        $this->adminScripts = array(
            array(
                "handle"=>"chosen_js",
                "url"=>$this->pluginUrl.'/assets/js/chosen.jquery.min.js',
                "deps"=>array("jquery"),
                "ver"=>1.0,
                "footer"=>true
            ),
            array(
                "handle"=>"woorelprods_mb_js",
                "url"=>$this->pluginUrl.'/assets/js/woorelprods-metabox.js',
                "deps"=>array("jquery"),
                "ver"=>1.0,
                "footer"=>true
            )
        );
    }

    /**
     * Sets the frontEnd scripts and styles to enqueue
     */
    public function setFrontEndScriptsStyles()
    {
        $this->frontEndStyles=array();
        $this->frontEndScripts = array();
    }

    /**
     * Gets the list of admin scripts to enqueue
     */
    function getAdminScripts()
    {
        return $this->adminScripts;
    }

    /**
     * Gets the list of admin styles to enqueue
     */
    function getAdminStyles()
    {
        return $this->adminStyles;
    }

    /**
     * Gets the list of fronEnd scripts to enqueue
     */
    function getFrontEndScripts()
    {
        return $this->frontEndScripts;
    }
    
    /**
     * Get the list of frontEnd styles to enqueue
     */
    function getFrontEndStyles()
    {
        return $this->frontEndStyles;
    }
}