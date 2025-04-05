<?php

declare(strict_types=1);

use App\Livewire\Currency\Edit;
use Livewire\Livewire;
use App\Models\Currency;

it('test the currency edit if working', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    Livewire::test(Edit::class)
        ->assertOk()
        ->assertViewIs('livewire.currency.edit');
});

it('tests the update currency can component', function () {
    $this->loginAsAdmin();

    $currency = Currency::factory()->create();

    Livewire::test(Edit::class, ['id' => $currency->id])
        ->set('currency', $currency)
        ->set('name', 'Us Dollar')
        ->set('code', 'USD')
        ->set('locale', '$')
        ->call('update')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('currencies', [
        'name'   => 'Us Dollar',
        'code'   => 'USD',
        'locale' => '$',
    ]);
});

it('tests the edit user component validation', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    $currency = Currency::factory()->create();

    Livewire::test(Edit::class, ['id' => $currency->id])
        ->set('currency', $currency)
        ->set('name', '')
        ->set('code', '')
        ->set('locale', '')
        ->call('update')
        ->assertHasErrors([
            'name' => 'required',
            'code'   => 'required',
            'locale' => 'required',
        ]);
});
