<?php

namespace r3pt1s\forms\element\custom;

use r3pt1s\forms\element\CustomFormElement;
use r3pt1s\forms\element\misc\ElementType;
use r3pt1s\forms\element\misc\InteractiveElement;

final class Toggle extends CustomFormElement implements InteractiveElement {

    public function __construct(
        string $name,
        string $text,
        private readonly bool $default = false
    ) {
        parent::__construct($name, $text);
    }

    public function isDefault(): bool {
        return $this->default;
    }

    public function getElementType(): ElementType {
        return ElementType::TOGGLE;
    }

    protected function write(): array {
        return ["default" => $this->default];
    }
}