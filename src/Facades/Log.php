<?php

namespace Gmedia\IspSystem\Facades;

use Illuminate\Support\Facades\Auth;
use Spatie\Backtrace\Backtrace;

class Log
{
    private $app = null;

    private $guard = 'api';

    private $properties = [];

    private $trace = [];

    public function app($app = null)
    {
        $this->app = $app;

        return $this;
    }

    public function guard($guard = 'api')
    {
        $this->guard = $guard;

        return $this;
    }

    public function properties($properties = null)
    {
        $this->properties = [
            'properties' => $this->properties,
            'trace' => $this->trace,
        ];

        return $this;
    }

    public function trace($frameLimit = 2) // as default counted from helper
    {
        $frame = Backtrace::create()->limit($frameLimit)->frames()[$frameLimit - 1];

        $this->trace = [
            'class' => $frame->class,
            'method' => $frame->method,
        ];
        
        $this->properties = [
            'properties' => $this->properties,
            'trace' => $this->trace,
        ];

        return $this;
    }

    public function new()
    {
        return (new static())
            ->app($this->app)
            ->guard($this->guard)
            ->properties($this->properties);
    }

    public function save($message = null)
    {
        return activity($this->app)
            ->causedBy(Auth::guard($this->guard)->id())
            ->withProperties($this->properties)
            ->log($message);
    }
}
