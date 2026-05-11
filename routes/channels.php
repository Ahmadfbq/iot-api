<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('delivery.info.{id}', function ($user, $id) {
    return true;
});
