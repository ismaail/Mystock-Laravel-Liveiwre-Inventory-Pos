<?php

declare(strict_types=1);

use App\Livewire\Categories\Create;
use Livewire\Livewire;

it('test the category create if working', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    Livewire::test(Create::class)
        ->assertOk()
        ->assertViewIs('livewire.categories.create');
});

it('tests the create category validation rules', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    Livewire::test(Create::class)
        ->set('name', 'apple')
        ->call('create')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('categories', [
        'name' => 'apple',
    ]);
});

it('tests the create category component validation', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    Livewire::test(Create::class)
        ->set('name', '')
        ->call('create')
        ->assertHasErrors(
            ['name' => 'required'],
        );
});
