<?php
namespace App\Http\Controllers;

use App\Dto\Contact as ContactDto;
use App\Enums\InteractionTypes;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\Http\Resources\InteractionResource;
use App\Models\Contact;
use App\Models\Interaction;
use App\Services\ContactService;
use Exception;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function __construct(protected ContactService $contactService)
    {
    }

    public function index()
    {
        return Inertia::render('contacts/index', [
            'contacts' => ContactResource::collection($this->contactService->getAll()),
        ]);
    }

    public function create()
    {
        return Inertia::render('contacts/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        $dto = ContactDto::fromArray($request->validated());
        $contact = $this->contactService->create($dto);
        if ($contact) {
            return redirect()->route('contacts.index')
                ->with('success', 'Contact created successfully.');
        }

        return redirect()->back()->with('error', 'Failed to create contact.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        return Inertia::render('contacts/show', [
            'contact' => $contact,
            'interactions' => InteractionResource::collection(Interaction::where('contact_id', $contact->id)->get()),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        return Inertia::render('contacts/edit', ['contact' => $contact]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, int $id)
    {
        try {
            $dto = ContactDto::fromArray($request->validated());
            $updated = $this->contactService->update($id, $dto);

            if ($updated) {
                return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
            }

            return redirect()->back()->with('error', 'Unable to update Contact. Please try again.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update Contact');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $deleted = $this->contactService->delete($id);

            if ($deleted) {
                return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully.');
            }

            return redirect()->back()->with('error', 'Unable to delete Contact. Please try again.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete Contact');
        }
    }
}
