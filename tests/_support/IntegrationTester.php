<?php

use Laravel\Socialite\Two\User;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
 */
class IntegrationTester extends \Codeception\Actor
{
    use _generated\IntegrationTesterActions;

    /**
     * Define custom actions here
     *
     * @param array $args
     * @return User
     */
    public function givenASocialiteUser( $args = [] ): User
    {
        $abstractUser = Mockery::mock( 'Laravel\Socialite\Two\User' );

        $default = [
            'id' => 1,
            'name' => '',
            'email' => 'sample@sample.com',
            'nickname' => '',
            'avatar' => 'https://en.gravatar.com/userimage',
        ];

        $user = array_merge( $default, $args );

        extract( $user );

        // Get the api user object here
        $abstractUser->shouldReceive( 'getId' )
            ->andReturn( $id )
            ->shouldReceive( 'getName' )
            ->andReturn( $name )
            ->shouldReceive( 'getEmail' )
            ->andReturn( $email )
            ->shouldReceive( 'getNickname' )
            ->andReturn( $nickname )
            ->shouldReceive( 'getAvatar' )
            ->andReturn( $avatar )
            ->shouldReceive( 'getRaw' )
            ->andReturn( $user );

        echo print_r( $abstractUser->user, true );

        return $abstractUser;
    }
}
