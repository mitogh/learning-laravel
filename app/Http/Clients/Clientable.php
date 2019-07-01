<?php

namespace App\Http\Clients;

use Psr\Http\Message\ResponseInterface;

interface Clientable {
    /**
     * Execute a GET API call
     *
     * @param string $path API URL
     * @param array $args arguments to add to the query string
     * @return array|object results from API call
     */
    public function get( string $path, array $args = [] ): array;

    public function get_base(): string;

    /**
     * RE
     *
     * @param array $query_args
     * @param array $request_args
     * @return array
     */
    public function get_request_options( array $query_args = [], array $request_args = [] ): array;

    public function get_response() : ?ResponseInterface;
}
