<?php

declare(strict_types=1);

use Livewire\Livewire;
use App\Livewire\Role\Edit;
use Spatie\Permission\Models\Role;

test('a new role can be update', function () {
    $this->markTestSkipped('Not yet implemented.');

    $this->loginAsAdmin();

    $role = Role::create(['name' => 'Test Role']);

    Livewire::test(Edit::class, ['role' => $role->id])
        ->set('role.name', 'Test Role Updated')
        ->call('update')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('roles', [
        'name' => 'Test Role Updated',
    ]);
});

test('a name is required', function () {
    $this->markTestSkipped('Not yet implemented.');

    $this->loginAsAdmin();
    $role = Role::create(['name' => 'Test Role']);

    Livewire::test(Edit::class, ['role' => $role->id])
        ->set('role.name', '')
        ->call('update')
        ->assertHasErrors(['name' => 'required']);
});

test('a name is unique', function () {
    $this->markTestSkipped('Not yet implemented.');

    $this->loginAsAdmin();
    $role = Role::create(['name' => 'Test Role']);

    Livewire::test(Edit::class, ['role' => $role->id])
        ->set('role.name', 'admin')
        ->call('update')
        ->assertHasErrors(['name' => 'unique']);
});
