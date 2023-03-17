<?php
/**
 * Class TestPostType
 *
 * @package WooRelProducts
 */
use wooRelProducts\Base\PostType;
/**
 * Test PostType class.
 */
class TestPostType extends WP_UnitTestCase {

    public function setUp():void
    {
		parent::setUp();        
		$this->PostType= new PostType(WOORELPRODS_PLUGIN);
       
    }

	/**
	 * Test if postTypeName was set correctly.
	 */
	public function test_posttypeNameCreated() {
		
		$this->assertTrue( class_exists('wooRelProducts\\Init') );

       
        $this->PostType->register();
		
        $this->assertEquals($this->PostType->getName(),WOORELPRODS_POSTTYPE_NAME);
        $this->assertTrue($this->PostType->argumentsExists());        

	}
}