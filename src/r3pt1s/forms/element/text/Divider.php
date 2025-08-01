<?php

namespace r3pt1s\forms\element\text;

use r3pt1s\forms\element\FormElement;
use r3pt1s\forms\element\misc\ElementType;
use r3pt1s\forms\element\misc\TextElement;

final class Divider extends FormElement implements TextElement {

    public function __construct() {
        parent::__construct("");
    }

    public function getElementType(): ElementType {
        return ElementType::DIVIDER;
    }

    protected function write(): array {
        return ["text" => ""];
    }

    public static function create(): self {
        return new self();
    }
}