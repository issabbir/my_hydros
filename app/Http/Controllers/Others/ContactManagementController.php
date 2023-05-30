<?php

namespace App\Http\Controllers\Others;

use App\Entities\Others\ContactManagement;
use App\Entities\Setup\Vehicle;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactManagementController extends Controller
{
    //contact-management-index
    public function index(Request $request)
    {
        $contact_managements = ContactManagement::with([])->get();
        return view('others.contact-management-index', [
            'contact_managements' => $contact_managements,
        ]);
    }
}
