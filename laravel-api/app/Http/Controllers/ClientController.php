<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Resources\ClientResource;
use App\Actions\Client\StoreClientAction;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;

class ClientController extends Controller
{
    public function store(StoreClientRequest $request)
    {
        return $this->storeModel(
            $request,
            StoreClientAction::class,
            ClientResource::class,
            'Client'
        );
    }

    public function index()
    {
        return ClientResource::collection(Client::all());
    }
    
    public function show(Client $client)
    {
        return ClientResource::make($client);
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        return $this->updateModel($request, $client, 'Client');
    }

    public function destroy(Client $client)
    {
        return $this->destroyModel($client, 'Client');
    }
}
