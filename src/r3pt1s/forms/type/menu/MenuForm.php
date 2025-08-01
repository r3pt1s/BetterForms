<?php

namespace r3pt1s\forms\type\menu;

use Exception;
use pocketmine\form\FormValidationException;
use pocketmine\network\PacketHandlingException;
use pocketmine\player\Player;
use r3pt1s\forms\element\FormElement;
use r3pt1s\forms\element\menu\MenuOption;
use r3pt1s\forms\type\BaseForm;
use r3pt1s\forms\type\misc\FormType;

abstract class MenuForm extends BaseForm {

    public function __construct(
        string $title,
        private readonly string $body = "",
        private array $elements = []
    ) {
        parent::__construct($title);
        $this->elements = array_values($this->elements);
    }

    final public function handleFormResponse(Player $player, mixed $data): void {
        if (!is_numeric($data)) {
            throw new FormValidationException("Expected int, got " . gettype($data));
        }

        /** @var array<MenuOption> $buttons */
        $buttons = array_values(array_filter($this->elements, fn(FormElement $element) => $element instanceof MenuOption));
        $index = intval($data);
        if (!isset($buttons[$index])) {
            throw new FormValidationException("No button on index $index found");
        }

        try {
            ($button = $buttons[$index])->executeOnClick($player, $button);
            $this->onSubmit($player, $index, $button);
        } catch (Exception $exception) {
            throw PacketHandlingException::wrap($exception, "Caught exception while handling the form submit");
        }
    }

    abstract public function onSubmit(Player $player, int $index, MenuOption $option): void;

    public function getBody(): string {
        return $this->body;
    }

    public function getElements(): array {
        return $this->elements;
    }

    final protected function getFormType(): FormType {
        return FormType::FORM;
    }

    final protected function write(): array {
        return ["content" => $this->body, "elements" => $this->elements];
    }
}