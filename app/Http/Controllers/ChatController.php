<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class ChatController extends Controller
{
    /**
     * @param Request $request
     * @return string
     */
    public function chatGPT(Request $request): string
    {

        try {
            /** @var array $response */
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . env('OPEN_AI')
            ])->post('https://api.openai.com/v1/chat/completions', [
                "model" => $request->post('model'),
                "messages" => [
                    [
                        "role" => "user",
                        "content" => $request->post('content')
                    ]
                ],
                "temperature" => 0,
                "max_tokens" => 2048
            ])->body();
            return $response['choices'][0]['message']['content'];
        } catch (Throwable $e) {
            return "Chat GPT Limit Reached. You will need to wait, sorry about that.";
        }
    }
}
