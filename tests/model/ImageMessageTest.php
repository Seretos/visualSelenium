<?php
use fileManager\Image;
use visualSelenium\model\ImageMessage;

/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 18.09.16
 * Time: 03:11
 */
class ImageMessageTest extends PHPUnit_Framework_TestCase {
    /**
     * @var Image|PHPUnit_Framework_MockObject_MockObject
     */
    private $mockImage;
    /**
     * @var ImageMessage
     */
    private $imageMessage;

    /**
     * @var ReflectionClass
     */
    private $reflection;

    protected function setUp () {
        parent::setUp();
        $this->mockImage = $this->getMockBuilder(Image::class)
                                ->disableOriginalConstructor()
                                ->getMock();
        $this->imageMessage = new ImageMessage($this->mockImage, 1, 2, 3);
        $this->reflection = new ReflectionClass(ImageMessage::class);
    }

    /**
     * @test
     */
    public function drawMessage () {
        $this->mockImage->expects($this->at(0))
                        ->method('getWidth')
                        ->will($this->returnValue(700));
        $this->mockImage->expects($this->at(1))
                        ->method('getCharacterWidth')
                        ->with(1)
                        ->will($this->returnValue(4));
        $this->mockImage->expects($this->at(2))
                        ->method('getCharacterHeight')
                        ->with(1)
                        ->will($this->returnValue(9));

        $this->mockImage->expects($this->at(3))
                        ->method('getHeight')
                        ->will($this->returnValue(800));
        $this->mockImage->expects($this->at(4))
                        ->method('getWidth')
                        ->will($this->returnValue(700));
        $this->mockImage->expects($this->at(5))
                        ->method('getHeight')
                        ->will($this->returnValue(800));
        $this->mockImage->expects($this->at(6))
                        ->method('getColor')
                        ->with(0, 0, 0, 50)
                        ->will($this->returnValue(14));

        $this->mockImage->expects($this->at(7))
                        ->method('createFilledRectangle')
                        ->with(2, 774, 698, 798, 14);

        $this->mockImage->expects($this->at(8))
                        ->method('getHeight')
                        ->will($this->returnValue(800));
        $this->mockImage->expects($this->at(9))
                        ->method('getCharacterHeight')
                        ->with(1)
                        ->will($this->returnValue(9));
        $this->mockImage->expects($this->at(10))
                        ->method('getColor')
                        ->with(255, 255, 255)
                        ->will($this->returnValue(16));
        $this->mockImage->expects($this->at(11))
                        ->method('getCharacterHeight')
                        ->with(1)
                        ->will($this->returnValue(9));

        $this->mockImage->expects($this->at(12))
                        ->method('createText')
                        ->with(1,
                               5,
                               777,
                               'test1 test2 test3 test4 test5 test6 test7 test8 test9 test10 test11 test12 test13 test14 test15 test16 test1 test2 test3 test4 test5 test6 test7 test8 test9 test10 test11 te',
                               16);
        $this->mockImage->expects($this->at(13))
                        ->method('createText')
                        ->with(1,
                               5,
                               786,
                               'st12 test13 test14 test15 test16',
                               16);

        $this->imageMessage->drawMessage('test1 test2 test3 test4 test5 test6 test7 test8 test9 test10 test11 test12 test13 test14 test15 test16 test1 test2 test3 test4 test5 test6 test7 test8 test9 test10 test11 test12 test13 test14 test15 test16');
    }

    /**
     * @test
     */
    public function drawLines () {
        $method = $this->reflection->getMethod('drawLines');
        $method->setAccessible(true);

        $linesProperty = $this->reflection->getProperty('lines');
        $linesProperty->setAccessible(true);
        $linesProperty->setValue($this->imageMessage, ['line1', 'line2', 'line3', 'line4']);

        $this->mockImage->expects($this->at(0))
                        ->method('getHeight')
                        ->will($this->returnValue(800));
        $this->mockImage->expects($this->at(1))
                        ->method('getCharacterHeight')
                        ->with(1)
                        ->will($this->returnValue(9));
        $this->mockImage->expects($this->at(2))
                        ->method('getColor')
                        ->with(255, 255, 255)
                        ->will($this->returnValue(6));
        $this->mockImage->expects($this->at(3))
                        ->method('getCharacterHeight')
                        ->with(1)
                        ->will($this->returnValue(9));

        $this->mockImage->expects($this->at(4))
                        ->method('createText')
                        ->with(1, 5, 759, 'line1', 6);
        $this->mockImage->expects($this->at(5))
                        ->method('createText')
                        ->with(1, 5, 768, 'line2', 6);
        $this->mockImage->expects($this->at(6))
                        ->method('createText')
                        ->with(1, 5, 777, 'line3', 6);
        $this->mockImage->expects($this->at(7))
                        ->method('createText')
                        ->with(1, 5, 786, 'line4', 6);

        $method->invokeArgs($this->imageMessage, []);
    }

    /**
     * @test
     */
    public function calculateLineCharacters () {
        $method = $this->reflection->getMethod('calculateLineCharacters');
        $method->setAccessible(true);

        $this->mockImage->expects($this->any())
                        ->method('getCharacterWidth')
                        ->with(1)
                        ->will($this->returnValue(4));
        $this->mockImage->expects($this->any())
                        ->method('getWidth')
                        ->will($this->returnValue(20));

        $this->assertSame(ceil(10 / 4), $method->invokeArgs($this->imageMessage, []));
    }

    /**
     * @test
     */
    public function calculateRectangleHeight () {
        $method = $this->reflection->getMethod('calculateRectangleHeight');
        $method->setAccessible(true);

        $linesProperty = $this->reflection->getProperty('lines');
        $linesProperty->setAccessible(true);
        $linesProperty->setValue($this->imageMessage, ['line1', 'line2', 'line3', 'line4']);

        $this->mockImage->expects($this->any())
                        ->method('getCharacterHeight')
                        ->with(1)
                        ->will($this->returnValue(4));

        $this->assertSame(22, $method->invokeArgs($this->imageMessage, []));
    }

    /**
     * @test
     */
    public function calculateMessageLines_withOneCharacter () {
        $method = $this->reflection->getMethod('calculateMessageLines');
        $method->setAccessible(true);

        $this->assertSame(['1'], $method->invokeArgs($this->imageMessage, ['1', 1]));
    }

    /**
     * @test
     */
    public function calculateMessageLines () {
        $method = $this->reflection->getMethod('calculateMessageLines');
        $method->setAccessible(true);

        $this->assertSame(['test1 test', '2 test3 te', 'st4 test5 ', 'test6 test', '7'],
                          $method->invokeArgs($this->imageMessage, ['test1 test2 test3 test4 test5 test6 test7', 10]));
    }

    /**
     * @test
     */
    public function calculateMessageLines_withOneLine () {
        $method = $this->reflection->getMethod('calculateMessageLines');
        $method->setAccessible(true);

        $this->assertSame(['1234567890'], $method->invokeArgs($this->imageMessage, ['1234567890', 10]));
    }

    /**
     * @test
     */
    public function calculateMessageLines_withTwoLines () {
        $method = $this->reflection->getMethod('calculateMessageLines');
        $method->setAccessible(true);

        $this->assertSame(['1234567890','1'], $method->invokeArgs($this->imageMessage, ['12345678901', 10]));
    }
}