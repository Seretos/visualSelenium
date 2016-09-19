<?php
namespace visualSelenium\model;

use PHPUnit_Framework_TestCase;

function imagecreatefrompng ($argument) {
    ImageTest::$functions['imagecreatefrompng'][] = $argument;

    return 'imagecreatefrompng';
}

function imagecreatefromstring ($argument) {
    ImageTest::$functions['imagecreatefromstring'][] = $argument;

    return 'imagecreatefromstring';
}

function imagepng ($argument1, $argument2) {
    ImageTest::$functions['imagepng'][] = [$argument1, $argument2];
}

function imagesx ($argument) {
    ImageTest::$functions['imagesx'][] = $argument;

    return 'imagesx';
}

function imagesy ($argument) {
    ImageTest::$functions['imagesy'][] = $argument;

    return 'imagesy';
}

function imagefontwidth ($argument) {
    ImageTest::$functions['imagefontwidth'][] = $argument;

    return 'imagefontwidth';
}

function imagefontheight ($argument) {
    ImageTest::$functions['imagefontheight'][] = $argument;

    return 'imagefontheight';
}

function imagecolorallocatealpha ($image, $red, $green, $blue, $alpha) {
    ImageTest::$functions['imagecolorallocatealpha'][] = [$image, $red, $green, $blue, $alpha];

    return 'imagecolorallocatealpha';
}

function imagefilledrectangle ($image, $x1, $y1, $x2, $y2, $color) {
    ImageTest::$functions['imagefilledrectangle'][] = [$image, $x1, $y1, $x2, $y2, $color];
}

function imagestring ($image, $font, $x, $y, $string, $color) {
    ImageTest::$functions['imagestring'][] = [$image, $font, $x, $y, $string, $color];
}

/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 18.09.16
 * Time: 02:16
 */
class ImageTest extends PHPUnit_Framework_TestCase {
    /**
     * @var Image
     */
    private $image;

    public static $functions;

    protected function setUp () {
        parent::setUp();
        self::$functions = [];
        $this->image = new Image('my image resource');
    }

    /**
     * @test
     */
    public function loadFromFile () {
        $this->image->loadFromFile('file path');
        $this->assertSame(['imagecreatefrompng' => ['file path']], self::$functions);
        $this->assertSame('imagecreatefrompng', $this->image->getResource());
    }

    /**
     * @test
     */
    public function loadFromString () {
        $this->image->loadFromString('file content');
        $this->assertSame(['imagecreatefromstring' => ['file content']], self::$functions);
        $this->assertSame('imagecreatefromstring', $this->image->getResource());
    }

    /**
     * @test
     */
    public function save () {
        $this->image->save('file path');
        $this->assertSame(['imagepng' => [['my image resource', 'file path']]], self::$functions);
    }

    /**
     * @test
     */
    public function getWidth () {
        $this->assertSame('imagesx', $this->image->getWidth());
        $this->assertSame(['imagesx' => ['my image resource']], self::$functions);
    }

    /**
     * @test
     */
    public function getHeight () {
        $this->assertSame('imagesy', $this->image->getHeight());
        $this->assertSame(['imagesy' => ['my image resource']], self::$functions);
    }

    /**
     * @test
     */
    public function getCharacterWidth () {
        $this->assertSame('imagefontwidth', $this->image->getCharacterWidth(2));
        $this->assertSame(['imagefontwidth' => [2]], self::$functions);
    }

    /**
     * @test
     */
    public function getCharacterHeight () {
        $this->assertSame('imagefontheight', $this->image->getCharacterHeight(3));
        $this->assertSame(['imagefontheight' => [3]], self::$functions);
    }

    /**
     * @test
     */
    public function getColor () {
        $this->assertSame('imagecolorallocatealpha', $this->image->getColor(1, 2, 3, 4));
        $this->assertSame(['imagecolorallocatealpha' => [['my image resource', 1, 2, 3, 4]]], self::$functions);
    }

    /**
     * @test
     */
    public function createFilledRectangle () {
        $this->image->createFilledRectangle(1, 2, 3, 4, 5);
        $this->assertSame(['imagefilledrectangle' => [['my image resource', 1, 2, 3, 4, 5]]], self::$functions);
    }

    /**
     * @test
     */
    public function createText () {
        $this->image->createText(1, 2, 3, 'test', 4);
        $this->assertSame(['imagestring' => [['my image resource', 1, 2, 3, 'test', 4]]], self::$functions);
    }
}