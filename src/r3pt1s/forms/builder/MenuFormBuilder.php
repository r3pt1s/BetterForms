<?php

namespace r3pt1s\forms\builder;

use Closure;
use r3pt1s\forms\element\menu\MenuOption;
use r3pt1s\forms\element\misc\FormIcon;
use r3pt1s\forms\element\text\Divider;
use r3pt1s\forms\element\text\Header;
use r3pt1s\forms\element\text\Label;
use r3pt1s\forms\type\menu\ClosureMenuForm;

final class MenuFormBuilder {

    public static function create(
        string $title = "",
        string $body = "",
        array $elements = [],
        ?Closure $submitClosure = null,
        ?Closure $cancelClosure = null
    ): self {
        return new self($title, $body, $elements, $submitClosure, $cancelClosure);
    }

    private function __construct(
        private string $title,
        private string $body,
        private array $elements,
        private ?Closure $submitClosure,
        private ?Closure $cancelClosure
    ) {}

    public function title(string $title): self {
        $this->title = $title;
        return $this;
    }

    public function body(string $body): self {
        $this->body = $body;
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

    public function button(
        string $text,
        FormIcon|string|null $url = null,
        string $type = FormIcon::TYPE_URL,
        array $extraData = [],
        ?Closure $clickClosure = null,
    ): self {
        $this->elements[] = new MenuOption(
            $text,
            $url instanceof FormIcon ? $url : (is_string($url) ? FormIcon::create($url, $type) : null),
            $extraData,
            $clickClosure
        );
        return $this;
    }

    public function elements(array $elements): self {
        $this->elements = $elements;
        return $this;
    }

    public function onSubmit(Closure $closure): self {
        $this->submitClosure = $closure;
        return $this;
    }

    public function onCancel(Closure $closure): self {
        $this->cancelClosure = $closure;
        return $this;
    }

    public function build(): ClosureMenuForm {
        return new ClosureMenuForm($this->title, $this->body, $this->elements, $this->submitClosure, $this->cancelClosure);
    }
}