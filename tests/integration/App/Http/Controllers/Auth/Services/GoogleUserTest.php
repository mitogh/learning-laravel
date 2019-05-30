<?php namespace Tests\App\Http\Controllers\Auth\Services;

use App\Http\Controllers\Auth\Services\GoogleUser;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GoogleUserTest extends \Codeception\Test\Unit
{
    use RefreshDatabase;

    /**
     * @var \IntegrationTester
     */
    protected $tester;

    /** @var GoogleUser */
    protected $instance;

    protected function _before()
    {
        $this->instance = app()->make( GoogleUser::class );
    }

    /**
     * It should prevent login with non valid user
     *
     * @dataProvider invalidLoginProvider
     *
     * @test
     * @param $args
     * @param int $status
     */
    public function ShouldPreventLoginWithNonValidUser( $args, int $status )
    {
        try {
            $this->instance->login( $this->tester->givenASocialiteUser( $args ) );
            // Use Wrong assertion to ensure this one is not called and during the tests.
            $this->assertTrue( false );
        } catch ( HttpException $exception ) {
            $this->assertEquals( $status, $exception->getStatusCode() );
        }
    }

    public function invalidLoginProvider()
    {
        return [
            [ [], Response::HTTP_FORBIDDEN ],
            [ [ 'id' => 2 ], Response::HTTP_FORBIDDEN ],
            [ [ 'id' => 2, 'email' => 'wrond@domain.com' ], Response::HTTP_FORBIDDEN ],
            [ [ 'id' => 2, 'email' => 'sample@tri.be', 'hd' => 'hosted.domain' ], Response::HTTP_FORBIDDEN ],
        ];
    }

    /**
     * It should autenticate a user with valid data provider
     *
     * @test
     */
    public function should_autenticate_a_user_with_valid_data_provider()
    {
        $this->assertFalse( \Auth::check() );

        $response = $this->instance->login( $this->tester->givenASocialiteUser( [
            'email' => 'sample@tri.be',
            'hd' => 'tri.be',
        ] ) );

        $this->assertTrue( \Auth::check() );
        $this->assertEquals( \Auth::id(), User::where( [ 'email' => 'sample@tri.be' ] )->first()->id );

        $this->assertTrue( $response->isRedirection() );
        $this->assertEquals( config( 'app.url' ), $response->getTargetUrl() );
        $this->assertEquals( Response::HTTP_FOUND, $response->getStatusCode() );
    }
}
