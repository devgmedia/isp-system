<?php

namespace Gmedia\IspSystem\Facades;

use Illuminate\Support\Facades\Auth;

class Log
{
    private $app = null;

    private $guard = 'api';

    private $properties = null;

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
        $this->properties = $properties;

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
