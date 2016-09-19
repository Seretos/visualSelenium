<?php
/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 18.09.16
 * Time: 01:22
 */

namespace visualSelenium\model;


use fileManager\model\Image;

class ImageMessage {
    private $image;
    private $font;
    private $margin;
    private $padding;
    private $lines;

    public function __construct (Image $image, $font = 2, $margin = 20, $padding = 20) {
        $this->image = $image;
        $this->font = $font;
        $this->margin = $margin;
        $this->padding = $padding;
        $this->lines = [];
    }

    public function drawMessage ($message) {
        $lineLength = $this->calculateLineCharacters();
        $this->lines = $this->calculateMessageLines($message, $lineLength);
        $height = $this->calculateRectangleHeight();

        $this->image->createFilledRectangle($this->margin,
                                            $this->image->getHeight() - $height - $this->margin,
                                            $this->image->getWidth() - $this->margin,
                                            $this->image->getHeight() - $this->margin,
                                            $this->image->getColor(0, 0, 0, 50));
        $this->drawLines();
    }

    private function drawLines () {
        $posY = $this->image->getHeight() - $this->calculateRectangleHeight() - $this->margin + $this->padding;
        $fontColor = $this->image->getColor(255, 255, 255);
        $fontHeight = $this->image->getCharacterHeight($this->font);
        foreach ($this->lines as $line) {
            $this->image->createText($this->font,
                                     $this->margin + $this->padding,
                                     $posY,
                                     $line,
                                     $fontColor);

            $posY += $fontHeight;
        }
    }

    private function calculateMessageLines ($message, $lineLength) {
        $lineCount = ceil(strlen($message) / $lineLength);

        $lines = [];
        for ($i = 0; $i < $lineCount; $i++) {
            $length = $lineLength;
            if (($i + 1) * $lineLength > strlen($message)) {
                $length = strlen($message) - ($i * $lineLength);
            }
            $lines[] = substr($message, $i * $lineLength, $length);
        }

        return $lines;
    }

    private function calculateRectangleHeight () {
        $height = count($this->lines) * $this->image->getCharacterHeight($this->font);

        return $height + (2 * $this->padding);
    }

    private function calculateLineCharacters () {
        return ceil(($this->image->getWidth() - (2 * ($this->margin + $this->padding))) /
                    $this->image->getCharacterWidth($this->font));
    }
}