<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{

protected $dates = ['startch1','endch1','startch2','endch2','startch3','endch3'];




    public function bills()
    {
        return $this->hasMany(Bill::class);
    }


    public static function countTotalYear()
    {
        $duree = \Auth::user()->schoolyears()->where('current',1)->first();
        if($duree)
        {
            if($duree->type == 'Semis')
            {

                $total =  $duree->startch1->diffInMonths($duree->endch2) + 1;
            }
            if($duree->type == 'Trim')
            {
                $total =  $duree->startch1->diffInMonths($duree->endch3) + 1;
            }
            return $total;
        }
    }


    public static function checkNextMonth()
    {
        if (\Auth::user()->isAdmin()) {
        $aboutfacture = '';
        //  $check =  \Auth::user()->created_at->addMinutes(10);
        $next_month = Carbon::now()->firstOfMonth()->addMonth()->toDateString();
        $ok = \Auth::user()->schoolyears()->where('current', 1)->first();
        if ($ok) {
            if ($ok->type == 'Trim') {
                if (Carbon::parse($next_month)->between($ok->startch1, $ok->endch3) && Carbon::now()->month <= 5) {
                    $aboutfacture = 'yes';
                } else {
                    $aboutfacture = 'no';
                }
                return $aboutfacture;
            }
            if ($ok->type == 'Semis') {
                if (Carbon::parse($next_month)->between($ok->startch1, $ok->endch2) && Carbon::now()->month <= 5) {
                    $aboutfacture = 'yes';
                } else {
                    $aboutfacture = 'no';
                }
                return $aboutfacture;
            }
        }
    }
    }


    public static function getSchoolYearId()
    {
        $sc = \Auth::user()->schoolyears()->where('current',1)->first();
        if($sc)
        {
            return $sc->id;
        }
    }



    public static function getFirstYear()
    {
       $year1 = \Auth::user()->schoolyears()->where('current',1)->first();
        $year1 = explode('-',$year1->ann_scol);
        return $year1[0];
    }
    public static function getSecondYear()
    {
        $year2 = \Auth::user()->schoolyears()->where('current',1)->first();
        $year2 = explode('-',$year2->ann_scol);
        return $year2[1];
    }


    public function priceBills()
    {
        return $this->hasMany(PriceBill::class);
    }
    public function levels()
    {
        return $this->hasMany(Level::class);
    }




}
