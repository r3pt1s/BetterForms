<?php

namespace r3pt1s\forms\builder;

use Closure;
use r3pt1s\forms\element\custom\Dropdown;
use r3pt1s\forms\element\custom\Input;
use r3pt1s\forms\element\custom\Slider;
use r3pt1s\forms\element\custom\StepSlider;
use r3pt1s\forms\element\custom\Toggle;
use r3pt1s\forms\element\text\Divider;
use r3pt1s\forms\element\text\Header;
use r3pt1s\forms\element\text\Label;
use r3pt1s\forms\type\custom\ClosureCustomForm;

final class CustomFormBuilder {

    public static function create(
        string $title = "",
        array $elements = [],
        bool $useRealValues = false,
        ?Closure $submitClosure = null,
        ?Closure $cancelClosure = null
    ): self {
        return new self($title, $elements, $useRealValues, $submitClosure, $cancelClosure);
    }

    private function __construct(
        private string $title = "",
        private array $elements = [],
        private bool $useRealValues = false,
        private ?Closure $submitClosure = null,
        private ?Closure $cancelClosure = null
    ) {}

    public function title(string $title): self {
        $this->title = $title;
        return $this;
    }

    public function header(string $text): self {
        $this->elements[] = new Header($text);
        return $this;
    }

    public function divider(): self {
        $this->elements[] = new Divider();
        return $this;
    }

    public function label(string $label): self {
        $this->elements[] = new Label($label);
        return $this;
    }

    public function input(
        string $name,
        string $text,
        string $hintText = "",
        string $defaultText = ""
    ): self {
        $this->elements[] = new Input($name, $text, $hintText, $defaultText);
        return $this;
    }

    public function dropdown(
        string $name,
        string $text,
        array $options = [],
        int $defaultIndex = 0
    ): self {
        $this->elements[] = new Dropdown($name, $text, $options, $defaultIndex);
        return $this;
    }

    public function stepSlider(
        string $name,
        string $text,
        array $options = [],
        int $defaultIndex = 0
    ): self {
        $this->elements[] = new StepSlider($name, $text, $options, $defaultIndex);
        return $this;
    }

    public function slider(
        string $name,
        string $text,
        float $min,
        float $max,
        float $step = 1.0,
        ?float $default = null
    ): self {
        $this->elements[] = new Slider($name, $text, $min, $max, $step, $default);
        return $this;
    }

    public function toggle(
        string $name,
        string $text,
        bool $default = false
    ): self {
        $this->elements[] = new Toggle($name, $text, $default);
        return $this;
    }

    public function useRealValues(bool $enabled = true): self {
        $this->useRealValues = $enabled;
        return $this;
    }

    public function onSubmit(Closure $submitClosure): self {
        $this->submitClosure = $submitClosure;
        return $this;
    }

    public function onCancel(Closure $cancelClosure): self {
        $this->cancelClosure = $cancelClosure;
        return $this;
    }

    public function build(): ClosureCustomForm {
        return new ClosureCustomForm($this->title, $this->elements, $this->useRealValues, $this->submitClosure, $this->cancelClosure);
    }
}