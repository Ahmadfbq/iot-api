<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'gate_status',
        'package_status',
        'pin',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // I might not need to cast this
    protected function casts(): array
    {
        return [
            'gate_status' => 'string',
            'package_status' => 'string',
            'pin' => 'string',
        ];
    }
}



// The flow of the program api:
// 1. The user sends a GET request to the /api/home endpoint.
// 2. The request is routed to the HomeController's index method.
// 3. The index method returns a JSON response with a welcome message and a success status.
// 4. There is a route that will receive an info from an ESP32 device 'that is acting as a gateway' that there is package that has arrived
// 5. this backend will then generate a 4-digit pin (numbers only) and send it to the same ESP32 device
// 6. this backend will then wait until it receives a message from the ESP32 that the pin has been entered correctly
// 7. and then it will also receive info that are:
//   a- Gate opened
//   b- Package taken
// 8. display those statuses to the user in the frontend (react)