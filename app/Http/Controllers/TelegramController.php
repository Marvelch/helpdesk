<?php

namespace App\Http\Controllers;

use App\Models\Telegram;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SergiX44\Nutgram\Nutgram;

class TelegramController extends Controller
{
    /**
     * Handle the request.
     */
    public function handle(Nutgram $bot)
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Telegram $telegram)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Telegram $telegram)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Telegram $telegram)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Telegram $telegram)
    {
        //
    }

    public function handleWebhook(Request $request)
    {
        // Get the incoming message from Telegram
        $message = $request->input('message');

        // Process the incoming message (you can implement your bot's logic here)
        // For example, you can send a reply back to the user.
        Telegram::sendMessage([
            'chat_id' => $message['chat']['id'],
            'text' => 'Hello, this is your Telegram bot replying!',
        ]);

        // Return a response (Telegram requires a 200 OK response)
        return response()->json(['status' => 'ok']);
    }

}
