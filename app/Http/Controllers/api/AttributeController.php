<?php

namespace App\Http\Controllers\api;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest;
use App\Http\Resources\AttributeResource;
use App\Http\Requests\UpdateAttributeRequest;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::paginate(10);
        return $this->respondWithPagination(AttributeResource::collection($attributes));
    }

    public function show($id)
    {
        $attribute = Attribute::find($id);

        if ($attribute) {
            return $this->respondData(new AttributeResource($attribute), 200, true);
        }

        return $this->respondError('not found');
    }

    public function store(AttributeRequest $request)
    {
        try {
            $validated = $request->validated();

            $attribute = Attribute::create($validated);

            return $this->respondData(new AttributeResource($attribute), 200, true);
        } catch (\Exception $e) {
            return $this->respondError('an error occurred: ' . $e->getMessage());
        }
    }

    public function update(UpdateAttributeRequest $request, $id)
    {
        $attribute = Attribute::find($id);

        if ($attribute) {
            $validated = $request->validated();
            $attribute->update($validated);
            return $this->respondData(new AttributeResource($attribute), 200, 'updated');
        }

        return $this->respondError('not found');
    }

    public function delete($id)
    {
        $attribute = Attribute::find($id);

        if ($attribute) {
            $attribute->delete();
            return $this->respondData(new AttributeResource($attribute), 200, 'deleted');
        }

        return $this->respondError('not found');
    }
}
