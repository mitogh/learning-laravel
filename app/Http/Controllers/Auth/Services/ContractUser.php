<?php
namespace App\Http\Controllers\Auth\Services;

use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Two\User;

interface ContractUser
{
    public function login( User $user ): RedirectResponse;

    public function is_valid(): bool;
}
