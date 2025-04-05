<?php

declare(strict_types=1);

use App\Livewire\Brands\Create;
use App\Models\Brand;
use Livewire\Livewire;

it('test the brand create component if working', function () {
    $this->loginAsAdmin();

    Livewire::test(Create::class)
        ->assertOk()
        ->assertViewIs('livewire.brands.create');
});

it('tests the brand create component', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    Livewire::test(Create::class)
        ->set('name', 'apple')
        ->set('description', 'Apple description')
        ->call('create')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('brands', [
        'name'        => 'apple',
        'description' => 'Apple description',
    ]);
});

it('tests the create brand component validation', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    Livewire::test(Create::class)
        ->set('name', '')
        ->call('create')
        ->assertHasErrors(
            ['name' => 'required'],
        );
});

it('throws an error if the brand name is duplicated', function () {
    $this->loginAsAdmin();

    Brand::factory()->create(['name' => 'apple']);

    Livewire::test(Create::class)
        ->set('name', 'apple')
        ->call('create')
        ->assertHasErrors(
            ['name' => 'The brand name has already been taken.'],
        );
});
