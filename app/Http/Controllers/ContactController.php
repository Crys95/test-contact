<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest\CreateContactRequest;
use App\Http\Requests\ContactRequest\UpdateContactRequest;
use App\Services\ContactService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function __construct(private readonly ContactService $contactService) {}

    public function index(): Response
    {
        $contacts = $this->contactService->listForView();

        return Inertia::render('Contacts/Index', [
            'contacts' => $contacts,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Contacts/Create');
    }

    public function store(CreateContactRequest $request): RedirectResponse
    {
        $this->contactService->create($request->validated());

        return redirect()->route('contacts.index')->with('success', 'Contato criado com sucesso!');
    }

    public function show(int $id): Response
    {
        try {
            $contact = $this->contactService->showForView($id);
        } catch (ModelNotFoundException $e) {
            abort(404, 'Contato não encontrado');
        }

        return Inertia::render('Contacts/Show', [
            'contact' => $contact,
        ]);
    }

    public function edit(int $id): Response
    {
        try {
            $contact = $this->contactService->showForView($id);
        } catch (ModelNotFoundException $e) {
            abort(404, 'Contato não encontrado');
        }

        return Inertia::render('Contacts/Edit', [
            'contact' => $contact,
        ]);
    }

    public function update(UpdateContactRequest $request, int $id): RedirectResponse
    {
        try {
            $this->contactService->update($id, $request->validated());
        } catch (ModelNotFoundException $e) {
            abort(404, 'Contato não encontrado');
        }

        return redirect()->route('contacts.index')->with('success', 'Contato atualizado com sucesso!');
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->contactService->delete($id);
        } catch (ModelNotFoundException $e) {
            abort(404, 'Contato não encontrado');
        }

        return redirect()->route('contacts.index')->with('success', 'Contato deletado com sucesso!');
    }
}
