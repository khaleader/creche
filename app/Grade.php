<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{





    public function levels()
    {
        return $this->hasMany(Level::class);
    }

    // only for creche
    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class);
    }


    public static function AddGradesAndLevels($user_id)
    {
         $admin = User::where('id',$user_id)->where('type','ecole')->first();
        if($admin)
        {
        $grade =  Grade::where('user_id',$user_id)->first();
        if(!$grade)
        {
            $creche = new Grade();
            $creche->name = 'Crèche';
            $creche->user_id = $user_id;
            $creche->save();

            if($creche->id)
            {
                $niveau = new Level();
                $niveau->niveau ='Crèche';
                $niveau->user_id = $user_id;
                $niveau->grade_id = $creche->id;
                $niveau->save();
            }

            $mater = new Grade();
            $mater->name = 'Maternelle';
            $mater->user_id = $user_id;
            $mater->save();
            if($mater)
            {
                        $niveau = new Level();
                        $niveau->niveau ='Petite Section';
                        $niveau->user_id = $user_id;
                        $niveau->grade_id = $mater->id;
                        $niveau->save();

                        $niveau = new Level();
                        $niveau->niveau = 'Moyenne Section';
                        $niveau->user_id = $user_id;
                        $niveau->grade_id = $mater->id;
                        $niveau->save();

                        $niveau = new Level();
                        $niveau->niveau = 'Grande Section';
                        $niveau->user_id = $user_id;
                        $niveau->grade_id = $mater->id;
                        $niveau->save();

            }

            $sc = new Grade();
            $sc->name = 'Primaire';
            $sc->user_id = $user_id;
            $sc->save();
            if($sc)
            {
                for($i=1;$i<=6;$i++)
                {

                        $niveau = new Level();
                        $niveau->niveau = 'CE'.$i;
                        $niveau->user_id = $user_id;
                        $niveau->grade_id = $sc->id;
                        $niveau->save();


                }
            }

            $col = new Grade();
            $col->name = 'Collège';
            $col->user_id = $user_id;
            $col->save();
            if($col)
            {

                for($i=1;$i<=3;$i++)
                {
                    if($i == 1)
                    {
                        $niveau = new Level();
                        $niveau->niveau ='1ère année Collège';
                        $niveau->user_id = $user_id;
                        $niveau->grade_id = $col->id;
                        $niveau->save();
                    }elseif($i > 1){
                        $niveau = new Level();
                        $niveau->niveau = $i.'ème année Collège';
                        $niveau->user_id = $user_id;
                        $niveau->grade_id = $col->id;
                        $niveau->save();
                    }

                }
            }





            $lyc = new Grade();
            $lyc->name = 'Lycée';
            $lyc->user_id = $user_id;
            $lyc->save();
            if($lyc)
            {
                $niveau = new Level();
                $niveau->niveau ='Tronc Commun';
                $niveau->user_id = $user_id;
                $niveau->grade_id = $lyc->id;
                $niveau->save();
                if($niveau->id)
                {
                   $l = Level::where('niveau',$niveau->niveau)->where('user_id',$user_id)->first();
                    $branchesTc = [
                        'Tronc Commun Sciences',
                        'Tronc Commun Lettres et sciences humaines',
                        'Tronc Commun Technologique',
                        'Tronc Commun Enseignement Originel',
                    ];
                    foreach($branchesTc as $br)
                    {
                        $branche = new Branch();
                        $branche->nom_branche = $br;
                        $branche->code_branche = "";
                        $branche->user_id = $user_id;
                        $branche->save();
                        if($branche->id)
                        {
                            $l->onbranches()->attach([$branche->id]);
                        }
                    }
                }


                $niveau = new Level();
                $niveau->niveau = '1ère Baccalauréat';
                $niveau->user_id = $user_id;
                $niveau->grade_id = $lyc->id;
                $niveau->save();
                if($niveau->id)
                {
                    $l = Level::where('niveau',$niveau->niveau)->where('user_id',$user_id)->first();
                    $branches1Bac = [
                        'Sciences mathématiques',
                        'Sciences expérimentales',
                        'Bac Sciences et Technologies Electriques',
                        'Bac Sciences et Technologies Mecaniques',
                        'Arts appliqués',
                        'Sciences économiques et gestion',
                        'Lettres et sciences humaines',
                        'Langue Arabe',
                        'Sciences de la Chariaa'
                    ];
                    foreach($branches1Bac as $br)
                    {
                        $branche = new Branch();
                        $branche->nom_branche = $br;
                        $branche->code_branche = "";
                        $branche->user_id = $user_id;
                        $branche->save();
                        if($branche->id)
                        {
                            $l->onbranches()->attach([$branche->id]);
                        }
                    }
                }



                $niveau = new Level();
                $niveau->niveau = 'Baccalaureat';
                $niveau->user_id = $user_id;
                $niveau->grade_id = $lyc->id;
                $niveau->save();
                if($niveau->id)
                {
                    $l = Level::where('niveau',$niveau->niveau)->where('user_id',$user_id)->first();
                    $branchesBac = [
                        'Bac Sciences mathématiques A',
                        'Bac Sciences Mathématiques B',
                        'Bac Sciences Physiques',
                        'SVT Bac',
                        'Bac Sciences Agronomiques',
                        'Bac Sciences et Technologies Electriques',
                        'Bac Sciences et Technologies Mecaniques',
                        'Arts appliqués',
                        'Bac Sciences économiques',
                        'Bac Techniques de gestion et comptabilité',
                        'Bac Lettres',
                        'Sciences humaines',
                        'Langue Arabe',
                        'Sciences de la Chariaa'

                    ];
                    foreach($branchesBac as $br)
                    {
                        $branche = new Branch();
                        $branche->nom_branche = $br;
                        $branche->code_branche = "";
                        $branche->user_id = $user_id;
                        $branche->save();
                        if($branche->id)
                        {
                            $l->onbranches()->attach([$branche->id]);
                        }
                    }
                }




            }

            }
        }








    }
}
