<?php namespace Tests\App\Http\Clients;


use App\Http\Clients\Bamboo;
use App\Http\Clients\BambooAPI;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
use Tests\TestCase;

class BambooTest extends TestCase
{
    /**
     * @var \IntegrationTester
     */
    protected $tester;

    use WithFaker;

    /**
     * It should prevent to create an instance from parent class
     *
     * @test
     */
    public function ShouldPreventToCreateAnInstanceFromParentClass()
    {
        $this->expectException( BindingResolutionException::class );
        app()->make( BambooAPI::class );

        $this->mock();
    }

    /**
     * It should return empty array if API is disabled
     *
     * @test
     */
    public function ShouldReturnEmptyArrayIfApiIsDisabled()
    {
        config()->set( 'services.bamboo.api.disabled', true );
        /** @var MockInterface $client */
        $client = $this->mock( Client::class );

        $bamboo = app()->make( Bamboo::class );

        $client->shouldNotHaveBeenCalled();
        $this->assertEquals( [], $bamboo->get( '/' ) );
        $this->assertEquals( 2, 2 );
        config()->set( 'services.bamboo.api.disabled', null );
    }

    /**
     * It should Make a Client Request
     *
     * @test
     */
    public function ShouldMakeAClientRequest()
    {
        $response = new Response( 500, [], '{
  "error": {
    "status": 403,
    "title": "Request Authentication Failure",
    "code": "12345",
    "detail": "The client ID provided is invalid"
  }
}' );
        /** @var MockInterface $client */
        $client = $this->mock( Client::class );
        $client
            ->shouldReceive('get' )
            ->andReturn( $response )
            ->times( 1 );

        /** @var Bamboo $bamboo */
        $bamboo = app()->make( Bamboo::class );

        $expected = [
            'error' => [
                'status' => 403,
                'title' => 'Request Authentication Failure',
                'code' => '12345',
                'detail' => 'The client ID provided is invalid',
            ],
        ];
        $this->assertEquals( $expected, $bamboo->get( '/' ) );
    }

    /**
     * It should return an empty array on malformed JSON
     *
     * @test
     */
    public function should_return_an_empty_array_on_malformed_JSON()
    {
        $response = new Response( 500, [], '122323""Content"' );

        /** @var MockInterface $client */
        $client = $this->mock( Client::class );
        $client
            ->shouldReceive('get' )
            ->andReturn( $response )
            ->times( 1 );

        /** @var Bamboo $bamboo */
        $bamboo = app()->make( Bamboo::class );
        $this->assertEquals( [], $bamboo->get( '/' ) );
    }

    /**
     * It should return a base URL with the API Key
     *
     * @test
     */
    public function ShouldReturnABaseUrlWithTheApiKey()
    {
        $bamboo = app()->make( Bamboo::class );
        $this->assertEquals(
            'https://bamboo:x@api.bamboohr.com/api/',
            $bamboo->get_base()
        );
    }

    /**
     * It should create the arguments for the request
     *
     * @dataProvider argumentsProvider
     * @test
     */
    public function ShouldCreateTheArgumentsForTheRequest( $args, $request_args, $expected )
    {
        $bamboo = app()->make( Bamboo::class );
        $this->assertEquals( $expected, $bamboo->get_request_options( $args, $request_args ) );
    }

    public function argumentsProvider()
    {
        $start = date( 'Y-m-d', strtotime( '3 weeks ago' ) );
        return [
            [ [], [], [ 'headers' => [ 'Accept' => 'application/json' ], 'query' => [ 'format' => 'JSON' ] ] ],
            [ [], [ 'headers' => [] ], [ 'headers' => [], 'query' => [ 'format' => 'JSON' ] ] ],
            [ [ 'end' => 'Y-12-31' ], [], [ 'headers' => [ 'Accept' => 'application/json' ], 'query' => [ 'format' => 'JSON', 'end' => 'Y-12-31' ] ] ],
            [ [ 'status' => 'approved', 'start' => $start ], [], [ 'headers' => [ 'Accept' => 'application/json' ], 'query' => [ 'format' => 'JSON', 'status' => 'approved', 'start' => $start ] ] ],
        ];
    }
}
