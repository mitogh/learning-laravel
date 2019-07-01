<?php

namespace App\Http\Clients;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

abstract class BambooAPI implements Clientable
{
    public $disabled = false;

    /**
     * @var Client
     */
    protected $client;

    /** @var ResponseInterface */
    protected $response;

    public function __construct( Client $client )
    {
        $this->client = $client;
        $this->disabled = config( 'services.bamboo.api.disabled' );
    }

    /**
     * Execute a GET API call
     *
     * @param string $path API URL
     * @param array $args arguments to add to the query string
     * @return array|object results from API call
     */
    public function get( string $path, array $args = [] ): array
    {
        $this->response = null;

        if ( $this->disabled ) {
            return [];
        }

        try {
            $this->response = $this->client->get( $this->get_base() . $path, $this->get_request_options( $args ) );
            $result = json_decode( (string) $this->response->getBody(), true );
            return is_array( $result ) ? $result : [];
        } catch ( \Exception $exception ) {
            \Log::error( 'Error while fetching: ' . $path );
            \Log::error( 'With the args: ' . print_r( $args, true ) );
            \Log::error( $exception->getMessage() );
            return [];
        }
    }

    public function get_base(): string
    {
        return sprintf(
            '%s%s',
            config( 'services.bamboo.api.domain' ),
            config( 'services.bamboo.api.path' )
        );
    }

    /**
     * @param array $query_args
     * @param array $request_args
     * @return array
     */
    public function get_request_options( array $query_args = [], array $request_args = [] ): array
    {
        return array_merge(
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'query' => array_merge( [ 'format' => 'JSON' ], $query_args ),
            ],
            $request_args
        );
    }

    /**
     * @inheritDoc
     *
     * @return ResponseInterface|null
     */
    public function get_response() : ?ResponseInterface
    {
        return $this->response;
    }
}
