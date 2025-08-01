<?php

namespace r3pt1s\forms\type\menu;

use Closure;
use pocketmine\player\Player;
use r3pt1s\forms\element\menu\MenuOption;
use r3pt1s\forms\type\misc\FormCancelReason;

final class ClosureMenuForm extends MenuForm {

    public function __construct(
        string $title,
        string $body = "",
        array $elements = [],
        private readonly ?Closure $submitClosure = null,
        private readonly ?Closure $cancelClosure = null
    ) {
        parent::__construct($title, $body, $elements);
    }

    final public function onSubmit(Player $player, int $index, MenuOption $option): void {
        if ($this->submitClosure !== null) ($this->submitClosure)($player, $index, $option);
    }

    final public function onCancel(Player $player, FormCancelReason $cancelReason): void {
        if ($this->cancelClosure !== null) ($this->cancelClosure)($player, $cancelReason);
    }
}