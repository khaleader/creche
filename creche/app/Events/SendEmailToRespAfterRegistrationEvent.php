<?php

namespace App\Events;

use App\Child;
use App\Events\Event;
use App\User;
use Artisan;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Mail;

class SendEmailToRespAfterRegistrationEvent extends Event
{
    use SerializesModels;

    public $child_id;
    public $nom_enfant;
    public $date_inscription;
    public $date_prochain_paiement;
    public $pseudo_compte_famille;
    public $mot_de_pass_temporaire_compte_famille;
    public $nom_responsable;




    /*
    Le nom de l’enfant
    La date d’inscription
    La date du prochain paiement ( date d’inscription + un mois )
    Pseudo du compte famille
    Mot de passe temporaire du compte famille
 *  Lien de l'interface de connexion
     *
     *
     * */


    /**
     * Create a new event instance.
     *
     * @param $nom_responsable
     * @param $nom_enfant
     * @param $date_inscription
     * @param $date_prochain_paiement
     * @param $pseudo_compte_famille
     * @param $mot_de_pass_temporaire_compte_famille
     */
    public function __construct($c_id,$nom_responsable,$nom_enfant,$date_inscription,$date_prochain_paiement,$pseudo_compte_famille,$mot_de_pass_temporaire_compte_famille)
    {
        $this->child_id = $c_id;
        $this->nom_responsable = $nom_responsable;
        $this->nom_enfant = $nom_enfant;
        $this->date_inscription = $date_inscription;
        $this->date_prochain_paiement = $date_prochain_paiement;
        $this->pseudo_compte_famille = $pseudo_compte_famille;
        $this->mot_de_pass_temporaire_compte_famille = $mot_de_pass_temporaire_compte_famille;

        $user = new User();
        $user->nom_responsable = $this->nom_responsable;
        $user->name = \Auth::user()->name;
        $user->type = 'famille';
        $user->email = $this->pseudo_compte_famille;
        $user->password = \Hash::make($this->mot_de_pass_temporaire_compte_famille);
        $user->save();
        if($user)
        {
           $child = Child::findOrFail($this->child_id);
            $child->f_id =$user->id;
            $child->save();
                $info = [
                    'responsable' => $this->nom_responsable,
                    'nom_enfant' => $this->nom_enfant,
                    'date_inscription' => $this->date_inscription,
                    'date_pro_paim' => $this->date_prochain_paiement,
                    'pseudo_email' => $this->pseudo_compte_famille,
                    'pass' => $this->mot_de_pass_temporaire_compte_famille
                ];

                Mail::queue('emails.test',$info,function($message){

                    $message->to($this->pseudo_compte_famille,'ok')->from('creche@gmail.com')->subject('Bienvenue  !');

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
