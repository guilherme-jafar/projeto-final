<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuizzQuestion implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $name;
    public $Mainsession;
    public $type;
    public $userId;
    public $quizzArray;

    public function __construct($nName, String $session, String $aType, $aId, $quizz)
    {
        $this->name=$nName;
        $this->Mainsession=$session;
        $this->type=$aType;
        $this->userId=$aId;
        $this->quizzArray=$quizz;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('room.'.$this->Mainsession);
    }
    public function broadcastAs() {
        return 'NewStudent';
    }
}
