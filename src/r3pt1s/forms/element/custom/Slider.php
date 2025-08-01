<?php

namespace r3pt1s\forms\element\custom;

use r3pt1s\forms\element\CustomFormElement;
use r3pt1s\forms\element\misc\ElementType;
use r3pt1s\forms\element\misc\InteractiveElement;

final class Slider extends CustomFormElement implements InteractiveElement {

    public function __construct(
        string $name,
        string $text,
        private readonly float $min,
        private readonly float $max,
        private readonly float $step = 1.0,
        private readonly ?float $default = null
    ) {
        parent::__construct($name, $text);
    }

    public function getMin(): float {
        return $this->min;
    }

    public function getMax(): float {
        return $this->max;
    }

    public function getStep(): float {
        return $this->step;
    }

    public function getDefault(): ?float {
        return $this->default;
    }

    public function getElementType(): ElementType {
        return ElementType::SLIDER;
    }

    protected function write(): array {
        return [
            "min" => $this->min,
            "max" => $this->max,
            "step" => $this->step,
            "default" => $this->default,
        ];
    }
}