<?php

namespace r3pt1s\forms\type;

use pocketmine\form\Form;
use pocketmine\player\Player;
use r3pt1s\forms\type\misc\FormCancelReason;
use r3pt1s\forms\type\misc\FormType;

abstract class BaseForm implements Form {

    public function __construct(private readonly string $title) {}

    public function onCancel(Player $player, FormCancelReason $cancelReason): void {}

    abstract protected function handleFormResponse(Player $player, mixed $data): void;

    public function handleResponse(Player $player, mixed $data): void {
        if ($data === null || $data instanceof FormCancelReason) {
            $this->onCancel($player, $data ?? FormCancelReason::CLOSED);
            return;
        }

        $this->handleFormResponse($player, $data);
    }

    final public function jsonSerialize(): array {
        return array_merge($this->write(), ["type" => $this->getFormType()->value, "title" => $this->title]);
    }

    public function getTitle(): string {
        return $this->title;
    }

    abstract protected function getFormType(): FormType;

    abstract protected function write(): array;
}