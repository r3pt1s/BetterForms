<?php

namespace r3pt1s\forms\type\modal;

use Closure;
use pocketmine\player\Player;
use r3pt1s\forms\type\misc\FormCancelReason;

final class ClosureModalForm extends ModalForm {

    public function __construct(
        string $title,
        string $body = "",
        string $yesButtonText = "gui.yes",
        string $noButtonText = "gui.no",
        bool $chooseFalseOnCancel = true,
        private readonly ?Closure $submitClosure = null,
        private readonly ?Closure $cancelClosure = null
    ) {
        parent::__construct($title, $body, $yesButtonText, $noButtonText, $chooseFalseOnCancel);
    }

    final public function onSubmit(Player $player, bool $choice): void {
        if ($this->submitClosure !== null) ($this->submitClosure)($player, $choice);
    }

    final public function onCancel(Player $player, FormCancelReason $cancelReason): void {
        if ($this->cancelClosure !== null) ($this->cancelClosure)($player, $cancelReason);
    }
}