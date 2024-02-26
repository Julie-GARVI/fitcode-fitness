<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{

        public function list()
    {

        $contacts = Contact::orderBy('id', 'desc')
            ->paginate(5);

        return view('contact', ['contacts' => $contacts]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lastname' => ['required', 'max:50', 'string', 'regex:' . $this->regex],
            'firstname' => ['required', 'max:50', 'string', 'regex:' . $this->regex],
            'email' => ['required', 'email', 'regex:' . $this->regex],
            'message' => ['required', 'min:15', 'regex:' . $this->regex]
        ]);

        $requiredMessages = requiredErrorMessages();
        $validateMessages = validateErrorMessages();
        $charactersMessages = $this->specialCharactersErrors();

        $validator->setCustomMessages(array_merge(
            $requiredMessages, 
            $validateMessages,
            ['regex' => $charactersMessages['regex']],
        ));

        if ($validator->fails()) {

            $errors = $validator->errors()->messages();
        
            return response()->json(['errors' => $errors], 422);
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

//----------------------------------------ERREURS---------------------------------

function requiredErrorMessages() {
    return [
        'lastname.required' => 'Veuillez indiquer votre nom de famille',
        'firstname.required' => 'Veuillez indiquer votre prénom',
        'email.required' => 'Veuillez indiquer votre adresse email',
        'message.required' => 'Veuillez indiquer votre message',
    ];
}

function validateErrorMessages() {
    return [
        'lastname.max' => 'Votre nom de famille est trop long',
        'firstname.max' => 'Votre prénom est trop long',
        'email.email' => 'L\'adresse email doit inclure "@"',
        'message.min' => 'Votre message est trop court',
    ];
}

