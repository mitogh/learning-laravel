<?php
namespace App\Http\Controllers\Auth\Services;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Contracts\Factory as Socialite;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse as Redirect;

class GoogleController extends Controller implements ContractLogin
{

    /** @var Socialite */
    protected $socialite;
    /** @var ContractUser $user */
    protected $user;

    protected $driver = 'google';

    public function __construct( Socialite $socialite, ContractUser $user )
    {
        $this->socialite = $socialite;
        $this->user = $user;
    }

    public function login(): Redirect
    {
        return $this->socialite->driver( $this->driver )->with( $this->driver_params() )->redirect();
    }

    public function driver_params(): array
    {
        return [
            'hd' => config( 'services.google.suite_domain' ),
            'prompt' => 'select_account',
        ];
    }

    public function handle(): RedirectResponse
    {
        try {
            $user = $this->socialite->driver( $this->driver )->user();
            return $this->user->login( $user );
        } catch ( \Exception $exception ) {
            Log::error( $exception->getMessage() );
            return abort( Response::HTTP_BAD_GATEWAY, $exception->getMessage() );
        }
    }
}
