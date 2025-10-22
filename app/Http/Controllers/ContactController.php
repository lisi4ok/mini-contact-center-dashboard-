<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use App\Services\ContactService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function __construct(protected ContactService $contactService)
    {
    }

    public function index(Request $request)
    {
        $contactsQuery = Contact::query();

        # Capturing the total count before applying filters
        $totalCount = $contactsQuery->count();

        if ($request->filled('search')) {
            $search = $request->search;

            $contactsQuery->where(fn($query) =>
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
            );
        }

        # Filtered Count
        $filteredCount = $contactsQuery->count();

        $perPage = (int) ($request->perPage ?? 10);

        # Fetch All the Records
        if ($perPage === -1) {
            $allContacts = $contactsQuery->latest()->get()->map(fn($contact) => [
                'id'                           => $contact->id,
                'name'                         => $contact->name,
                'email'                        => $contact->email,
                'phone'                        => $contact->phone,
                'company'                      => $contact->company,
                'created_at'                   => $contact->created_at->format('d M Y'),
            ]);

            $contacts = [
                'data'     => $allContacts,
                'total'    => $filteredCount,
                'per_page' => $perPage,
                'from'     => 1,
                'to'       => $filteredCount,
                'links'    => [],
            ];

        } else {
            $contacts = $contactsQuery->latest()->paginate($perPage)->withQueryString();
            $contacts->getCollection()->transform(fn($contact) => [
                'id'                           => $contact->id,
                'name'                         => $contact->name,
                'email'                        => $contact->email,
                'phone'                        => $contact->phone,
                'company'                      => $contact->company,
                'created_at'                   => $contact->created_at->format('d M Y'),
            ]);
        }

        return Inertia::render('contacts/index', [
            'contacts'      => $contacts,
            'filters'       => $request->only(['search', 'perPage']),
            'totalCount'    => $totalCount,
            'filteredCount' => $filteredCount,
        ]);
    }

    public function create()
    {
        return Inertia::render('contacts/form', [
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        try {
            $categoryImagePath = null;

            if ($request->hasFile('image')) {
                $categoryImagePath = $request->file('image')->store('categories', 'public');
            }

            $category = Contact::create([
                'name'        => $request->name,
                'slug'        => Str::slug($request->name),
                'description' => $request->description,
                'image'       => $categoryImagePath,
            ]);

            if ($category) {
                return redirect()->route('categories.index')->with('success', 'Category created successfully.');
            }

            return redirect()->back()->with('error', 'Unable to create category. Please try again.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to create category');
        }
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
    public function destroy(Category $category)
    {
        try {
            if ($category) {
                $category->delete();
                return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
            }

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete category');
        }
    }
}
