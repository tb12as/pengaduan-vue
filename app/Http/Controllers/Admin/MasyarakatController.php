<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MasyarakatController extends Controller
{
    public function count()
    {
    	return User::whereHas('roles', function($q) {
    		$q->where('name', 'masyarakat');
    	})
    	->count();
    }
}
