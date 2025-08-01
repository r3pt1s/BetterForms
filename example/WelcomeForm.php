<?php

use pocketmine\player\Player;
use r3pt1s\forms\element\menu\MenuOption;
use r3pt1s\forms\element\misc\FormIcon;
use r3pt1s\forms\element\text\Divider;
use r3pt1s\forms\element\text\Header;
use r3pt1s\forms\element\text\Label;
use r3pt1s\forms\type\menu\MenuForm;
use r3pt1s\forms\type\misc\FormCancelReason;

final class WelcomeForm extends MenuForm {

    public function __construct() {
        parent::__construct(
            "Yo!",
            "",
            [
                new Header("Welcome!"),
                new Divider(),
                new Label("I wanna show you something!"),
                new MenuOption("Follow", FormIcon::url("https://raw.githubusercontent.com/LydoxMC/brand-assets/refs/heads/main/lydoxLogoTransparent.png")),
                new MenuOption("Leave", FormIcon::path("textures/blocks/sandstone_bottom")),
                new MenuOption("Non", FormIcon::path("textures/blocks/anvil_base"))
            ]
        );
    }

    public function onSubmit(Player $player, int $index, MenuOption $option): void {
        $player->sendMessage("Nice! You pressed: " . $option->getText() . " ($index)");
    }

    public function onCancel(Player $player, FormCancelReason $cancelReason): void {
        $player->sendMessage("Why did you close the form man? (" . $cancelReason->name . ")");
    }
}