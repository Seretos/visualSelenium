<?php
use visualSelenium\factory\ImageBuilderFactory;
use visualSelenium\model\Image;
use visualSelenium\model\ImageMessage;

/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 18.09.16
 * Time: 04:59
 */
class ImageBuilderFactoryTest extends PHPUnit_Framework_TestCase {
    /**
     * @var ImageBuilderFactory
     */
    private $factory;

    /**
     * @var PHPUnit_Extensions_Selenium2TestCase|PHPUnit_Framework_MockObject_MockObject
     */
    private $mockTest;

    protected function setUp () {
        parent::setUp();

        $this->mockTest = $this->getMockBuilder(PHPUnit_Extensions_Selenium2TestCase::class)
                               ->disableOriginalConstructor()
                               ->getMock();

        $this->factory = new ImageBuilderFactory($this->mockTest, 'directory');
    }

    /**
     * @test
     */
    public function createImage () {
        $this->assertInstanceOf(Image::class, $this->factory->createImage());
    }

    /**
     * @test
     */
    public function createImageMessage () {
        /**
         * @var $mockImage Image|PHPUnit_Framework_MockObject_MockObject
         */
        $mockImage = $this->getMockBuilder(Image::class)
                          ->disableOriginalConstructor()
                          ->getMock();

        $reflection = new ReflectionClass(ImageMessage::class);
        $imageProperty = $reflection->getProperty('image');
        $imageProperty->setAccessible(true);

        $imageMessage = $this->factory->createImageMessage($mockImage);

        $this->assertInstanceOf(ImageMessage::class, $imageMessage);
        $this->assertSame($mockImage, $imageProperty->getValue($imageMessage));
    }
}