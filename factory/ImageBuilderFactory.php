<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 18.09.16
 * Time: 00:00
 */

namespace visualSelenium\factory;


use visualSelenium\model\Image;
use visualSelenium\model\ImageMessage;

class ImageBuilderFactory {
    private $test;
    private $directory;

    public function __construct (\PHPUnit_Extensions_Selenium2TestCase $test, $directory) {
        $this->test = $test;
        $this->directory = $directory;
    }

    public function getPath () {
        return $this->directory.get_class($this->test).'/'.$this->test->getName().'/'.$this->test->getBrowser().'/';
    }

    public function getTest () {
        return $this->test;
    }

    public function resetDirectory () {
        if (file_exists($this->getPath())) {
            array_map('unlink', glob($this->getPath()."*.*"));
        }
    }

    public function createDirectory () {
        if (!file_exists($this->getPath())) {
            mkdir($this->getPath(), 0755, true);
        }
    }

    public function createImage () {
        $image = new Image();

        return $image;
    }

    public function createImageMessage (Image $image) {
        $imageMessage = new ImageMessage($image);

        return $imageMessage;
    }
}