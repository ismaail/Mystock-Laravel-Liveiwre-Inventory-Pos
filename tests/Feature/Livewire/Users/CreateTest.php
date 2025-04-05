<?php

declare(strict_types=1);

use App\Livewire\Users\Create;
use Livewire\Livewire;

it('test the user create if working', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    Livewire::test(Create::class)
        ->assertOk()
        ->assertViewIs('livewire.users.create');
});

it('tests the create user component', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    Livewire::test(Create::class)
        ->set('name', 'John Doe')
        ->set('phone', '00000000000')
        ->set('email', 'admin@admin.com')
        ->set('password', 'password')
        ->call('create')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('users', [
        'name'     => 'John Doe',
        'phone'    => '00000000000',
        'email'    => 'admin@admin.com',
        'password' => 'password',
    ]);
});

it('tests the create user component validation', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    Livewire::test(Create::class)
        ->set('name', '')
        ->set('phone', '')
        ->set('email', '')
        ->set('password', '')
        ->call('create')
        ->assertHasErrors([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
});
