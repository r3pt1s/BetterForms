<?php

namespace r3pt1s\forms\type\custom;

use Exception;
use pocketmine\form\FormValidationException;
use pocketmine\network\PacketHandlingException;
use pocketmine\player\Player;
use r3pt1s\forms\element\CustomFormElement;
use r3pt1s\forms\element\FormElement;
use r3pt1s\forms\element\misc\InteractiveElement;
use r3pt1s\forms\element\misc\SelectorElement;
use r3pt1s\forms\element\misc\TextElement;
use r3pt1s\forms\type\BaseForm;
use r3pt1s\forms\type\misc\CustomFormResponse;
use r3pt1s\forms\type\misc\FormType;

abstract class CustomForm extends BaseForm {

    /**
     * @param string $title
     * @param array $elements
     * @param bool $useRealValues if this is enabled, selections made from a limited range of options in Dropdown or StepSlider will have their value used in CustomFormResponse instead of their index
     */
    public function __construct(
        string $title,
        private array $elements = [],
        private readonly bool $useRealValues = false
    ) {
        parent::__construct($title);
        $this->elements = array_values($this->elements);
    }

    final protected function handleFormResponse(Player $player, mixed $data): void {
        if (!is_array($data)) {
            throw new FormValidationException("Expected array, got " . gettype($data));
        }

        if (($dataCount = count($data)) > ($elementsCount = count($this->elements))) {
            throw new FormValidationException("Too many elements as a response, expected $elementsCount, got $dataCount");
        } else {
            $values = [];
            /** @var array<FormElement|CustomFormElement> $interactiveElements */
            if ($dataCount < $elementsCount) {
                $interactiveElements = array_filter($this->elements, fn(FormElement|CustomFormElement $element) => $element instanceof InteractiveElement);
            } else if ($dataCount == $elementsCount) {
                $interactiveElements = $this->elements;
            }

            foreach ($data as $index => $value) {
                if (!isset($interactiveElements[$index])) {
                    throw new FormValidationException("No element on index $index found");
                }

                if ($value === null) continue;

                $interactiveElement = $interactiveElements[$index];
                if ($interactiveElement instanceof TextElement) continue;
                if (!$interactiveElement instanceof CustomFormElement) {
                    throw new FormValidationException("Found a non custom-form element (" . $interactiveElement->getElementType()->value . ") in a custom form response");
                }

                if ($this->useRealValues && $interactiveElement instanceof SelectorElement && is_int($value)) {
                    if (isset($interactiveElement->getOptions()[$value])) {
                        $value = $interactiveElement->getOptions()[$value];
                    }
                }

                $values[$interactiveElement->getName()] = $value;
            }

            try {
                $this->onSubmit($player, new CustomFormResponse($values));
            } catch (Exception $exception) {
                throw PacketHandlingException::wrap($exception, "Caught exception while handling the form submit");
            }
        }
    }

    abstract public function onSubmit(Player $player, CustomFormResponse $response): void;

    public function getElements(): array {
        return $this->elements;
    }

    public function isUseRealValues(): bool {
        return $this->useRealValues;
    }

    final protected function getFormType(): FormType {
        return FormType::CUSTOM;
    }

    final protected function write(): array {
        return ["content" => $this->elements];
    }
}