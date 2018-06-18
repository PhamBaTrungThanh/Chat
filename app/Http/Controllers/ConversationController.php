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
        $latest = auth()->user()->conversations()->has("messages")->latest("updated_at")->count();
        if ($latest) {
            return redirect()->route("conversation.show", $latest);
        }
        else {
            return view("conversation.index");
        }

    }
    public function showSidebar(Conversation $conversation)
    {
        $related = Conversation::latest("updated_at")
            ->limit(10)
            ->with(["latestMessage", "latestMessage.user"])->get();
        return view("conversation.sidebar")->withRelated($related)->withConversation($conversation);            
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

    public function message(Conversation $conversation, Request $request)
    {
        if ($conversation->users()->where("id", auth()->user()->id)) {
            $body = clean($request->message, array("HTML.Allowed" => "br"));
            $message = new Message;

            $message->fill([
                "body" => $body,
                "conversation_id" => $conversation->id,
                "user_id" => auth()->user()->id,
                "name" => "",
            ]);
            $message->save();
            //$conversation->notify(new ConversationUpdated($message, auth()->user()));
            Notification::send($conversation->toOthers(), new MessagePosted($conversation, $body, auth()->user()));
        } else {
            abort(401);
        }
    }
}
