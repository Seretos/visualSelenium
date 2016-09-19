<?php
use fileManager\model\Image;
use visualSelenium\builder\ImageBuilder;
use visualSelenium\factory\ImageBuilderFactory;
use visualSelenium\model\ImageMessage;

/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 18.09.16
 * Time: 05:36
 */
class ImageBuilderTest extends PHPUnit_Framework_TestCase {
    /**
     * @var ImageBuilder
     */
    private $builder;

    /**
     * @var ImageBuilderFactory|PHPUnit_Framework_MockObject_MockObject
     */
    private $mockFactory;

    /**
     * @var ReflectionClass
     */
    private $reflection;

    protected function setUp () {
        parent::setUp();
        $this->mockFactory = $this->getMockBuilder(ImageBuilderFactory::class)
                                  ->disableOriginalConstructor()
                                  ->getMock();

        $this->mockFactory->expects($this->at(0))
                          ->method('resetDirectory');
        $this->mockFactory->expects($this->at(1))
                          ->method('createDirectory');

        $this->builder = new ImageBuilder($this->mockFactory);

        $this->reflection = new ReflectionClass(ImageBuilder::class);
    }

    /**
     * @test
     */
    public function createScreenshot_withMessage () {
        $indexProperty = $this->reflection->getProperty('screenshotIndex');
        $indexProperty->setAccessible(true);
        $indexProperty->setValue($this->builder, 4);

        $this->createScreenshotMock('test');

        $this->builder->createScreenshot('test');

        $this->assertSame(5, $indexProperty->getValue($this->builder));
    }

    /**
     * @test
     */
    public function createScreenshot () {
        $indexProperty = $this->reflection->getProperty('screenshotIndex');
        $indexProperty->setAccessible(true);
        $indexProperty->setValue($this->builder, 4);

        $this->createScreenshotMock();

        $this->builder->createScreenshot();

        $this->assertSame(5, $indexProperty->getValue($this->builder));
    }

    private function createScreenshotMock ($message = '') {
        $mockTest = $this->getMockBuilder(PHPUnit_Extensions_Selenium2TestCase::class)
                         ->disableOriginalConstructor()
                         ->setMethods(['currentScreenshot', 'screenshot'])
                         ->getMock();
        $mockImage = $this->getMockBuilder(Image::class)
                          ->disableOriginalConstructor()
                          ->getMock();

        $mockTest->expects($this->once())
                 ->method('screenshot');
        $mockTest->expects($this->once())
                 ->method('currentScreenshot')
                 ->will($this->returnValue('current_screenshot'));

        $this->mockFactory->expects($this->any())
                          ->method('getTest')
                          ->will($this->returnValue($mockTest));

        $this->mockFactory->expects($this->once())
                          ->method('createImage')
                          ->will($this->returnValue($mockImage));

        $this->mockFactory->expects($this->once())
                          ->method('getPath')
                          ->will($this->returnValue('pathDirectory'));

        $mockImage->expects($this->once())
                  ->method('loadFromString')
                  ->with('current_screenshot');

        if ($message != '') {
            $mockImageMessage = $this->getMockBuilder(ImageMessage::class)
                                     ->disableOriginalConstructor()
                                     ->getMock();

            $this->mockFactory->expects($this->once())
                              ->method('createImageMessage')
                              ->with($mockImage)
                              ->will($this->returnValue($mockImageMessage));

            $mockImageMessage->expects($this->once())
                             ->method('drawMessage')
                             ->with($message);
        }

        $filename = '00000004';
        if ($message != '') {
            $filename .= '_'.preg_replace('/[^a-zA-Z0-9\-\._]/', '_', $message);
        }
        $mockImage->expects($this->once())
                  ->method('save')
                  ->with('pathDirectory/'.$filename.'.png');
    }
}