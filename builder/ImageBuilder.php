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

        $image->save($this->factory->getPath().'/'.$this->createFileName($this->screenshotIndex,$message).'.png');
        $this->screenshotIndex++;
    }

    private function createFileName($index, $message){
        $filename = sprintf('%08d', $index);
        if($message != ''){
            $message = preg_replace('/[\/\/]/','_',$message);
            $message = preg_replace('/[^a-zA-Z0-9.:_\/ ]/', '', $message);
            $message = preg_replace('/[ .:\/]/','_',$message);
            $filename .= '_'.$message;
        }
        return $filename;
    }
}