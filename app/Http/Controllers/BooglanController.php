<?php

namespace App\Http\Controllers;
use App\Booglan;

class BooglanController extends Controller
{
    public function first(?Booglan $booglan = null)
    {
        $booglan = ($booglan) ? $booglan : Booglan::find(2);
        return response()->json(['answer' => $booglan->firstQuestion()], 200);
    }

    public function second(?Booglan $booglan = null)
    {
        $booglan = ($booglan) ? $booglan : Booglan::find(2);
        return response()->json(['answer' => $booglan->secondQuestion()], 200);
    }

    public function third(?Booglan $booglan = null)
    {
        $booglan = ($booglan) ? $booglan : Booglan::find(2);
        return response()->json(['answer' => $booglan->thirdQuestion()], 200);
    }

    public function fourth(?Booglan $booglan = null)
    {
        $booglan = ($booglan) ? $booglan : Booglan::find(1);
        return response()->json(['answer' => $booglan->fourthQuestion()], 200);
    }

    public function fifth(?Booglan $booglan = null)
    {
        $booglan = ($booglan) ? $booglan : Booglan::find(2);
        return response()->json(['answer' => $booglan->fifthQuestion()], 200);
    }
}
