<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Models\Service;
use App\Models\Category;
use App\Models\Services;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use PhpParser\ErrorHandler\Collecting;
use App\Http\Resources\ServiceResource;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Attribute as ModelsAttribute;
use App\Models\Attribute_value;
use App\Models\Service_attribute;
use Attribute;

class ServiceController extends Controller
{



    public function index()
    {

        $services = Service::query()->paginate(10);

        return $this->respondWithPagination(ServiceResource::collection($services));
    }



    public function show($id)
    {

        $service = Service::find($id);

        if ($service) {

            return $this->respondData(new ServiceResource($service), 200, true);
        }

        return $this->respondError('not found');
    }


    public function store(Request $request)
    {

    try{

        $data = $request->all();

        // Create new service record
        $newService = Service::create([
            'name' => $data['name'],
            'category_id' => $data['category_id'],
            'price' => $data['price'],
            // 'description' => $data['description']
        ]);

        // Loop over attribute_id and value_id arrays
        foreach ($data['attributes'] as $attribute) {
            $attributeId = $attribute['id'];
            $attributeValues = $attribute['values'];

            foreach ($attributeValues as $value) {
                $valueId = $value['id'];

                $serviceAttribute = new Service_Attribute();
                $serviceAttribute->service_id = $newService->id;
                $serviceAttribute->attribute_id = $attributeId;
                $serviceAttribute->value_id = $valueId;
                $serviceAttribute->save();
            }
        }

        return $this->respondData(new ServiceResource($newService), 200, true);

    }

    catch (Exception $e){
        return $this->respondError('an error occurred: ' . $e->getMessage());
    }




    }



    public function update(UpdateServiceRequest $request, $id)
    {


        $service = Service::find($id);
        $validated = $request->validated();

        if ($service) {
            $service->update($validated);
            return $this->respondData(new ServiceResource($service), 200, 'updated');
        }


        return $this->respondError('not found');
    }


    public function delete($id)
    {


        $service = Service::find($id);


        if ($service) {


            $service->delete();

            return $this->respondData(new ServiceResource($service), 200, 'deleted');
        }
        return $this->respondError('not found');
    }
}
