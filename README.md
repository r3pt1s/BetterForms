# BetterForms
Yet another forms library for PocketMine-MP

## How to use?
To learn how to use this thing, you can check out the [example file](https://github.com/r3pt1s/BetterForms/blob/main/example/Main.php)
To actually make this library work, you have to use `register(PluginBase)` in your `onEnable()`
```php
protected function onEnable(): void {
    if (!Forms::isRegistered()) Forms::register($this);
}
```

If you don't check if it's already registered, it might throw an exception if it already is.