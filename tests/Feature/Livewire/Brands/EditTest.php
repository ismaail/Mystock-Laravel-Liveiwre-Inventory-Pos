<?php

declare(strict_types=1);

use App\Livewire\Brands\Edit;
use Livewire\Livewire;
use App\Models\Brand;

it('test the brand edit component if working', function () {
    $this->loginAsAdmin();

    Livewire::test(Edit::class)
        ->assertOk()
        ->assertViewIs('livewire.brands.edit');
});

it('tests the brand edit component', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    $brand = Brand::factory()->create([
        'name' => 'Old Name',
        'description' => 'Old Description',
    ]);

    Livewire::test(Edit::class)
        ->set('brand', $brand)
        ->set('name', 'apple')
        ->set('description', 'new description')
        ->call('update')
        ->assertHasNoErrors();

    $brand->refresh();
    expect($brand->name)->toBe('apple');
    expect($brand->description)->toBe('new description');
});

it('tests the update brand component validation', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    $brand = Brand::factory()->create();

    Livewire::test(Edit::class, ['id' => $brand->id])
        ->set('brand', $brand)
        ->set('name', '')
        ->set('description', '')
        ->call('update')
        ->assertHasErrors(
            ['name' => 'required'],
        );
});
