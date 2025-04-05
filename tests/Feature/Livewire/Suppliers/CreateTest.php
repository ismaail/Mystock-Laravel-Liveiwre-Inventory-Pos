<?php

declare(strict_types=1);

use App\Livewire\Suppliers\Create;
use Livewire\Livewire;

it('test the supplier create component if working', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    Livewire::test(Create::class)
        ->assertOk()
        ->assertViewIs('livewire.suppliers.create');
});

it('tests the create supplier component', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    Livewire::test(Create::class)
        ->set('name', 'John doe')
        ->set('phone', '00000000000')
        ->set('email', 'supplier@gmail.com')
        ->set('city', 'casablanca')
        ->call('create')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('suppliers', [
        'name'  => 'John doe',
        'phone' => '00000000000',
        'email' => 'supplier@gmail.com',
        'city'  => 'casablanca',
    ]);
});

it('tests the create supplier component validation', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    Livewire::test(Create::class)
        ->set('name', '')
        ->set('phone', '')
        ->set('email', '')
        ->set('city', '')
        ->call('create')
        ->assertHasErrors([
            'name' => 'required',
            'phone' => 'required',
        ]);
});
