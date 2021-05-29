<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnswerQuestionStudent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $name;
    public $Mainsession;
    public $type;
    public $userId;
    public $points;
    public $answer;
    public $tipo;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($aName,$aMainSession,$aType,$aUserId,$aPoints,$aAnswer,$aTipo)
    {
        $this->name=$aName;
        $this->Mainsession=$aMainSession;
        $this->type=$aType;
        $this->userId=$aUserId;
        $this->points=$aPoints;
        $this->answer=$aAnswer;
        $this->tipo=$aTipo;
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
