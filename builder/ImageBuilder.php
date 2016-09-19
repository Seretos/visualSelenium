<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 17.09.16
 * Time: 22:37
 */

namespace visualSelenium\builder;


use visualSelenium\factory\ImageBuilderFactory;

class ImageBuilder {
    private $factory;
    private $screenshotIndex;

    public function __construct (ImageBuilderFactory $factory) {
        $this->factory = $factory;
        $this->screenshotIndex = 0;
        $factory->resetDirectory();
        $factory->createDirectory();
    }

    public function createScreenshot ($message = '') {
        $this->factory->getTest()
                      ->screenshot();
        $imageStr = $this->factory->getTest()
                                  ->currentScreenshot();

        $image = $this->factory->createImage();
        $image->loadFromString($imageStr);

        if ($message != '') {
            $imageMessage = $this->factory->createImageMessage($image);
            $imageMessage->drawMessage($message);
        }

        $image->save($this->factory->getPath().'/'.sprintf('%08d', $this->screenshotIndex).'.png');
        $this->screenshotIndex++;
    }
}