<?php

namespace r3pt1s\forms\builder;

use Closure;
use r3pt1s\forms\type\modal\ClosureModalForm;

final class ModalFormBuilder {

    public static function create(
        string $title = "",
        string $body = "",
        string $yesButtonText = "gui.yes",
        string $noButtonText = "gui.no",
        bool $chooseFalseOnCancel = true,
        ?Closure $submitClosure = null,
        ?Closure $cancelClosure = null
    ): self {
        return new self($title, $body, $yesButtonText, $noButtonText, $chooseFalseOnCancel, $submitClosure, $cancelClosure);
    }

    private function __construct(
        private string $title,
        private string $body,
        private string $yesButtonText,
        private string $noButtonText,
        private bool $chooseFalseOnCancel,
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

    public function yesButtonText(string $yesButtonText): self {
        $this->yesButtonText = $yesButtonText;
        return $this;
    }

    public function noButtonText(string $noButtonText): self {
        $this->noButtonText = $noButtonText;
        return $this;
    }

    public function chooseFalseOnCancel(bool $enabled = true): self {
        $this->chooseFalseOnCancel = $enabled;
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

    public function build(): ClosureModalForm {
        return new ClosureModalForm($this->title, $this->body, $this->yesButtonText, $this->noButtonText, $this->chooseFalseOnCancel, $this->submitClosure, $this->cancelClosure);
    }
}