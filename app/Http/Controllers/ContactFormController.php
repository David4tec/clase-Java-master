<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'email'   => 'required|email|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);

            // Find or create a user record for this email
            $user = User::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'name'     => explode('@', $validated['email'])[0],
                    'password' => bcrypt(uniqid()),
                    'role'     => 'cliente',
                ]
            );

            // Find or create a Contact linked to that user
            $contact = Contact::firstOrCreate(
                ['user_id' => $user->id],
                ['phone' => null, 'company' => null, 'position' => null]
            );

            // Save message as an Activity of type 'email'
            Activity::create([
                'contact_id'  => $contact->id,
                'type'        => 'email',
                'description' => "Subject: {$validated['subject']}\n\n{$validated['message']}",
                'occurred_at' => now(),
            ]);

            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = [];
            foreach ($e->errors() as $messages) {
                $errors[] = implode(', ', $messages);
            }
            return response()->json([
                'success' => false,
                'message' => implode(' | ', $errors),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
