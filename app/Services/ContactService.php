<?php

namespace App\Services;

use App\Helpers\Utils;
use App\Mail\ContactDeleted;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class ContactService
{
    public function __construct(
        private readonly Contact $ContactModel
    ) {}

    public function listForView(int $perPage = 10)
    {
        $contact = $this->ContactModel->paginate($perPage);
        $contact = Utils::paginate($contact);
        return $contact;
    }

    public function create(array $data): Contact
    {
        $data['phone'] = preg_replace('/\D/', '', $data['phone'] ?? '');

        return $this->ContactModel->create($data);
    }

    public function update(int $id, array $data): Contact
    {
        $contact = $this->ContactModel->findOrFail($id);

        if (isset($data['phone'])) {
            $data['phone'] = preg_replace('/\D/', '', $data['phone']);
        }

        $contact->update($data);

        return $contact;
    }


    public function showForView(int $id): Contact
    {
        return $this->ContactModel->findOrFail($id);
    }


    public function delete(int $id): void
    {
        $contact = $this->ContactModel->findOrFail($id);

        Mail::to('crystyan_gavioes@live.com')->send(new ContactDeleted($contact));

        $contact->delete();
    }
}
