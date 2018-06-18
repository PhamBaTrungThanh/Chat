<?php

namespace App\Http\Controllers;

use App\Notifications\MessagePosted;
use App\Notifications\ConversationUpdated;
use App\Models\Conversation;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ConversationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $latest = auth()->user()->conversations()->latest("updated_at")->first();
        return redirect()->route("conversation.show", $latest);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function with(User $friend)
    {
        $conversation = Conversation::Single([auth()->user()->id, $friend->id])->first();
        if (!$conversation) {
            $conversation = new Conversation;
            $conversation->type = "single";
            $conversation->save();
            $conversation->users()->attach([auth()->user()->id, $friend->id]);
        }
        return redirect()->route("conversation.show", $conversation);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation)
    {
        $related = Conversation::latest("updated_at")
            ->limit(10)
            ->with(["latestMessage", "latestMessage.user"])->get();
        $messages = Message::where("conversation_id", $conversation->id)->limit(50)->oldest()->get();
        return view("conversation.show")->withConversation($conversation)->withMessages($messages)->withRelated($related);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function edit(Conversation $conversation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conversation $conversation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversation $conversation)
    {
        //
    }
    public function message(Conversation $conversation, Request $request)
    {
        if ($conversation->users()->where("id", auth()->user()->id)) {
            $message = new Message;
            $message->fill([
                "body" => clean($request->message, array("HTML.Allowed" => "br")),
                "conversation_id" => $conversation->id,
                "user_id" => auth()->user()->id,
            ]);
            $message->save();
            //$conversation->notify(new ConversationUpdated($message, auth()->user()));
            Notification::send($conversation->toOthers(), new MessagePosted($message, auth()->user()));
        } else {
            abort(401);
        }
    }
}
