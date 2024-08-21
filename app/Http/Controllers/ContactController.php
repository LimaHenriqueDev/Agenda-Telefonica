<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use App\Repository\ContactRepository;
use App\Services\ContactService;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function __construct(private ContactService $contactService, private ImageService $imageService) {}

    public function index(Contact $contact)
    {
        try {
            return $this->contactService->listContacts($contact);
        } catch (\Exception $e) {
            return $this->apiError($e);
        }
    }

    public function store(StoreContactRequest $storeContactRequest)
    {
        try {
            $image = null;
            if ($storeContactRequest->hasFile('image')) {
                $image = $this->imageService->saveImage($storeContactRequest->file('image'));
            }

            $contact = $this->contactService->createContact($storeContactRequest->validated(), $image);

            return response()->json($contact, 201);
        } catch (\Exception $e) {
            return $this->apiError($e);
        }
    }

    public function show(Contact $contact)
    {
        try {
            return $this->contactService->showContact($contact->id);
        } catch (\Exception $e) {
            return $this->apiError($e);
        }
    }

    public function update(UpdateContactRequest $updateContactRequest, Contact $contact)
    {
        try {
            $image = null;
            if ($updateContactRequest->hasFile('image')) {
                $image = $this->imageService->saveImage($updateContactRequest->file('image'));
            }

            $this->contactService->updateContact($contact->id, $updateContactRequest->validated(), $image);

            return response()->json(null, 204);
        } catch (\Exception $e) {
            return $this->apiError($e);
        }
    }

    public function destroy(Contact $contact)
    {
        try {
            return $this->contactService->deleteContact($contact->id);
        } catch (\Exception $e) {
            return $this->apiError($e);
        }
    }
}
