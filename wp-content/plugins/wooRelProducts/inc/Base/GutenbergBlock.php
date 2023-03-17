<?php
/**
 * @package wooRelProducts
 */
namespace wooRelProducts\Base;

use \WC_Product_Variable;

if(! defined('ABSPATH')) exit();

class GutenbergBlock extends PluginController
{
    private array $blocks;

    public function register()
    {
        $this->setBlocks();
        add_action('init', array($this,'registerBlocks'));
    }

    public function registerBlocks()
    {
        //Validates if Gutenberg exists
        if(!function_exists('register_block_type'))
        {
            return;
        }

        // Loads dependencies and versions automatically
        $asset_file = include($this->pluginPath . 'build/index.asset.php');
        
        $this->registerStylesScripts();
        
        $this->registerBlockTypes();
        
    }

    public function registerStylesScripts()
    {
        // Register editor scripts
        wp_register_script
        (
            'woorelprods-editor-script', //nombre unico
            $this->pluginUrl.'build/index.js', //archivo con los bloques
            array('wp-blocks','wp-i18n','wp-element', 'wp-editor'), //dependencias
            filemtime($this->pluginPath .'build/index.js') //version
        );

        // Styles for editor
        wp_register_style
        (
            'woorelprods-editor-styles', //nombre
            $this->pluginUrl.'src/css/editor.css', // archivo de css para el editor
            array('wp-edit-blocks'), //dependencias
            filemtime($this->pluginPath .'src/css/editor.css')
        );

        // Styles for blocks (backend y frontend)
        wp_register_style
        (
            'woorelprods-frontend-styles', //nombre
            $this->pluginUrl.'src/css/styles.css', // archivo de css para el front y backend
            array(), //dependencias
            filemtime($this->pluginPath .'src/css/styles.css')
        ); 

    }

    /**
     * Set the list of blocks
     */
    public function setBlocks()
    {
        $this->blocks=array(
            [
                "id"    => 'woorelprods/relprods',
                "args"  => array(
                        'api_version' => 2,
                        'editor_script' => 'woorelprods-editor-script', //script principal para el editor
                        'editor_style' => 'woorelprods-editor-styles', //estilos para el editor
                        'style' => 'woorelprods-frontend-styles', // estilos  para el frontend
                        'render_callback' => array($this,'renderFrontEnd') //query a la base de datos
                    )

            ]            
        );
    }

    /**
     * Register the list of block types
     */
    function registerBlockTypes()
    {
        foreach($this->blocks as $block)
        {
            register_block_type($block["id"], $block["args"]);
        }        
    }

    /**
     * Render Block FrontEnd
     */
    function renderFrontEnd($atts)
    {
               
       //Definimos valores iniciales para las variables de los atributos
        $title=(isset($atts['titleBLock']))?$atts['titleBLock']:'Related Products';
        $listId=(isset($atts['selListId']))?$atts['selListId']:0;

        if($this->isEmptyList($listId))
        {
            return "No data to show";
        }        

        
        $products=maybe_unserialize(get_post_meta($listId,'relatedProds',true) );
        
        $args = array(
                'post_type'=>'product',
                'post_status'=>'publish',
                'include'=>$products
                );
        $relatedProducts=get_posts($args);

        if(count($relatedProducts)===0)
        {
            return "No products to show";
        }
        $body="<h3>$title</h3>";
        $body.='<div class="container">';
        $body.="<div class='items'>";
       
        foreach($relatedProducts as $product):        
          
             
            $currency=get_woocommerce_currency_symbol();  
            
            $wc_product=new WC_Product_Variable($product->ID);
            $titleprod=$wc_product->get_title();
            $precio=$wc_product->get_price();
            $imagen=get_the_post_thumbnail_url($product->ID);
            $urlAddTocart="?add-to-cart=".$product->ID;
            $permalink=$wc_product->get_permalink();
            $url=(count($wc_product->get_children())===0)?$urlAddTocart:$wc_product->get_permalink(); 
            $urlText=(count($wc_product->get_children())===0)?$wc_product->single_add_to_cart_text():$wc_product->add_to_cart_text();
           
            
            $body.="
                    <div class='entry'>
                        <p class='name'><a href='$permalink'>$titleprod</a></p>
                        <img src='$imagen'  href='$url'  />
                        <p class='quote'>$currency $precio</p>
                        <a class='link' href='$url'>$urlText</a>
                    </div>
                    ";
               
               
        endforeach;
        $body.="</div>";
        $body.="</div>";

        return $body;
    }

    public function isEmptyList($listId)
    {
        if(get_post_meta($listId,'relatedProds',true)===false) return true;
        if(get_post_meta($listId,'relatedProds',true)==='') return true;
        return false;
    }    

}