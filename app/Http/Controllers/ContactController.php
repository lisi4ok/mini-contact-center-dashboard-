<?php
namespace App\Http\Controllers;

use App\Dto\Contact as ContactDto;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Services\ContactService;
use Exception;
use Illuminate\Support\Str;
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        try {
            $categoryImagePath = null;

            if ($request->hasFile('image')) {
                $categoryImagePath = $request->file('image')->store('categories', 'public');
            }

            $category->name        = $request->name;
            $category->slug        = Str::slug($request->name);
            $category->description = $request->description;

            if ($categoryImagePath) {
                $category->image = $categoryImagePath;
            }

            $category->save();

            if ($category) {
                return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
            }

            return redirect()->back()->with('error', 'Unable to update category. Please try again.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update category');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        try {
            if ($contact) {
                $contact->delete();
                return redirect()->route('contacts.index')->with('success', 'Category deleted successfully.');
            }

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete category');
        }
    }
}
