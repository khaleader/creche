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
    public $typeCompte;
    public $ecoleNom;
    public $type;
    public $email;
    public $password;
    public $nomResponsable;
    public $sexe;
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
    public function __construct($EcNa,$typ,$eml,$pass,$nomresp,$fix,$port,$adres,$ville,$pays,$typeCompte,$sexe)
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
        $this->typeCompte = $typeCompte;
        $this->sexe = $sexe;

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
        $user->typeCompte = $this->typeCompte;
        $user->sexe = $this->sexe;
        $user->save();
        if($user)
        {
            $info = [
                'nom_resp' => $this->nomResponsable,
                'sexe' => $this->sexe,
                'nom_ecole' =>$this->ecoleNom,
                'email' => $this->email,
                'pass' => $this->password,
                'date' =>$user->created_at
            ];

            Mail::send('emails.school',$info,function($message){

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
