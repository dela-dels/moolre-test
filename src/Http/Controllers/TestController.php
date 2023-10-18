<?php

namespace MoolrePayments\Http\Controllers;

use Pux\Controller;

class TestController extends Controller
{
    public function test(): void
    {
        var_dump('Yo');
    }
}
