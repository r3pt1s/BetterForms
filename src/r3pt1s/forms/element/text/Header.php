<?php

namespace r3pt1s\forms\element\text;

use r3pt1s\forms\element\FormElement;
use r3pt1s\forms\element\misc\ElementType;
use r3pt1s\forms\element\misc\TextElement;

final class Header extends FormElement implements TextElement {

    public function getElementType(): ElementType {
        return ElementType::HEADER;
    }

    protected function write(): array {
        return [];
    }

    public static function create(string $text): self {
        return new self($text);
    }
}