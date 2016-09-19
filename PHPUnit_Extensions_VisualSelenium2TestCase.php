<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 18.09.16
 * Time: 06:20
 */

namespace visualSelenium;


use visualSelenium\builder\ImageBuilder;
use visualSelenium\factory\ImageBuilderFactory;

class PHPUnit_Extensions_VisualSelenium2TestCase extends \PHPUnit_Extensions_Selenium2TestCase {
    /**
     * @var ImageBuilder
     */
    private $imageBuilder;

    protected function setUp ($path = null) {
        parent::setUp();
        $this->imageBuilder = new ImageBuilder(new ImageBuilderFactory($this, $path));
    }

    public function byXPath ($value) {
        $element = parent::byXPath($value);

        return new PHPUnit_Extensions_VisualSelenium2TestCase_Element($element, $this->imageBuilder);
    }

    public function url ($url = null) {
        parent::url($url);
        $this->imageBuilder->createScreenshot('call the url '.$this->getBrowserUrl().$url.' with '.$this->getBrowser());
    }
}