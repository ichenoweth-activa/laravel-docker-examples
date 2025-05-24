<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class FaqsController extends Controller
{

    public function __invoke(){
        //name('faqs.index')
        return Inertia::render('Faqs/Index');
    }
}
