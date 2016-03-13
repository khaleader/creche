<?php

namespace App\Events;
use App\Profile;
use App\Bill;
use App\Branch;
use App\CategoryBill;
use App\Child;
use App\Classroom;
use App\Events\Event;
use App\Family;
use App\Level;
use App\Matter;
use App\Room;
use App\Teacher;
use App\Timesheet;
use App\Transport;
use App\User;
use Carbon\Carbon;
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

           $profile = Profile::where('user_id',$user->id)->first();
            if(!$profile)
            {
                $pr = new Profile();
                $pr->user_id = $user->id;
                $pr->save();
            }
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


        /*else {
            $user->save();
              //  sending email
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

              //   Sending Email




                for ($i = 1; $i <= 4; $i++) {
                    $cb = new CategoryBill();
                    $cb->name = $i;
                    switch ($i) {
                        case $i == 1:
                            $cb->age_de = 0;
                            $cb->age_a = 5;
                            $cb->prix = 200;
                            $cb->user_id = $user->id;
                            $cb->save();
                            break;
                        case $i == 2:
                            $cb->age_de = 6;
                            $cb->age_a = 10;
                            $cb->prix = 300;
                            $cb->user_id = $user->id;
                            $cb->save();
                            break;
                        case $i == 3:
                            $cb->age_de = 11;
                            $cb->age_a = 15;
                            $cb->prix = 400;
                            $cb->user_id = $user->id;
                            $cb->save();
                            break;
                        case $i == 4:
                            $cb->age_de = 16;
                            $cb->age_a = 20;
                            $cb->prix = 500;
                            $cb->user_id = $user->id;
                            $cb->save();
                            break;
                    }
                } //end for CategoryBill Model
                $tr = new Transport();
                $tr->somme = 200;
                $tr->user_id = $user->id;
                $tr->save();

                for ($i = 1; $i <= 2; $i++) {
                    $lv = new Level();
                    $lv->niveau = ($i == 1)? 'première année bac' :'deuxième année bac';
                    $lv->user_id = $user->id;
                    $lv->save();
                }

                //salles
                for ($i = 1; $i <= 2; $i++) {
                    $room = new Room();
                    $room->nom_salle = 'salle '.$i;
                    $room->capacite_salle = 30;
                    $room->user_id = $user->id;
                    $room->color = 'black';
                    $room->save();
                }

                // matieres
                for ($i = 1; $i <= 4; $i++)
                {
                    switch($i)
                    {
                        case $i == 1:
                            $matter = new Matter();
                            $matter->nom_matiere ='Francais';
                            $matter->code_matiere = 'Fr';
                            $matter->color = 'blue';
                            $matter->user_id = $user->id;
                            $matter->save();

                            //teacher
                            $teacher = new Teacher();
                            $teacher->nom_teacher = 'Iliass omar';
                            $teacher->date_naissance = '1980-11-11';
                            $teacher->poste = Matter::where('user_id',$user->id)->where('code_matiere','Fr')->first()->nom_matiere;
                            $teacher->fonction = 'Professeur';
                            $teacher->sexe = 'Homme';
                            $teacher->email = 'NoEmail-'.str_random(4).'@gmail.com';
                            $teacher->num_fix = '0212444578';
                            $teacher->num_portable = '0666145847';
                            $teacher->adresse = 'No Adresse for the moment';
                            $teacher->cin = str_random(6);
                            $teacher->salaire = 5000;
                            $teacher->user_id =  $user->id;
                            $teacher->save();
                            if($teacher)
                            {
                                $teacher->matters()->attach([$matter->id]);
                            };
                            break;
                        case $i == 2:
                            $matter = new Matter();
                            $matter->nom_matiere ='Math';
                            $matter->code_matiere = 'Mt';
                            $matter->color = '#e2641b';
                            $matter->user_id = $user->id;
                            $matter->save();
                            //teacher
                            $teacher = new Teacher();
                            $teacher->nom_teacher = 'anass fouad';
                            $teacher->date_naissance = '1980-11-11';
                            $teacher->poste = Matter::where('user_id',$user->id)->where('code_matiere','Mt')->first()->nom_matiere;
                            $teacher->fonction = 'Professeur';
                            $teacher->sexe = 'Homme';
                            $teacher->email = 'NoEmail-'.str_random(4).'@gmail.com';
                            $teacher->num_fix = '0212444578';
                            $teacher->num_portable = '0666145847';
                            $teacher->adresse = 'No Adresse for the moment';
                            $teacher->cin = str_random(6);
                            $teacher->salaire = 5000;
                            $teacher->user_id =  $user->id;
                            $teacher->save();
                            if($teacher)
                            {
                                $teacher->matters()->attach([$matter->id]);
                            };

                            break;
                        case $i == 3:
                            $matter = new Matter();
                            $matter->nom_matiere ='Anglais';
                            $matter->code_matiere = 'Ang';
                            $matter->color = '#687B8C';
                            $matter->user_id = $user->id;
                            $matter->save();
                            //teacher
                            $teacher = new Teacher();
                            $teacher->nom_teacher = 'Wael belekbir';
                            $teacher->date_naissance = '1980-11-11';
                            $teacher->poste = Matter::where('user_id',$user->id)->where('code_matiere','Ang')->first()->nom_matiere;
                            $teacher->fonction = 'Professeur';
                            $teacher->sexe = 'Homme';
                            $teacher->email = 'NoEmail-'.str_random(4).'@gmail.com';
                            $teacher->num_fix = '0212444578';
                            $teacher->num_portable = '0666145847';
                            $teacher->adresse = 'No Adresse for the moment';
                            $teacher->cin = str_random(6);
                            $teacher->salaire = 5000;
                            $teacher->user_id =  $user->id;
                            $teacher->save();
                            if($teacher)
                            {
                                $teacher->matters()->attach([$matter->id]);
                            };
                            break;
                        case $i == 4:
                            $matter = new Matter();
                            $matter->nom_matiere ='Histoire';
                            $matter->code_matiere = 'Hst';
                            $matter->color = '#7F64B5';
                            $matter->user_id = $user->id;
                            $matter->save();

                            //teacher
                            $teacher = new Teacher();
                            $teacher->nom_teacher = 'Achraf el fouhami';
                            $teacher->date_naissance = '1980-11-11';
                            $teacher->poste = Matter::where('user_id',$user->id)->where('code_matiere','Hst')->first()->nom_matiere;
                            $teacher->fonction = 'professeur';
                            $teacher->sexe = 'Homme';
                            $teacher->email = 'NoEmail-'.str_random(4).'@gmail.com';
                            $teacher->num_fix = '0212444578';
                            $teacher->num_portable = '0666145847';
                            $teacher->adresse = 'No Adresse for the moment';
                            $teacher->cin = str_random(6);
                            $teacher->salaire = 5000;
                            $teacher->user_id =  $user->id;
                            $teacher->save();
                            if($teacher)
                            {
                                $teacher->matters()->attach([$matter->id]);
                            };

                            break;
                    }
                }


                // classrooms
                for ($i = 1; $i <= 2; $i++) {
                    $cr = new Classroom();
                    $cr->nom_classe = 'classe '.$i;
                    $cr->code_classe = 'cl'.$i;
                    $cr->capacite_classe = 30;
                    $cr->niveau = ($i == 1 ) ?'première année bac' : 'Deuxième année bac';
                    $cr->branche = ($i == 1) ? 'Littéraire' : 'Sciences';
                    $cr->user_id = $user->id;
                    $cr->save();
                    if($cr)
                    {
                            $classe =  Classroom::where('user_id',$user->id)->where('code_classe','cl'.$i)->first();
                          if($i == 1)
                          {
                              $classe->matters()->attach([Matter::where('user_id',$user->id)->where('code_matiere','Fr')->first()->id]);
                          }else{
                              $classe->matters()->attach([Matter::where('user_id',$user->id)->where('code_matiere','Ang')->first()->id]);
                          }


                    }



                    $ts = new Timesheet();
                    $ts->user_id = $user->id;
                    $ts->classroom_id  = $cr->id;
                    $ts->save();
                }
                // branches
                for ($i = 1; $i <= 2; $i++) {
                    $br = new Branch();
                    $br->nom_branche =  ($i == 1 ) ? 'Littéraire': 'Sciences';
                    $br->code_branche = ($i == 1) ? 'LT': 'Sc';
                    $br->user_id = $user->id;
                    $br->save();
                }






                $peres = ['Yassine bennani', 'Kamal El alami', 'Fouad taqi', 'Omar el mesoudi'];
                $meres = ['Fatine nour', 'imane safi', 'widad fathi', 'yasmine amara'];
                $eleves = ['walid bennani', 'wael El alami', 'achraf taqi', 'nassim el mesoudi'];
                $adress = [
                    '14 Kildeer Avenue PARIS FRANCE',
                    '147 Lightning Street LONDON UK',
                    '164 Reel Place DORTMUND GERMANY',
                    '875 Clark Lake SIDNEY AUSTRALIA'
                ];
                $phonesp = ['0214125124', '0215452214', '0218445144', '03412541254'];
                $phonesf = ['01454545554', '02315454545', '0645412151', '0214541145'];
                $cin = ['ab114477', 'an475965', 'nb112354', 'ui786519'];
                $dates = ['2000-02-02', '2005-02-01', '2010-02-03', '2014-01-05'];
                $sexe = ['Garçon', 'fille'];

                for ($i = 0; $i <= 3; $i++) {
                    switch ($i) {
                        case $i == 0:
                            $family = new Family();
                            $family->nom_pere = $peres[$i];
                            $family->nom_mere = $meres[$i];
                            $family->email_responsable = 'NoEmailinEssaiAccount-' .str_random(4).$i.str_random(2).'@gmail.com';
                            $family->adresse = $adress[$i];
                            $family->numero_fixe = $phonesf[$i];
                            $family->numero_portable = $phonesp[$i];
                            $family->cin = strtoupper(str_random(6));
                            $family->responsable = 1;
                            $family->user_id = $user->id;
                            $family->save();
                            // compte famille user
                            $f = new User();
                            $f->nom_responsable = $family->nom_pere;
                            $f->name = $user->name;
                            $f->type = 'famille';
                            $f->email = $family->email_responsable;
                            $f->password = \Hash::make('123456');
                            $f->sexe = 'homme';
                            $f->save();



                            if ($family->id) {
                                $child = new Child();
                                $child->date_naissance = Carbon::parse($dates[$i]);
                                $child->transport = 0;
                                $child->sexe = $sexe[0];


                                $child->nom_enfant = ucfirst($eleves[$i]);
                                $child->age_enfant = $child->date_naissance->diffInYears(Carbon::now());
                                $child->user_id = $user->id;


                                $child->photo = '';
                                $child->family_id = $family->id;
                                $child->save();

                                if ($child->id) {
                                    //classe
                                    $cr = Classroom::where('user_id',$user->id)->where('code_classe', 'cl1')->first();
                                    $cr->children()->attach([$child->id]);
                                    $bill = new Bill();
                                    $bill->start = Carbon::now()->toDateString();
                                    $bill->end = Carbon::now()->addMonth()->toDateString();
                                    $bill->status = 0;
                                    $bill->somme = CategoryBill::getYearFoEssai($user,Carbon::parse($child->date_naissance));

                                    $bill->child_id = $child->id;
                                    $bill->user_id = $user->id;
                                    $bill->save();

                                    if($f)
                                    {
                                        $enf = Child::findOrFail($child->id);
                                        $enf->f_id =$f->id;
                                        $enf->save();
                                        $b =  Bill::where('child_id',$enf->id)->first();
                                        $b->f_id = $f->id;
                                        $b->save();
                                    }

                                }
                            };
                             break;
                        case $i == 1:
                            $family = new Family();
                            $family->nom_pere = $peres[$i];
                            $family->nom_mere = $meres[$i];
                            $family->email_responsable = 'NoEmailinEssaiAccount-' .str_random(4).$i.str_random(2).'@gmail.com';
                            $family->adresse = $adress[$i];
                            $family->numero_fixe = $phonesf[$i];
                            $family->numero_portable = $phonesp[$i];
                            $family->cin = strtoupper(str_random(6));
                            $family->responsable = 1;
                            $family->user_id = $user->id;
                            $family->save();
                            // compte famille user
                            $f = new User();
                            $f->nom_responsable = $family->nom_pere;
                            $f->name = $user->name;
                            $f->type = 'famille';
                            $f->email = $family->email_responsable;
                            $f->password = \Hash::make('123456');
                            $f->sexe = 'homme';
                            $f->save();



                            if ($family->id) {
                                $child = new Child();
                                $child->date_naissance = Carbon::parse($dates[$i]);
                                $child->transport = 0;
                                $child->sexe = $sexe[0];


                                $child->nom_enfant = ucfirst($eleves[$i]);
                                $child->age_enfant = $child->date_naissance->diffInYears(Carbon::now());
                                $child->user_id = $user->id;


                                $child->photo = '';
                                $child->family_id = $family->id;
                                $child->save();



                                if ($child->id) {
                                    //classe
                                    $cr = Classroom::where('user_id',$user->id)->where('code_classe','cl1')->first();
                                    $cr->children()->attach([$child->id]);
                                    $bill = new Bill();
                                    $bill->start = Carbon::now()->toDateString();
                                    $bill->end = Carbon::now()->addMonth()->toDateString();
                                    $bill->status = 0;
                                    $bill->somme = CategoryBill::getYearFoEssai($user,Carbon::parse($child->date_naissance));

                                    $bill->child_id = $child->id;
                                    $bill->user_id = $user->id;
                                    $bill->save();

                                    if($f)
                                    {
                                        $enf = Child::findOrFail($child->id);
                                        $enf->f_id =$f->id;
                                        $enf->save();
                                        $b =  Bill::where('child_id',$enf->id)->first();
                                        $b->f_id = $f->id;
                                        $b->save();
                                    }


                                }
                            };
                            break;
                        case $i == 2:
                            $family = new Family();
                            $family->nom_pere = $peres[$i];
                            $family->nom_mere = $meres[$i];
                            $family->email_responsable = 'NoEmailinEssaiAccount-' .str_random(4).$i.str_random(2).'@gmail.com';
                            $family->adresse = $adress[$i];
                            $family->numero_fixe = $phonesf[$i];
                            $family->numero_portable = $phonesp[$i];
                            $family->cin = strtoupper(str_random(6));
                            $family->responsable = 1;
                            $family->user_id = $user->id;
                            $family->save();

                            $f = new User();
                            $f->nom_responsable = $family->nom_pere;
                            $f->name = $user->name;
                            $f->type = 'famille';
                            $f->email = $family->email_responsable;
                            $f->password = \Hash::make('123456');
                            $f->sexe = 'homme';
                            $f->save();

                            if ($family->id) {
                                $child = new Child();
                                $child->date_naissance = Carbon::parse($dates[$i]);
                                $child->transport = 0;
                                $child->sexe = $sexe[0];


                                $child->nom_enfant = ucfirst($eleves[$i]);
                                $child->age_enfant = $child->date_naissance->diffInYears(Carbon::now());
                                $child->user_id = $user->id;


                                $child->photo = '';
                                $child->family_id = $family->id;
                                $child->save();




                                if ($child->id) {
                                    //classe
                                    $cr = Classroom::where('user_id',$user->id)->where('code_classe','cl2')->first();
                                    $cr->children()->attach([$child->id]);
                                    $bill = new Bill();
                                    $bill->start = Carbon::now()->toDateString();
                                    $bill->end = Carbon::now()->addMonth()->toDateString();
                                    $bill->status = 0;
                                    $bill->somme = CategoryBill::getYearFoEssai($user,Carbon::parse($child->date_naissance));

                                    $bill->child_id = $child->id;
                                    $bill->user_id = $user->id;
                                    $bill->save();
                                    if($f)
                                    {
                                        $enf = Child::findOrFail($child->id);
                                        $enf->f_id =$f->id;
                                        $enf->save();
                                        $b =  Bill::where('child_id',$enf->id)->first();
                                        $b->f_id = $f->id;
                                        $b->save();
                                    }


                                }
                            };
                            break;
                        case $i == 3:
                            $family = new Family();
                            $family->nom_pere = $peres[$i];
                            $family->nom_mere = $meres[$i];
                            $family->email_responsable = 'NoEmailinEssaiAccount-' .str_random(4).$i.str_random(2).'@gmail.com';
                            $family->adresse = $adress[$i];
                            $family->numero_fixe = $phonesf[$i];
                            $family->numero_portable = $phonesp[$i];
                            $family->cin = strtoupper(str_random(6));
                            $family->responsable = 1;
                            $family->user_id = $user->id;
                            $family->save();
                            $f = new User();
                            $f->nom_responsable = $family->nom_pere;
                            $f->name = $user->name;
                            $f->type = 'famille';
                            $f->email = $family->email_responsable;
                            $f->password = \Hash::make('123456');
                            $f->sexe = 'homme';
                            $f->save();

                            if ($family->id) {
                                $child = new Child();
                                $child->date_naissance = Carbon::parse($dates[$i]);
                                $child->transport = 0;
                                $child->sexe = $sexe[0];


                                $child->nom_enfant = ucfirst($eleves[$i]);
                                $child->age_enfant = $child->date_naissance->diffInYears(Carbon::now());
                                $child->user_id = $user->id;


                                $child->photo = '';
                                $child->family_id = $family->id;
                                $child->save();



                                if ($child->id) {
                                    //classe
                                    $cr = Classroom::where('user_id',$user->id)->where('code_classe', 'cl2')->first();
                                    $cr->children()->attach([$child->id]);
                                    $bill = new Bill();
                                    $bill->start = Carbon::now()->toDateString();
                                    $bill->end = Carbon::now()->addMonth()->toDateString();
                                    $bill->status = 0;
                                    $bill->somme = CategoryBill::getYearFoEssai($user,Carbon::parse($child->date_naissance));

                                    $bill->child_id = $child->id;
                                    $bill->user_id = $user->id;
                                    $bill->save();
                                    if($f)
                                    {
                                        $enf = Child::findOrFail($child->id);
                                        $enf->f_id =$f->id;
                                        $enf->save();
                                        $b =  Bill::where('child_id',$enf->id)->first();
                                        $b->f_id = $f->id;
                                        $b->save();
                                    }

                                }
                            };
                            break;

                    }
                }



                } */


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
