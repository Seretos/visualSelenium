<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 18.09.16
 * Time: 00:20
 */

namespace visualSelenium\model;


class Image {
    private $image;

    public function __construct ($image = null) {
        $this->image = $image;
    }

    public function getResource () {
        return $this->image;
    }

    public function loadFromFile ($file) {
        $this->image = imagecreatefrompng($file);
    }

    public function loadFromString ($content) {
        $this->image = imagecreatefromstring($content);
    }

    public function save ($file) {
        imagepng($this->image, $file);
    }

    public function getWidth () {
        return imagesx($this->image);
    }

    public function getHeight () {
        return imagesy($this->image);
    }

    public function getCharacterWidth ($font) {
        return imagefontwidth($font);
    }

    public function getCharacterHeight ($font) {
        return imagefontheight($font);
    }

    public function getColor ($red, $green, $blue, $alpha = 0) {
        return imagecolorallocatealpha($this->image,
                                       $red,
                                       $green,
                                       $blue,
                                       $alpha);
    }

    public function createFilledRectangle ($x1, $y1, $x2, $y2, $color) {
        imagefilledrectangle($this->image, $x1, $y1, $x2, $y2, $color);
    }

    public function createText ($font, $x, $y, $string, $color) {
        imagestring($this->image, $font, $x, $y, $string, $color);
    }
}