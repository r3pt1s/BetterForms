<?php

namespace r3pt1s\forms;

use Closure;
use Exception;
use JsonException;
use pocketmine\event\EventPriority;
use pocketmine\event\HandlerListManager;
use pocketmine\event\RegisteredListener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;
use pocketmine\network\PacketHandlingException;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use r3pt1s\forms\builder\CustomFormBuilder;
use r3pt1s\forms\builder\MenuFormBuilder;
use r3pt1s\forms\builder\ModalFormBuilder;
use r3pt1s\forms\type\misc\FormCancelReason;
use ReflectionException;

final class Forms {
    use SingletonTrait;

    private static ?PluginBase $registrant = null;
    private RegisteredListener $registeredListener;

    /**
     * @throws Exception
     */
    public static function register(PluginBase $plugin): void {
        if (self::$registrant !== null) {
            throw new Exception("'Forms' already has a plugin registrant. (" . self::$registrant::class . ")");
        }

        self::$registrant = $plugin;
        self::setInstance(new self());
    }

    public static function menu(
        string $title = "",
        string $body = "",
        array $elements = [],
        ?Closure $submitClosure = null,
        ?Closure $cancelClosure = null
    ): MenuFormBuilder {
        return MenuFormBuilder::create($title, $body, $elements, $submitClosure, $cancelClosure);
    }

    public static function custom(
        string $title = "",
        array $elements = [],
        bool $useRealValues = false,
        ?Closure $submitClosure = null,
        ?Closure $cancelClosure = null
    ): CustomFormBuilder {
        return CustomFormBuilder::create($title, $elements, $useRealValues, $submitClosure, $cancelClosure);
    }

    public static function modal(
        string $title = "",
        string $body = "",
        string $yesButtonText = "gui.yes",
        string $noButtonText = "gui.no",
        bool $chooseFalseOnCancel = true,
        ?Closure $submitClosure = null,
        ?Closure $cancelClosure = null
    ): ModalFormBuilder {
        return ModalFormBuilder::create($title, $body, $yesButtonText, $noButtonText, $chooseFalseOnCancel, $submitClosure, $cancelClosure);
    }

    public static function isRegistered(): bool {
        return self::$registrant !== null;
    }

    /**
     * @throws ReflectionException
     */
    private function __construct() {
        $this->registeredListener = self::$registrant->getServer()->getPluginManager()->registerEvent(DataPacketReceiveEvent::class, $this->handleDataPacketReceive(...), EventPriority::HIGHEST, self::$registrant);
    }

    public function handleDataPacketReceive(DataPacketReceiveEvent $event): void {
        $packet = $event->getPacket();
        $player = $event->getOrigin()->getPlayer();

        if ($packet instanceof ModalFormResponsePacket && $player instanceof Player) {
            $event->cancel();
            if ($packet->cancelReason !== null) {
                try {
                    $player->onFormSubmit($packet->formId, FormCancelReason::fromInt($packet->cancelReason));
                } catch (Exception $e) {
                    self::$registrant->getLogger()->logException($e);
                }
            } else if ($packet->formData !== null) {
                try {
                    $formData = json_decode($packet->formData, true, 2, JSON_THROW_ON_ERROR);
                    $player->onFormSubmit($packet->formId, $formData);
                } catch (JsonException $e) {
                    self::$registrant->getLogger()->logException($e);
                }
            } else throw new PacketHandlingException("ModalFormResponsePacket should either contain cancelReason or formData, none given");
        }
    }

    /**
     * @throws Exception
     */
    public function unregister(): void {
        if (self::$registrant === null) {
            throw new Exception("'Forms' does not have a plugin registrant.");
        }

        HandlerListManager::global()->unregisterAll($this->registeredListener);
        self::$registrant = null;
    }
}