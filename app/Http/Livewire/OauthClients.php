<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Livewire\Component;

class OauthClients extends Component
{
    public $name;
    public $redirect;
    public $editClientId;
    public $editName;
    public $editRedirect;

    public $authorizationError;

    protected $clientRepository;

    public function __construct()
    {
        $this->clientRepository = app(ClientRepository::class);
        parent::__construct();
    }

    public function render()
    {
        return view('livewire.oauth-clients', [
            'clients' => $this->clientRepository->activeForUser(auth()->user()->id),
        ]);
    }

    public function createClient(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'redirect' => 'required|url|max:255',
        ]);

        $newClient = $this->clientRepository->create(
            auth()->user()->id,
            $this->name,
            $this->redirect,
        );

        $this->dispatchBrowserEvent('clientCreated');
    }

    public function deleteClient(Client $clientId): void
    {
        // test for safety
        // ->delete must be of type Client - thus the model binding
        $this->clientRepository->delete($clientId);
    }

    public function editClient(Client $editClientId): void
    {
        $this->editName = $editClientId->name;
        $this->editRedirect = $editClientId->redirect;

        $this->editClientId = $editClientId->id;

        $this->dispatchBrowserEvent('editClient');
    }

    public function updateClient(Client $editClientId): void
    {
        $this->validate([
            'editName' => 'required|string|max:255',
            'editRedirect' => 'required|url|max:255',
        ]);

        $client = $this->clientRepository->find($editClientId->id);
        if ($client->user_id == auth()->user()->id) {
            $client->name = $this->editName;
            $client->redirect = $this->editRedirect;
            $client->save();
        } else {
            Log::warning('User ' . auth()->user()->id . ' attempted to edit client ' . $editClientId->id . ' which belongs to user ' . $client->user_id);
            $this->authorizationError = 'You are not authorized to edit this client.';
        }

        $this->dispatchBrowserEvent('clientUpdated');

    }
}
