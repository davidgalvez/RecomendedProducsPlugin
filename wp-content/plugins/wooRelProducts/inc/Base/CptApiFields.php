<?php
/**
 * @package wooRelProducts
 */
namespace wooRelProducts\Base;
use \WP_Query;
use \WC_Product_Variable;

if(! defined('ABSPATH')) exit();

class CptApiFields extends PluginController{
    
    public function register()
    {
        add_action('rest_api_init',  array($this, 'addFieldsToAPI') );
    }

    /**
     * Add Custom fields to API
     */
    public function addFieldsToAPI()
    {
        $this->registerRestField('title_list','getCptTitle');
        $this->registerRestField('related_Prods','getCptProducts');
        $this->registerRestField('related_Prods_List','getCptProductsList');
    }

    /**
     * Prepare argumets and call hook register_rest_field to register new fields to show in rest API
     * @param string $fieldName Name of the field to show in rest API
     * @param string $getCallback Name of the method used to obtain the value for the field
     * @param string $updateCallback Name of the method user to update the value of the field (Default NULL)
     * @param string $schema Name of the schema of the field (Default NULL)
     */
    public function registerRestField(string $fieldName, string $getCallback, string $updateCallback=NULL, string $schema=NULL)
    {
        $args=$this->setRestFieldArguments($getCallback,$updateCallback,$schema);
        
        register_rest_field($this->posttypeName, $fieldName, $args);
    }

    /**
     * Prepare the arguments for creating the new fields in the rest API
     * @param string $getCallback Name of the method used to obtain the value for the field
     * @param string $updateCallback Name of the method user to update the value of the field (Default NULL)
     * @param string $schema Name of the schema of the field (Default NULL)
     */
    public function setRestFieldArguments(string $getCallback, string $updateCallback=NULL, string $schema=NULL)
    {
        $getCallback    =($getCallback!=NULL)?array($this,$getCallback):NULL;
        $updateCallback =($updateCallback!=NULL)?array($this,$updateCallback):NULL;
        $schema         =($schema!=NULL)?array($this,$schema):NULL;
        return array(            
                'get_callback' => $getCallback,
                'update_callback' => $updateCallback,
                'schema' => $schema            
        );
    }

    /**
     * Get the Title of the list of related products
     */
    public function getCptTitle() {
        global $post;        
        return get_the_title($post);
    }

    /**
     * Get the information stored in the custom field of the ids of products selected for the list of related products.
     */
    public function getCptProducts() 
    {
        global $post;
        if(!function_exists('get_post_meta')) 
        {
            return;
        }
        if(get_post_meta( $post->ID,'relatedProds')) 
        {
            return get_post_meta($post->ID,'relatedProds',true);
        }
        return false;
    }

    /**
     * Get the detailed information of each product of the list selected as related product
     * @return array Returns an array with the following information of each product ("title", "price", ""thumbnail_url")
     */
    public function getCptProductsList()
    {
        global $post;
        global $woocommerce;
        $products=maybe_unserialize(get_post_meta($post->ID,'relatedProds',true) );
        
        $args = array(
            'post_type'=>'product',
            'post_status'=>'publish',
            'include'=>$products
            );
        $productList=get_posts($args);

        $productListAPI=array();

        foreach($productList as $product):  
            $wc_product=new WC_Product_Variable($product->ID);
            $urlAddTocart="?add-to-cart=".$product->ID;
            $productListAPI[]=array(
                "title" => $wc_product->get_title(),
                "price" => $wc_product->get_price(),
                "thubnail_url" =>get_the_post_thumbnail_url($product->ID),
                "currency" => get_woocommerce_currency_symbol(),
                "permalink" => $wc_product->get_permalink(),
                "url" => (count($wc_product->get_children())===0)?$urlAddTocart:$wc_product->get_permalink(),
                "urlText" => (count($wc_product->get_children())===0)?$wc_product->single_add_to_cart_text():$wc_product->add_to_cart_text()
            );
        endforeach;
        return $productListAPI;
    }    
    
}