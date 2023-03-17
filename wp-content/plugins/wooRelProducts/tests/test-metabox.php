<?php
/**
 * Class TestMetabox
 *
 * @package WooRelProducts
 */

use wooRelProducts\Base\Metabox;

/**
 * Test Metabox Class
 */
class TestMetabox extends WP_UnitTestCase 
{
    public function setUp():void
    {
		parent::setUp();        
		$this->Metabox= new Metabox(WOORELPRODS_PLUGIN); 
        $this->Metabox->setArguments(WOORELPRODS_METABOX_ARGS);      
    }

    /**
     * Test if Metabox arguments are set correctly
     */
    public function testSetArgs()
    {
        $this->assertEquals( $this->Metabox->getId(), WOORELPRODS_METABOX_ARGS["id"], 'Metabox Ids doesnt match' );
        $this->assertEquals( $this->Metabox->getTittle(), WOORELPRODS_METABOX_ARGS["title"], 'Metabox Tittles doesnt match' );
        $this->assertEquals( $this->Metabox->getTemplate(), WOORELPRODS_METABOX_ARGS["template_path"], 'Metabox Template Path doesnt match' );
    }

    public function testMetaboxTemplatePathExists()
    {
        $this->assertFileExists($this->Metabox->getTemplate(),'Metabox Template file doesnt exist');

    }

}