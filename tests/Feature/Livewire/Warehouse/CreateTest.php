<?php

declare(strict_types=1);

use App\Livewire\Warehouses\Create;
use Livewire\Livewire;

it('test the warehouse create if working', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    Livewire::test(Create::class)
        ->assertOk()
        ->assertViewIs('livewire.warehouses.create');
});

it('tests the create warehouse validation rules', function () {
    $this->loginAsAdmin();

    Livewire::test(Create::class)
        ->set('name', 'apple')
        ->set('phone', '00000000000')
        ->call('create');

    $this->assertDatabaseHas('warehouses', [
        'name' => 'apple',
        'phone' => '00000000000',
    ]);
});
