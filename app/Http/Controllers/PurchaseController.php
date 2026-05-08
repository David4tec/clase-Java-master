<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Process a storefront purchase and create a sale in the admin CRM
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'items' => 'required|array|min:1',
                'items.*.id' => 'required|string',
                'items.*.name' => 'required|string',
                'items.*.price' => 'required|numeric',
                'items.*.qty' => 'required|integer|min:1',
                'items.*.model' => 'required|string',
                'total' => 'required|numeric|min:0',
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email|max:255',
            ]);

            // Get or create customer
            if (auth()->check()) {
                // Authenticated user - ensure they have a contact
                $user = auth()->user();
                $contact = Contact::firstOrCreate(
                    ['user_id' => $user->id],
                    ['phone' => null, 'company' => null, 'position' => null]
                );
            } else {
                // Anonymous customer - create a generic client user + contact
                $user = User::firstOrCreate(
                    ['email' => $validated['customer_email']],
                    [
                        'name' => $validated['customer_name'],
                        'password' => bcrypt(uniqid()),
                        'role' => 'cliente',
                    ]
                );

                $contact = Contact::firstOrCreate(
                    ['user_id' => $user->id],
                    ['phone' => null, 'company' => null, 'position' => null]
                );
            }

            // Build title from cart items
            $itemNames = array_map(fn($item) => $item['name'], $validated['items']);
            $title = count($itemNames) === 1
                ? $itemNames[0]
                : count($itemNames) . ' items';

            // Build notes with full details
            $notes = "Customer: {$validated['customer_name']} ({$validated['customer_email']})\n\n";
            $notes .= "Items:\n";
            foreach ($validated['items'] as $item) {
                $notes .= "- {$item['name']} (Model/Size: {$item['model']}) × {$item['qty']} @ \${$item['price']}\n";
            }
            $notes .= "\nOrder Total: \${$validated['total']}";

            // Create sale with status 'cerrado' (closed/completed)
            $sale = Sale::create([
                'contact_id' => $contact->id,
                'title' => $title,
                'amount' => $validated['total'],
                'status' => 'cerrado',
                'expected_close' => now()->toDateString(),
                'notes' => $notes,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Purchase recorded successfully',
                'sale_id' => $sale->id,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = [];
            foreach ($e->errors() as $field => $messages) {
                $errors[] = implode(', ', $messages);
            }
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . implode(' | ', $errors),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing purchase: ' . $e->getMessage(),
            ], 500);
        }
    }
}
