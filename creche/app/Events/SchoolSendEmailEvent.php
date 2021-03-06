<?php

namespace App\Events;

use App\Events\Event;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Mail;

class SchoolSendEmailEvent extends Event
{
    use SerializesModels;

    public $ecoleNom;
    public $type;
    public $email;
    public $password;
    public $nomResponsable;
    public $fix;
    public $portab;
    public $adresse;
    public $ville;
    public $pays;



    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($EcNa,$typ,$eml,$pass,$nomresp,$fix,$port,$adres,$ville,$pays)
    {
        $this->ecoleNom = $EcNa;
        $this->type = $typ;
        $this->email = $eml;
        $this->password = $pass;
        $this->nomResponsable = $nomresp;
        $this->fix = $fix;
        $this->portab = $port;
        $this->adresse = $adres;
        $this->ville = $ville;
        $this->pays = $pays;

        $user = new User();
        $user->name = $this->ecoleNom;
        $user->type = $this->type;
        $user->email = $this->email;
        $user->password = \Hash::make($this->password);
        $user->nom_responsable = $this->nomResponsable;
        $user->tel_fixe = $this->fix;
        $user->tel_portable = $this->portab;
        $user->adresse = $this->adresse;
        $user->ville = $this->ville;
        $user->pays = $this->pays;
        $user->save();
        if($user)
        {
            $info = [
                'nom_resp' => $this->nomResponsable,
                'nom_ecole' =>$this->ecoleNom,
                'email' => $this->email,
                'pass' => $this->password
            ];

            Mail::queue('emails.school',$info,function($message){

                $message->to($this->email,'ok')->from('creche@gmail.com')->subject('Bienvenue  !');

            });
        }



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
