<?php

namespace r3pt1s\forms\element\misc;

use JsonSerializable;

final class FormIcon implements JsonSerializable {

    public const TYPE_URL = "url";
    public const TYPE_PATH = "path";

    public function __construct(
        private readonly string $data,
        private readonly string $type = self::TYPE_URL
    ) {}

    public function getData(): string {
        return $this->data;
    }

    public function getType(): string {
        return $this->type;
    }

    public function jsonSerialize(): array {
        return ["type" => $this->type, "data" => $this->data];
    }

    public static function create(string $data, string $type = self::TYPE_URL): self {
        return new self($data, $type);
    }

    public static function url(string $data): self {
        return new self($data);
    }

    public static function path(string $data): self {
        return new self($data, self::TYPE_PATH);
    }
}