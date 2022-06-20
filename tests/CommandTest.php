<?php

it('parses and outputs template', function () {
    $minicli = getApp();
    $minicli->runCommand(['minicli', 'stencil', 'template=example', 'name=Erika']);
})->expectOutputString("Hello Erika!");

it('saves output to a file', function () {
    $minicli = getApp();
    $minicli->runCommand(['minicli', 'stencil', 'template=example', 'name=Erika', 'output=test.txt']);

    $this->assertTrue(file_exists(__DIR__ . '/../test.txt'));
    unlink(__DIR__ . '/../test.txt');
});