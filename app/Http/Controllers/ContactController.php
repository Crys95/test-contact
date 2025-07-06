<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest\CreateContactRequest;
use App\Http\Requests\ContactRequest\UpdateContactRequest;
use App\Services\ContactService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function __construct(private readonly ContactService $contactService) {}

    public function index(Request $request)
    {
        $contacts = $this->contactService->listForView();

        if ($request->expectsJson()) {
            return response()->json($contacts);
        }

        return Inertia::render('Contacts/Index', [
            'contacts' => $contacts,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Contacts/Create');
    }

    public function store(CreateContactRequest $request)
    {
        $contact = $this->contactService->create($request->validated());

        if ($request->expectsJson()) {
            return response()->json($contact, 201);
        }

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

    public function update(UpdateContactRequest $request, int $id)
    {
        try {
            $contact = $this->contactService->update($id, $request->validated());

            if ($request->expectsJson()) {
                return response()->json($contact, 200);
            }

            return redirect()->route('contacts.index')->with('success', 'Contato atualizado com sucesso!');
        } catch (ModelNotFoundException $e) {
            abort(404, 'Contato não encontrado');
        }
    }

    public function destroy(Request $request, int $id)
    {
        try {
            $this->contactService->delete($id);

            if ($request->expectsJson()) {
                return response()->noContent();
            }

            return redirect()->route('contacts.index')->with('success', 'Contato deletado com sucesso!');
        } catch (ModelNotFoundException $e) {
            abort(404, 'Contato não encontrado');
        }
    }
}
