<?php

namespace App\Http\Controllers\api;

use App\Models\Service;
use App\Models\Services;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Category;
use PhpParser\ErrorHandler\Collecting;

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


    public function store(ServiceRequest $request)
    {

        $validated = $request->validated();


        $service =  Service::create($validated);
        if (isset($service)) {
            return $this->respondData(new ServiceResource($service), 200, true);
        }

        return
            $this->respondError('an error occured');
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
