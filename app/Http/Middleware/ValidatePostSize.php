<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\ValidatePostSize as Middleware;

class ValidatePostSize extends Middleware
{
    /**
     * The maximum allowed size (in kilobytes) for POST requests.
     *
     * @var int
     */
    protected $max = 20480; // 20MB
}