<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 18.09.16
 * Time: 07:00
 */

namespace visualSelenium;


use PHPUnit_Extensions_Selenium2TestCase_Element;
use visualSelenium\builder\ImageBuilder;

class PHPUnit_Extensions_VisualSelenium2TestCase_Element {
    private $element;
    private $imageBuilder;

    public function __construct (\PHPUnit_Extensions_Selenium2TestCase_Element $element, ImageBuilder $imageBuilder) {
        $this->element = $element;
        $this->imageBuilder = $imageBuilder;
    }

    public function clear () {
        $this->element->clear();
    }

    public function click () {
        $text = $this->element->value();
        $this->element->click();
        $this->imageBuilder->createScreenshot('click at '.$text);
    }

    public function css ($propertyName) {
        return $this->element->css($propertyName);
    }

    public function displayed () {
        return $this->element->displayed();
    }

    public function enabled () {
        return $this->element->enabled();
    }

    public function equals (PHPUnit_Extensions_Selenium2TestCase_Element $another) {
        return $this->element->equals($another);
    }

    public function location () {
        return $this->element->location();
    }

    public function selected () {
        return $this->element->selected();
    }

    public function size () {
        return $this->element->size();
    }

    public function submit () {
        $this->element->submit();
    }

    public function text () {
        return $this->element->text();
    }
}