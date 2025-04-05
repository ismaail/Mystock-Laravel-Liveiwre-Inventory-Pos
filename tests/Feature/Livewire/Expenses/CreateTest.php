<?php

declare(strict_types=1);

use App\Livewire\Expense\Create;
use App\Models\ExpenseCategory;

it('test the expenses create if working', function () {
    $this->withoutExceptionHandling();
    $this->loginAsAdmin();

    Livewire::test(Create::class)
        ->assertOk()
        ->assertViewIs('livewire.expense.create');
});

it('tests the create expense can create', function () {
    $this->loginAsAdmin();

    $category = ExpenseCategory::factory()->create();

    $category_id = $category->id;

    Livewire::test(Create::class)
        ->set('reference', '12345') // This is overwriten in the Model's creating observer method.
        ->set('date', '2023/03/21')
        ->set('category_id', $category_id)
        ->set('amount', 5000)
        ->call('create')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('expenses', [
        'reference'   => '001', // Auto created in the Model's creating observer method.
        'date'        => '2023-03-21',
        'category_id' => $category_id,
        'amount'      => '500000.00',
    ]);
});

it('tests the create expense component validation', function () {
    $this->loginAsAdmin();

    Livewire::test(Create::class)
        ->set('reference', '')
        ->set('date', '')
        ->set('category_id', '')
        ->set('amount', '')
        ->call('create')
        ->assertHasErrors([
            'reference' => 'required',
            'date' => 'required',
            'category_id' => 'required',
            'amount' => 'required',
        ]);
});
