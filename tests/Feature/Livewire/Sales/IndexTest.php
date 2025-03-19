<?php

declare(strict_types=1);

use App\Livewire\Sales\Index;

it('test sales list if can be rendred', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    Livewire::test(Index::class)
        ->assertOk()
        ->assertViewIs('livewire.sales.index');
});
