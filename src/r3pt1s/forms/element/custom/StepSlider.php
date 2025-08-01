<?php

namespace r3pt1s\forms\element\custom;

use InvalidArgumentException;
use r3pt1s\forms\element\CustomFormElement;
use r3pt1s\forms\element\misc\ElementType;
use r3pt1s\forms\element\misc\InteractiveElement;
use r3pt1s\forms\element\misc\SelectorElement;

final class StepSlider extends CustomFormElement implements InteractiveElement, SelectorElement {

    public function __construct(
        string $name,
        string $text,
        private readonly array $options,
        private readonly int $defaultIndex = 0
    ) {
        parent::__construct($name, $text);
        if (!isset($this->options[$this->defaultIndex])) {
            throw new InvalidArgumentException("Default index " . $this->defaultIndex . " is out of bounds");
        }
    }

    public function getOptions(): array {
        return $this->options;
    }

    public function getDefaultIndex(): int {
        return $this->defaultIndex;
    }

    public function getElementType(): ElementType {
        return ElementType::STEP_SLIDER;
    }

    protected function write(): array {
        return ["steps" => $this->options, "default" => $this->defaultIndex];
    }
}