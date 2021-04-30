<?php

namespace App\Listeners;

use App\Events\WaitRoom;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class Newstudent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  WaitRoom  $event
     * @return void
     */
    public function handle(WaitRoom $event)
    {
        //
    }
}
