<?php

namespace r3pt1s\forms\type\custom;

use Closure;
use pocketmine\player\Player;
use r3pt1s\forms\type\misc\CustomFormResponse;
use r3pt1s\forms\type\misc\FormCancelReason;

final class ClosureCustomForm extends CustomForm {

    public function __construct(
        string $title,
        array $elements = [],
        bool $useRealValues = true,
        private readonly ?Closure $submitClosure = null,
        private readonly ?Closure $cancelClosure = null
    ) {
        parent::__construct($title, $elements, $useRealValues);
    }

    final public function onSubmit(Player $player, CustomFormResponse $response): void {
        if ($this->submitClosure !== null) ($this->submitClosure)($player, $response);
    }

    final public function onCancel(Player $player, FormCancelReason $cancelReason): void {
        if ($this->cancelClosure !== null) ($this->cancelClosure)($player, $cancelReason);
    }
}