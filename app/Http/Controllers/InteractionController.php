<?php
namespace App\Http\Controllers;

use App\Dto\Interaction as InteractionDto;
use App\Http\Requests\StoreInteractionRequest;
use App\Http\Requests\UpdateInteractionRequest;
use App\Http\Resources\ContactResource;
use App\Http\Resources\InteractionResource;
use App\Models\Interaction;
use App\Services\ContactService;
use App\Services\InteractionService;
use Exception;
use Inertia\Inertia;

class InteractionController extends Controller
{
    public function __construct(protected InteractionService $interactionService, protected ContactService $contactService)
    {
    }

    public function index()
    {
        return Inertia::render('interactions/index', [
            'interactions' => InteractionResource::collection($this->interactionService->getAll()),
        ]);
    }

    public function create()
    {
        return Inertia::render('interactions/create', [
            'contacts' => ContactResource::collection($this->contactService->getAll()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInteractionRequest $request)
    {
        $data = $request->validated();
        $data['timestamp'] = now();
        $dto = InteractionDto::fromArray($data);
        $interaction = $this->interactionService->create($dto);
        if ($interaction) {
            return redirect()->route('interactions.index')
                ->with('success', 'Interaction created successfully.');
        }

        return redirect()->back()->with('error', 'Failed to create interaction.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Interaction $interaction)
    {
        return Inertia::render('interactions/show', [
            'interaction' => new InteractionResource($interaction),
            'contacts' => ContactResource::collection($this->contactService->getAll()),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Interaction $interaction)
    {
        return Inertia::render('interactions/edit', [
            'interaction' => new InteractionResource($interaction),
            'contacts' => ContactResource::collection($this->contactService->getAll()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInteractionRequest $request, int $id)
    {
        try {
            $data = $request->validated();
            $data['timestamp'] = now();
            $dto = InteractionDto::fromArray($data);
            $updated = $this->interactionService->update($id, $dto);

            if ($updated) {
                return redirect()->route('interactions.index')->with('success', 'Interaction updated successfully.');
            }

            return redirect()->back()->with('error', 'Unable to update Interaction. Please try again.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update Interaction');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $deleted = $this->interactionService->delete($id);

            if ($deleted) {
                return redirect()->route('interactions.index')->with('success', 'Interaction deleted successfully.');
            }

            return redirect()->back()->with('error', 'Unable to delete Interaction. Please try again.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete Interaction');
        }
    }
}
