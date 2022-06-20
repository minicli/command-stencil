# Minicli Stencil Command

Command implementation of [minicli/stencil](https://github.com/minicli/stencil). This command will generate files based on Stencil templates. It is useful for creating boilerplate files such as new classes and other documents that should follow a certain structure or template.

## Usage

First, import this command with Composer:

```shell
composer require minicli/command-stencil
```

Then, edit your app's config to include `@minicli/command-help` within your `app_path` definitions. 
You'll also need to set the `stencilDir` config variable and point it to your Stencils directory. For instance:

```php
$app = new App([
    'app_path' => [
            __DIR__ . '/app/Command',
            '@minicli/command-stencil'
        ],
    'stencilDir' => __DIR__ . '/stencils',
    'debug' => true
]);
```

You should now be able to run the `./minicli stencil` command. You can copy the example template from `vendor/minicli/command-stencil/stencils/example.tpl` to test it out:

```shell
cp ./vendor/minicli/command-stencil/stencils/example.tpl ./stencils
./minicli stencil template=example name=YourName
```
```shell
Hello YourName!% 
```