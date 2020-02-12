<?php

namespace App\Http\Controllers;

use App\Http\Requests\PizzaStoreRequest;
use App\Http\Requests\PizzaUpdateRequest;
use App\Http\Resources\PizzaCollection;
use App\Http\Resources\PizzaResource;
use App\Pizza;
use App\ResponseType;
use Symfony\Component\HttpFoundation\Response;

class PizzaController extends Controller
{
    protected $name;

    public function index()
    {
        $pizzas = Pizza::all();

        if ($pizzas->count() < 1) {
            return response()->json(ResponseType::PIZZA_NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        return new PizzaCollection($pizzas);
    }

    public function store(PizzaStoreRequest $request, Pizza $pizza)
    {
        $this->authorize('store', $pizza);

        $attributes = request(['name', 'price', 'materials']);

        $pizza = Pizza::create($attributes);

        return new PizzaResource($pizza);
    }

    public function show(Pizza $pizza): PizzaResource
    {
        return new PizzaResource($pizza);
    }

    public function update(PizzaUpdateRequest $request, Pizza $pizza)
    {
        $this->authorize('update', $pizza);

        $attributes = request(['name', 'price', 'materials']);
        $pizza = Pizza::find($pizza->id)->first();

        if (!$pizza) {
            return response()->json(ResponseType::PIZZA_NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        $pizza->update($attributes);

        return new PizzaResource($pizza);
    }

    public function destroy(Pizza $pizza)
    {
        $this->authorize('delete');

        $pizza = Pizza::find($pizza->id)->first();

        if (!$pizza) {
            return response()->json(ResponseType::PIZZA_NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        $pizza->delete();

        return response()->json(ResponseType::PIZZA_DELETED_SUCCESSFULLY, Response::HTTP_OK);
    }
}
