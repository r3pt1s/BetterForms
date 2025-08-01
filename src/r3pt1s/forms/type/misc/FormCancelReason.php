<?php

namespace r3pt1s\forms\type\misc;

use Exception;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;

enum FormCancelReason {

    case CLOSED; /** The user has closed the form */
    case BUSY; /** The user has received this form while having a loading screen */

    /**
     * @throws Exception
     */
    public static function fromInt(int $int): FormCancelReason {
        return match ($int) {
            ModalFormResponsePacket::CANCEL_REASON_CLOSED => self::CLOSED,
            ModalFormResponsePacket::CANCEL_REASON_USER_BUSY => self::BUSY,
            default => throw new Exception("Form cancel reason (" . $int . ") needs to be implemented.")
        };
    }
}