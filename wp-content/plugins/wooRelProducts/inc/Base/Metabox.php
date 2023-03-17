<?php
/**
 * @package wooRelProducts
 */
namespace wooRelProducts\Base;
use \WP_Post;

if(! defined('ABSPATH')) exit();

class Metabox extends PluginController{
    
    /**
     * Unique Name of Metabox
     * 
     * @var string
     */
    private string $id;

    /**
     * Metabox Title
     */
    private string $tittle;    
    

    /**
     * Metabox template path used to show the metabox form
     */
    private string $template;

    /**
     * Nonce Id to validate forms
     */
    protected string $nonce;

    /**
     * screen where metabox will be shown
     */
    private ?string $screen='woorelprods';

    /**
     * context to show the metabox
     */
    private string $context;

    /**
     * Metabox priority
     */
    private string $priority;

    

    /**
     * Asigns values to metabox arguments
     *  @param array $args  Asociative array of arguments to create the metabox this array should have the following indexes:
     * ("id", "title","template_path", "nonce", "screen", "priority"); 
     */
    function setArguments($args)
    {
        $this->id=$args["id"];
        $this->tittle=$args["title"];
        $this->template=rtrim($args["template_path"], '/');  
        $this->nonce=$args["nonce"];      
        $this->screen=$args["screen"];
        $this->context=$args["context"];
        $this->priority=$args["priority"];
    }

    /**
     * Add Metabox actions to plugin using actions add_meta_boxes y save_post
     */
    public function register()
    {
        $this->setArguments($this->metaboxArgs);
        add_action( 'add_meta_boxes', array($this,'addToMetaboxList'));
        add_action( 'save_post', array($this,'saveMetabox'),10);

    }

    /**
     * Add Metabox to metabox list
     */
    function addToMetaboxList()
    {
        call_user_func_array('add_meta_box',$this->getArguments());
    }

    /**
     * Get all the necesary arguments to add the metabox to the plugin
     */
    function getArguments()
    {
        return array(
            $this->id,
            $this->tittle,
            $this->getCallback(),
            $this->screen,
            $this->context,
            $this->priority
        );
    }

    function getId()
    {
        return $this->id;

    }

    function getTittle()
    {
        return $this->tittle;
    }

    function getScreen()
    {
        return $this->screen;
    }
    
    function getContext()
    {
        return $this->context;
    }

    function getPriority()
    {
        return $this->priority;
    }

    function getTemplate()
    {
        return $this->template;
    }

    /**
     * Get the Callback  method to render metabox, it is used as argument when metabox is added to plugin
     */
    function getCallback()
    {
        return array($this,'renderTemplate');
    }

    /**
     * Render the html forms of metabox using the template
     */
    function renderTemplate(WP_Post $post){        
        wp_nonce_field(basename(__FILE__), $this->nonce);
        include $this->template;
    }

    /**
     * Validate if the securiry nonce is included in the metabox request
     */
    function validateNonceIsInRequest(){
        if(!isset($_POST[$this->nonce]) || !wp_verify_nonce( $_POST[$this->nonce],basename(__FILE__)))
        {
            return false;
        }
        return true;
    }

    /**
     * Validate if user is allowed to edit post
     */
    function validateUserIsAllowed(int $postId){
        if(!current_user_can('edit_post',$postId)){
            return false;
        }
        return true;
    }

    /**
     * Validate if Autosave is active to avoid save twice
     */
    function validateAutosave()
    {
        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
            return false;
        }
        return true;
    }

    

    /**
     * Saves the metabox information on the database.
     */
    function saveMetabox(int $postID)
    {

        if(!$this->validateNonceIsInRequest()||!$this->validateUserIsAllowed($postID)||!$this->validateAutosave())
        {
            return $postID;
        }

        $products='';
        $arrProducts=array();

        if(isset($_POST['relatedProds'])){
            $products = $_POST['relatedProds'];
            foreach($products as $product):
                $arrProducts[]=sanitize_text_field( $product );

            endforeach;
        }

        update_post_meta( $postID, 'relatedProds', maybe_serialize($arrProducts));

    }
}