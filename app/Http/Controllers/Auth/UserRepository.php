<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Contracts\User;
use App\User as UserModel;

class UserRepository
{
    /** @var User */
    protected $user;

    public function set_user( User $user ): UserRepository
    {
        $this->user = $user;
        return $this;
    }

    public function find_or_create(): UserModel
    {
        if ( ! $this->user instanceof User ) {
            throw new \InvalidArgumentException( 'Make sure to provide a valid user contract.' );
        }

        $user = $this->find();

        return $user instanceof UserModel ? $user : $this->create();
    }

    protected function find(): ?UserModel
    {
        return UserModel::where( 'key', $this->user->getId() )->first();
    }

    protected function create(): UserModel
    {
        return UserModel::create( [
            'email' => $this->user->getEmail(),
            'key' => $this->user->getId(),
            'name' => $this->user->getName(),
            'avatar' => $this->user->getAvatar(),
        ] );
    }
}
