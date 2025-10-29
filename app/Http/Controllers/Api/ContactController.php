<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Resources\ContactResource;
use App\Http\Requests\UpdateContactRequest;
use App\Services\ContactService;
use App\Dto\Contact as ContactDto;

class ContactController extends Controller
{
    public function __construct(protected ContactService $contactService)
    {
    }

    public function index()
    {
        return ContactResource::collection($this->contactService->getAll());
    }

    public function store(StoreContactRequest $request)
    {
        $dto = ContactDto::fromArray($request->validated());
        $contact = $this->contactService->create($dto);

        return new ContactResource($contact);
    }

    public function update(UpdateContactRequest $request, $id)
    {
        $dto = ContactDto::fromArray($request->validated());
        $contact = $this->contactService->update($id, $dto);

        return new ContactResource($contact);
    }

    public function destroy($id)
    {
        $deleted = $this->contactService->delete($id);

        if (!$deleted) {
            response()->json([
                'status' => true,
                'message' => 'Something was wrong'
            ], 500);
        }

        return response()->json([
            'status' => true,
            'message' => 'Contact deleted successfully'
        ], 204);
    }
}
