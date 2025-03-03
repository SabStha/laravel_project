<?php

namespace App\Http\Controllers;
use App\Models\Contact; 

use App\Mail\ContactFormSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
 
    public function showForm()
    {
        return view('contact.form');
    }

    

    public function handleForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);
    
        
        $userId = Auth::id();
    
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'status' => 'pending', 
            'user_id' => $userId, 
        ]);
    
  
       Mail::to('support@example.com')->send(new ContactFormSubmitted($request));
    
        
        return redirect()->route('contact.form')->with('status', 'お問い合わせが正常に送信されました！折り返しご連絡いたします。');
    }
}