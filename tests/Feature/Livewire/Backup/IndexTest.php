<?php

declare(strict_types=1);

use App\Livewire\Backup\Index;

it('test backup page if can be rendred', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    Livewire::test(Index::class)
        ->assertOk()
        ->assertViewIs('livewire.backup.index');
});

it('can download a backup', function () {
    $this->markTestSkipped('Needs refector');

    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    Livewire::test(Index::class)
        ->call('downloadBackup', 'backup.zip')
        ->assertOk();

    $backups = Storage::allFiles('backup');

    expect($backups)->not()->toBeEmpty();
});

it('can delete a backup', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    Livewire::test(Index::class)
        ->call('delete', 'backup.zip');

    $backups = Storage::allFiles('backup');

    expect($backups)->toBeEmpty();
});
