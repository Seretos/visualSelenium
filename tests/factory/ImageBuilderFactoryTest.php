<?php

use fileManager\FileManager;
use fileManager\Image;
use visualSelenium\factory\ImageBuilderFactory;
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
    /**
     * @var FileManager|PHPUnit_Framework_MockObject_MockObject
     */
    private $mockFileManager;

    protected function setUp () {
        parent::setUp();

        $this->mockTest = $this->getMockBuilder(PHPUnit_Extensions_Selenium2TestCase::class)
                               ->disableOriginalConstructor()
                               ->getMock();
        $this->mockFileManager = $this->getMockBuilder(FileManager::class)
                                      ->disableOriginalConstructor()
                                      ->getMock();

        $this->factory = new ImageBuilderFactory($this->mockTest, 'directory', $this->mockFileManager);

        $this->assertSame($this->mockTest, $this->factory->getTest());
    }

    /**
     * @test
     */
    public function getPath () {
        $this->mockTest->expects($this->once())
                       ->method('toString')
                       ->will($this->returnValue('mockTestClass::mockTestName'));
        $this->mockTest->expects($this->once())
                       ->method('getBrowser')
                       ->will($this->returnValue('mockTestBrowser'));

        $this->assertSame('directorymockTestClass::mockTestName/mockTestBrowser/', $this->factory->getPath());
    }

    /**
     * @test
     */
    public function resetDirectory_withoutDirectory () {
        $this->mockTest->expects($this->once())
                       ->method('toString')
                       ->will($this->returnValue('mockTestClass::mockTestName'));
        $this->mockTest->expects($this->once())
                       ->method('getBrowser')
                       ->will($this->returnValue('mockTestBrowser'));

        $this->mockFileManager->expects($this->any())
                              ->method('fileExists')
                              ->with('directorymockTestClass::mockTestName/mockTestBrowser/')
                              ->will($this->returnValue(false));

        $this->mockFileManager->expects($this->never())
                              ->method('clearDirectory')
                              ->with('directorymockTestClass::mockTestName/mockTestBrowser/');

        $this->factory->resetDirectory();
    }

    /**
     * @test
     */
    public function resetDirectory () {
        $this->mockTest->expects($this->any())
                       ->method('toString')
                       ->will($this->returnValue('mockTestClass::mockTestName'));
        $this->mockTest->expects($this->any())
                       ->method('getBrowser')
                       ->will($this->returnValue('mockTestBrowser'));

        $this->mockFileManager->expects($this->any())
                              ->method('fileExists')
                              ->with('directorymockTestClass::mockTestName/mockTestBrowser/')
                              ->will($this->returnValue(true));

        $this->mockFileManager->expects($this->once())
                              ->method('clearDirectory')
                              ->with('directorymockTestClass::mockTestName/mockTestBrowser/');

        $this->factory->resetDirectory();
    }

    /**
     * @test
     */
    public function createDirectory_directoryExists () {
        $this->mockTest->expects($this->any())
                       ->method('toString')
                       ->will($this->returnValue('mockTestClass::mockTestName'));
        $this->mockTest->expects($this->any())
                       ->method('getBrowser')
                       ->will($this->returnValue('mockTestBrowser'));

        $this->mockFileManager->expects($this->any())
                              ->method('fileExists')
                              ->with('directorymockTestClass::mockTestName/mockTestBrowser/')
                              ->will($this->returnValue(true));

        $this->factory->createDirectory();
    }

    /**
     * @test
     */
    public function createDirectory () {
        $this->mockTest->expects($this->any())
                       ->method('toString')
                       ->will($this->returnValue('mockTestClass::mockTestName'));
        $this->mockTest->expects($this->any())
                       ->method('getBrowser')
                       ->will($this->returnValue('mockTestBrowser'));

        $this->mockFileManager->expects($this->any())
                              ->method('fileExists')
                              ->with('directorymockTestClass::mockTestName/mockTestBrowser/')
                              ->will($this->returnValue(false));

        $this->mockFileManager->expects($this->once())
                              ->method('createDirectory')
                              ->with('directorymockTestClass::mockTestName/mockTestBrowser/', 0755, true);

        $this->factory->createDirectory();
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