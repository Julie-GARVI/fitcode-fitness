<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lastname' => ['required', 'max:25', 'regex:' . $this->regex],
            'firstname' => ['required', 'max:25', 'regex:' . $this->regex],
            'email' => ['required', 'email', 'regex:' . $this->regex],
            'message' => ['required', 'regex:' . $this->regex]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $contact = Contact::create([
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Contact form submitted successfully',
        ]);
    }
}
