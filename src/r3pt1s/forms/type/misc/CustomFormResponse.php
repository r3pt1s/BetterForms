<?php

namespace r3pt1s\forms\type\misc;

use InvalidArgumentException;

final class CustomFormResponse {

    public function __construct(private readonly array $data) {}

    public function get(string $name): mixed {
        $this->checkExists($name);
        return $this->data[$name];
    }

    public function getInt(string $name): int {
        return $this->get($name);
    }

    public function getString(string $name): string {
        return $this->get($name);
    }

    public function getFloat(string $name): float {
        return $this->get($name);
    }

    public function getBool(string $name): bool {
        return $this->get($name);
    }

    public function getAll(): array {
        return $this->data;
    }

    public function exists(string $name): bool {
        return isset($this->data[$name]);
    }

    private function checkExists(string $name): void {
        if (!$this->exists($name)) throw new InvalidArgumentException("Value \"$name\" not found");
    }
}