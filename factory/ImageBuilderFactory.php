<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 18.09.16
 * Time: 00:00
 */

namespace visualSelenium\factory;


use fileManager\FileManager;
use fileManager\Image;
use visualSelenium\model\ImageMessage;

class ImageBuilderFactory {
    private $test;
    private $directory;
    private $fileManager;

    public function __construct (\PHPUnit_Extensions_Selenium2TestCase $test, $directory, FileManager $manager) {
        $this->test = $test;
        $this->directory = $directory;
        $this->fileManager = $manager;
    }

    public function createImage () {
        $image = new Image();

        return $image;
    }

    public function createImageMessage (Image $image) {
        $imageMessage = new ImageMessage($image);

        return $imageMessage;
    }

    public function getPath () {
        return $this->directory.$this->fileManager->getClassName($this->test).'/'.$this->test->getName().'/'.
               $this->test->getBrowser().'/';
    }

    public function getTest () {
        return $this->test;
    }

    public function resetDirectory () {
        if ($this->fileManager->fileExists($this->getPath())) {
            $this->fileManager->clearDirectory($this->getPath());
        }
    }

    public function createDirectory () {
        if (!$this->fileManager->fileExists($this->getPath())) {
            $this->fileManager->createDirectory($this->getPath(), 0755, true);
        }
    }
}