<?php
namespace App\Http\Controllers\Auth\Services;

use Illuminate\Http\RedirectResponse as Redirect;
use Symfony\Component\HttpFoundation\RedirectResponse;

interface ContractLogin
{
    public function login(): RedirectResponse;

    public function driver_params(): array;

    public function handle(): Redirect;
}
