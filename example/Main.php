<?php

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerJumpEvent;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use r3pt1s\forms\builder\CustomFormBuilder;
use r3pt1s\forms\Forms;
use r3pt1s\forms\type\misc\CustomFormResponse;
use r3pt1s\forms\type\misc\FormCancelReason;

final class Main extends PluginBase implements Listener {

    protected function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        if (!Forms::isRegistered()) Forms::register($this);
    }

    protected function onDisable(): void {
        Forms::getInstance()->unregister();
    }

    public function onJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();

        $player->sendForm(new WelcomeForm());
    }

    public function onSneak(PlayerToggleSneakEvent $event): void {
        if (!$event->isSneaking()) return;
        $player = $event->getPlayer();
        $useRealValues = true;
        if ($useRealValues) {
            $player->sendForm(CustomFormBuilder::create()
                ->useRealValues()
                ->title("HI")
                ->header("Please change the settings or whatever")
                ->divider()
                ->label("Watch out kiddo")
                ->input("test", "sigma", "Are you really sigma?", "YOU ARE NOT.")
                ->label("What is this?")
                ->slider("test2", "sigma fear not", 1, 2, 0.1)
                ->dropdown("test3", "Dropdown Choose", ["Test", "Sigma"], 1)
                ->toggle("test4", "Are you skbidi?", true)
                ->stepSlider("test5", "What are you?", ["gangster", "sigma", "ohio king"], 1)
                ->label("If you are done click 'Submit'")
                ->onSubmit(function (Player $player, CustomFormResponse $response): void {
                    $player->sendMessage("test: " . $response->getString("test"));
                    $player->sendMessage("test2: " . $response->getFloat("test2"));
                    $player->sendMessage("test3: " . $response->getString("test3"));
                    $player->sendMessage("test4: " . ($response->getBool("test4") ? "Yes" : "No"));
                    $player->sendMessage("test5: " . $response->getString("test5"));
                })
                ->onCancel(function (Player $player, FormCancelReason $reason): void {
                    $player->sendMessage("Why did you close the form bro? (" . $reason->name . ")");
                })
                ->build());
        } else {
            $player->sendForm(CustomFormBuilder::create()
                ->title("HI")
                ->header("Please change the settings or whatever")
                ->divider()
                ->label("Watch out kiddo")
                ->input("test", "sigma", "Are you really sigma?", "YOU ARE NOT.")
                ->label("What is this?")
                ->slider("test2", "sigma fear not", 1, 2, 0.1)
                ->dropdown("test3", "Dropdown Choose", ["Test", "Sigma"], 1)
                ->toggle("test4", "Are you skbidi?", true)
                ->stepSlider("test5", "What are you?", ["gangster", "sigma", "ohio king"], 1)
                ->label("If you are done click 'Submit'")
                ->onSubmit(function (Player $player, CustomFormResponse $response): void {
                    $player->sendMessage("test: " . $response->getString("test"));
                    $player->sendMessage("test2: " . $response->getFloat("test2"));
                    $player->sendMessage("test3: " . $response->getInt("test3"));
                    $player->sendMessage("test4: " . ($response->getBool("test4") ? "Yes" : "No"));
                    $player->sendMessage("test5: " . $response->getInt("test5"));
                })
                ->onCancel(function (Player $player, FormCancelReason $reason): void {
                    $player->sendMessage("Why did you close the form bro? (" . $reason->name . ")");
                })
                ->build());
        }
    }

    public function onJump(PlayerJumpEvent $event): void {
        $player = $event->getPlayer();
        $chooseFalseOnCancel = true;
        if ($chooseFalseOnCancel) {
            $player->sendForm(Forms::modal()
                ->chooseFalseOnCancel() // enabled by default
                ->title("Are you the ohio king?")
                ->body("Do you personally think you are worthy of the tile 'ohio king'?")
                ->onSubmit(function (Player $player, bool $choice): void {
                    $player->sendMessage("Nice! You pressed: " . ($choice ? "yes" : "no"));
                })
                ->onCancel(function (Player $player, FormCancelReason $reason): void {
                    $player->sendMessage("Why did you close the form you baka? (" . $reason->name . ")");
                }) // if $chooseFalseOnCancel is enabled, this will never be called
                ->build());
        } else {
            $player->sendForm(Forms::modal()
                ->title("Are you the ohio king?")
                ->body("Do you personally think you are worthy of the tile 'ohio king'?")
                ->chooseFalseOnCancel(false)
                ->onSubmit(function (Player $player, bool $choice): void {
                    $player->sendMessage("Nice! You pressed: " . ($choice ? "yes" : "no"));
                })
                ->onCancel(function (Player $player, FormCancelReason $reason): void {
                    $player->sendMessage("Why did you close the form you baka? (" . $reason->name . ")");
                })
                ->build());
        }
    }
}