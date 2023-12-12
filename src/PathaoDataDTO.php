<?php

namespace Enan\PathaoCourier;


class PathaoBaseAPI
{
    public ?string  $key_id = null;
    public ?string  $type;
    public ?string  $attachment;
    public ?string  $name;
    public ?string  $mime_type = null;
    public ?string  $public_link = null;

    public function fromRequest(): static
    {
        return $this;
    }
}
