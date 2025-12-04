<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(10);

        if ($request->wantsJson()) {
            return response()->json($contacts);
        }

        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request): RedirectResponse|JsonResponse
    {
        $data = $request->validated();

        $contact = Contact::create($data);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Contact created',
                'contact' => $contact,
            ], 201);
        }

        return redirect()
            ->route('contacts.index')
            ->with('success', 'Contact created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact, Request $request): View|JsonResponse
    {
        if ($request->wantsJson()) {
            return response()->json($contact);
        }

        return view('contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact): View
    {
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact): RedirectResponse|JsonResponse
    {
        $data = $request->validated();

        $contact->update($data);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Contact updated',
                'contact' => $contact->fresh(),
            ]);
        }

        return redirect()
            ->route('contacts.index')
            ->with('success', 'Contact updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact, Request $request): RedirectResponse|JsonResponse
    {
        $contact->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Contact deleted']);
        }

        return redirect()
            ->route('contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }
}
