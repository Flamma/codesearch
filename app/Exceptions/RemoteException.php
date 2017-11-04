<?php

namespace App\Exceptions;

use Exception;

class RemoteException extends Exception
{
    private $status;
    private $response;

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response(json_encode([
            'error' => "Repository host returned bad status.",
            'status' => $this->status,
            'response' => $this->response,
        ]), 502);
    }

    public function __construct($status, $response)
    {
        parent::__construct();
        $this->status = $status;
        $this->response = $response;

    }
}
