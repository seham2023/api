<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\Attribute_value;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeValueRequest;
use App\Http\Requests\UpdateAttributeValueRequest;
use App\Http\Resources\AttributeValueResource;

class AttributeValueController extends Controller
{
    public function index()
{
    $attributeValues = Attribute_Value::paginate(10);
    return $this->respondWithPagination(AttributeValueResource::collection($attributeValues));
}

public function show($id)
{
    $attributeValue = Attribute_Value::find($id);

    if ($attributeValue) {
        return $this->respondData(new AttributeValueResource($attributeValue), 200, true);
    }

    return $this->respondError('not found');
}

public function store(AttributeValueRequest $request)
{
    try {
        $validated = $request->validated();

        $attributeValue = Attribute_Value::create($validated);

        return $this->respondData(new AttributeValueResource($attributeValue), 200, true);
    } catch (\Exception $e) {
        return $this->respondError('an error occurred: ' . $e->getMessage());
    }
}

public function update( UpdateAttributeValueRequest $request, $id)
{
    $attributeValue = Attribute_value::find($id);

    if ($attributeValue) {
        $validated = $request->validated();
        $attributeValue->update($validated);
        return $this->respondData(new AttributeValueResource($attributeValue), 200, 'updated');
    }

    return $this->respondError('not found');
}

public function delete($id)
{
    $attributeValue = Attribute_value::find($id);

    if ($attributeValue) {
        $attributeValue->delete();
        return $this->respondData(new AttributeValueResource($attributeValue), 200, 'deleted');
    }

    return $this->respondError('not found');
}
}
