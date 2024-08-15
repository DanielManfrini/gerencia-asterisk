<?php

namespace App\Http\Controllers\Mensageiro;

use App\Http\Controllers\Controller;
use App\Services\Mensageiro\RabbitMQService;
use Illuminate\Http\Request;

class RabbitMQController extends Controller
{
    protected $rabbitMQService;

    public function __construct(RabbitMQService $rabbitMQService)
    {
        $this->rabbitMQService = $rabbitMQService;
    }

    public function send(Request $request)
    {
        $queue = 'servico-asterisk';
        $message = $request->input('message');

        $this->rabbitMQService->send($queue, $message);

        return response()->json(['message' => 'Message sent successfully!']);
    }
}
