<?php

namespace App\Events;

use App\Bill;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BillEvent extends Event
{
    use SerializesModels;
/*
 *         $bill = new Bill();
                    $bill->start = Carbon::now()->toDateString();
                    $bill->end = Carbon::now()->addMonth()->toDateString();
                    $bill->status = 0;
                    $bill->somme = CategoryBill::getYear(Carbon::parse($request->date_naissance));
                    $bill->child_id = $child->id;
                    $bill->user_id = \Auth::user()->id;
                    $bill->save();
 *
 * */
    public $start;
    public $end;
    public $status;
    public $somme;
    public $child_id;
    public  $user_id;

    /**
     * Create a new event instance.
     *
     * @param $start
     * @param $end
     * @param $status
     * @param $somme
     * @param $child_id
     * @param $user_id
     */
    public function __construct($start,$end,$status,$somme,$child_id,$user_id)
    {

        $this->start = $start;
        $this->end = $end;
        $this->status = $status;
        $this->somme = $somme;
        $this->child_id = $child_id;
        $this->user_id = $user_id;
        $bill = new Bill();
        $bill->start = $this->start;
        $bill->end = $this->end;
        $bill->status = intval($this->status);
        $bill->somme = $this->somme;
        $bill->child_id = $this->child_id;
        $bill->user_id = $this->user_id;
        $bill->save();



    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
