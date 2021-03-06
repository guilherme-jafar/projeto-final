<?php

namespace App\Events;

use App\Models\sessao;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use PhpParser\Node\Scalar\String_;

class WaitRoom implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $name;
    public $Mainsession;
    public $type;
    public $userId;



    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($nName, String $session, String $aType, $aId)
    {
        $this->name=$nName;
        $this->Mainsession=$session;
        $this->type=$aType;
        $this->userId=$aId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return  new PrivateChannel('room.'.$this->Mainsession);
    }
    public function broadcastAs() {
        return 'NewStudent';
    }


}
