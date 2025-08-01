<?php

namespace r3pt1s\forms\element\custom;

use r3pt1s\forms\element\CustomFormElement;
use r3pt1s\forms\element\misc\ElementType;
use r3pt1s\forms\element\misc\InteractiveElement;

final class Input extends CustomFormElement implements InteractiveElement {

    public function __construct(
        string $name,
        string $text,
        private readonly string $hintText = "",
        private readonly string $defaultText = ""
    ) {
        parent::__construct($name, $text);
    }

    public function getElementType(): ElementType {
        return ElementType::INPUT;
    }

    protected function write(): array {
        return ["placeholder" => $this->hintText, "default" => $this->defaultText];
    }
}