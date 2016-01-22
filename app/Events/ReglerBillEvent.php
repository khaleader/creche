<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Mail;

class ReglerBillEvent extends Event
{
    use SerializesModels;
    public $nom_pere;
    public $date_facturation;
    public $nom_enfant;
    public $ref_id;
    public $montant;
    public $school_name;
    public $email;
    public $responsable;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($nompere,$datefact,$nom_enf,$refid,$mont,$ecole_nom,$email,$responsable)
    {
        $this->nom_pere =$nompere;
        $this->date_facturation = $datefact;
        $this->nom_enfant = $nom_enf;
        $this->ref_id = $refid;
        $this->montant = $mont;
        $this->school_name = $ecole_nom;
        $this->email = $email;
        $this->responsable = $responsable;


        $info = [
            'resp' => $this->nom_pere,
            'date' => $this->date_facturation,
            'nom_enfant' => $this->nom_enfant,
            'ref' => $this->ref_id,
            'somme' => $this->montant,
            'ecole_name' => $this->school_name,
            'email' => $this->email,
            'responsable' => $this->responsable
        ];

        Mail::queue('emails.reglement',$info,function($message){

            $message->to($this->email,'ok')->from('creche@gmail.com')->subject('Bienvenue  !');

        });


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
