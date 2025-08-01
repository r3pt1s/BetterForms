<?php

namespace r3pt1s\forms\type\modal;

use Exception;
use pocketmine\network\PacketHandlingException;
use pocketmine\player\Player;
use r3pt1s\forms\type\BaseForm;
use r3pt1s\forms\type\misc\FormCancelReason;
use r3pt1s\forms\type\misc\FormType;

abstract class ModalForm extends BaseForm {

    public function __construct(
        string $title,
        private readonly string $body = "",
        private readonly string $yesButtonText = "gui.yes",
        private readonly string $noButtonText = "gui.no",
        private readonly bool $chooseFalseOnCancel = true
    ) {
        parent::__construct($title);
    }

    protected function handleFormResponse(Player $player, mixed $data): void {
        if (!is_bool($data)) {
            throw new PacketHandlingException("Expected boolean, got " . gettype($data));
        }

        try {
            $this->onSubmit($player, $data);
        } catch (Exception $exception) {
            throw PacketHandlingException::wrap($exception, "Caught exception while handling the form submit");
        }
    }

    public function handleResponse(Player $player, mixed $data): void {
        if ($data === null || $data instanceof FormCancelReason) {
            if ($this->chooseFalseOnCancel) $this->onSubmit($player, false);
            else $this->onCancel($player, $data ?? FormCancelReason::CLOSED);
            return;
        }

        $this->handleFormResponse($player, $data);
    }

    abstract public function onSubmit(Player $player, bool $choice): void;

    public function getBody(): string {
        return $this->body;
    }

    public function getYesButtonText(): string {
        return $this->yesButtonText;
    }

    public function getNoButtonText(): string {
        return $this->noButtonText;
    }

    public function isChooseFalseOnCancel(): bool {
        return $this->chooseFalseOnCancel;
    }

    final protected function getFormType(): FormType {
        return FormType::MODAL;
    }

    final protected function write(): array {
        return ["content" => $this->body, "button1" => $this->yesButtonText, "button2" => $this->noButtonText];
    }
}