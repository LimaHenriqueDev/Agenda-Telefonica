<?php

namespace App\Services;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Image;
use App\Repository\ContactRepository;

class ContactService
//organizar ordem como controller
{
  public function __construct(private ContactRepository $contactRepository) {}

  public function createContact(array $payload, ?Image $image): Contact
  {

    $contactData = [
      'name' => $payload['name'],
      'phone' => $payload['phone'],
      'email' => $payload['email'],
      'user_id' => auth()->user()->id,
      'image_id' => $image->id,
    ];

    return  $this->contactRepository->create($contactData);
  }

  public function listContacts()
  {
    return $this->contactRepository->getModel()->where('user_id', auth()->user()->id )->paginate(10);
  }

  public function showContact(int $id)
  {
    return $this->contactRepository->find($id);
  }

  public function deleteContact(int $id)
  {
    $contact =  $this->contactRepository->find($id);
    if (!$contact) {
      throw new \InvalidArgumentException('Não existe');
    }

    return $this->contactRepository->delete($id);
  }

  public function updateContact(int $id, array $payload, ?Image $image): void
  {
    $contact = $this->contactRepository->find($id);

    $contactData = [
      'name' => data_get($payload, 'name', $contact->name),
      'phone' => data_get($payload, 'phone', $contact->phone),
      'email' => data_get($payload, 'email', $contact->email),
    ];

    if ($image) {
      $contactData['image_id'] = $image->id;
    }

    $this->contactRepository->update($id, $contactData);
  }
}
