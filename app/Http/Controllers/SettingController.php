<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function sitesIndex()
    {
        $user = auth()->user();

        if (in_array($user->type, ['super_admin', 'admin'])) {
            $list = Site::latest()->paginate(30);
        }

        return view('sites.index', [
            'list' => $list,
        ]);
    }
}
