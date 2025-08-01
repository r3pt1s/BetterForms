<?php

namespace r3pt1s\forms\element;

use JsonSerializable;
use r3pt1s\forms\element\misc\ElementType;

abstract class FormElement implements JsonSerializable {

    public function __construct(private readonly string $text) {}

    public function jsonSerialize(): array {
        return array_merge($this->write(), ["type" => $this->getElementType()->value, "text" => $this->getText()]);
    }

    public function getText(): string {
        return $this->text;
    }

    abstract public function getElementType(): ElementType;

    abstract protected function write(): array;
}