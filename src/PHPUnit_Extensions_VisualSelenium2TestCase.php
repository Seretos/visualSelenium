<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 18.09.16
 * Time: 06:20
 */
namespace visualSelenium;

use fileManager\FileManager;
use visualSelenium\builder\ImageBuilder;
use visualSelenium\factory\ImageBuilderFactory;

class PHPUnit_Extensions_VisualSelenium2TestCase extends \PHPUnit_Extensions_Selenium2TestCase {
    /**
     * @var ImageBuilder
     */
    private $imageBuilder;

    protected function setUpScreenshotPath ($path = null) {
        $this->imageBuilder = null;
        if ($path != null) {
            $this->imageBuilder = new ImageBuilder(new ImageBuilderFactory($this, $path, new FileManager()));
        }
    }

    public function createScreenshot ($message = '') {
        if ($this->imageBuilder instanceof ImageBuilder) {
            $this->imageBuilder->createScreenshot($message);
        }
    }
}
