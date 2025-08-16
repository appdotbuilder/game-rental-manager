<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

test('authenticated users are redirected from dashboard', function () {
    $this->actingAs($user = User::factory()->create(['role' => 'cashier']));

    $this->get('/dashboard')->assertRedirect('/cashier');
});
