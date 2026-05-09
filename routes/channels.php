<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('home.info.{id}', function ($user, $id) {
    return true;
});
