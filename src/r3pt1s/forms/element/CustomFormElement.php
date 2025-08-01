<?php

namespace r3pt1s\forms\element;

abstract class CustomFormElement extends FormElement {

    public function __construct(
        private readonly string $name,
        string $text
    ) {
        parent::__construct($text);
    }

    public function getName(): string {
        return $this->name;
    }
}