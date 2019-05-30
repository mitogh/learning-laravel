<?php
namespace App\Http\Controllers\Auth\Services;

use App\Http\Controllers\Auth\UserRepository;
use App\User as UserModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Two\User;
use Symfony\Component\HttpFoundation\Response;

class GoogleUser implements ContractUser
{
    /** @var User */
    protected $user;

    /** @var UserRepository */
    protected $userRepository;

    /**
     * GoogleUser constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct( UserRepository $userRepository )
    {
        $this->userRepository = $userRepository;
    }

    public function login( User $user ): RedirectResponse
    {
        $this->user = $user;

        abort_unless( $this->is_valid(), Response::HTTP_FORBIDDEN );

        $user = $this->userRepository->set_user( $user )->find_or_create();

        abort_unless( $user instanceof UserModel, \Illuminate\Http\Response::HTTP_NOT_FOUND );

        Auth::login( $user, true );

        return redirect()->route( 'home' );
    }

    /**
     * Make sure the user has a valid Hosted Domain that matches the one specifed on config before doing any operation,
     * plus making sure we an email and ID.
     *
     * @return bool
     */
    public function is_valid(): bool
    {
        if (
            empty( $this->user->getEmail() )
            || empty( $this->user->getId() )
            || empty( $this->user->getRaw() )
            || empty( $this->user->getRaw()[ 'hd' ] )
        ) {
            return false;
        }
        return $this->user->getRaw()[ 'hd' ] === config( 'services.google.suite_domain' );
    }
}
