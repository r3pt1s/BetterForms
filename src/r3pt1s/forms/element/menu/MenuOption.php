<?php

namespace r3pt1s\forms\element\menu;

use Closure;
use pocketmine\player\Player;
use r3pt1s\forms\element\FormElement;
use r3pt1s\forms\element\misc\ElementType;
use r3pt1s\forms\element\misc\FormIcon;
use r3pt1s\forms\element\misc\InteractiveElement;

final class MenuOption extends FormElement implements InteractiveElement {

    public function __construct(
        string $text,
        private readonly ?FormIcon $icon = null,
        private readonly array $extraData = [],
        private readonly ?Closure $clickClosure = null
    ) {
        parent::__construct($text);
    }

    public function executeOnClick(Player $player, MenuOption $option): void {
        if ($this->clickClosure !== null) ($this->clickClosure)($player, $option);
    }

    public function get(string|int $key, mixed $default = null): mixed {
        return $this->extraData[$key] ?? $default;
    }

    public function getIcon(): ?FormIcon {
        return $this->icon;
    }

    public function getExtraData(): array {
        return $this->extraData;
    }

    public function getElementType(): ElementType {
        return ElementType::BUTTON;
    }

    protected function write(): array {
        return ["image" => $this->icon];
    }

    public static function create(
        string $text,
        ?FormIcon $icon = null,
        array $extraData = [],
        ?Closure $clickClosure = null
    ): self {
        return new self($text, $icon, $extraData, $clickClosure);
    }
}