<?php

declare(strict_types=1);

use App\Livewire\Suppliers\Edit;
use App\Models\Supplier;
use Livewire\Livewire;

it('test the suppliers edit component if working', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    Livewire::test(Edit::class)
        ->assertOk()
        ->assertViewIs('livewire.suppliers.edit');
});

it('updates a supplier', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    $supplier = Supplier::factory()->create();

    Livewire::test(Edit::class, ['id' => $supplier->id])
        ->set('supplier', $supplier)
        ->set('name', 'New Name')
        ->set('phone', '00000000000')
        ->set('email', 'supplier@gmail.com')
        ->set('city', 'casablanca')
        ->call('update')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('suppliers', [
        'id'    => $supplier->id,
        'name'  => 'New Name',
        'phone' => '00000000000',
        'email' => 'supplier@gmail.com',
        'city'  => 'casablanca',
    ]);
});

it('tests the uodate supplier component validation', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    $supplier = Supplier::factory()->create();

    Livewire::test(Edit::class, ['id' => $supplier->id])
        ->set('supplier', $supplier)
        ->set('name', '')
        ->set('phone', '')
        ->set('email', '')
        ->set('city', '')
        ->call('update')
        ->assertHasErrors([
            'name' => 'required',
            'phone' => 'required',
        ]);
});

