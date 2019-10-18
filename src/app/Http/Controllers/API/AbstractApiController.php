<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

abstract class AbstractApiController extends Controller
{
    protected $className;
    protected $props = [];
    protected $errorMessages = [];
    protected $bodyValidate = [];
    protected $cacheTime = 60;
    protected $cacheBaseName = 'abstract_api_controller';

    private function getModelOrAbort($id): Model {
        $model = $this->className::find($id);

        if ($model === null) {
            abort(404, $this->errorMessages[404] ?? 'Model não encontrado');
        }

        return $model;
    }

    public function get($id = null, Request $request) {
        $this->beforeGet($request);

        if ($id === null) {
            $models = Cache::remember($this->cacheBaseName.'_all', $this->cacheTime, function () {
                return $this->className::all();
            });

            return $models;
        }

        $model = Cache::remember($this->cacheBaseName.'_'.$id, $this->cacheTime, function () use ($id) {
            return $this->getModelOrAbort($id);
        });

        $this->afterGet($request);

        return $model;
    }

    public function post(Request $request)
    {
        $this->beforePost($request);

        $model = new $this->className();

        $request->validate($this->bodyValidate);

        foreach ($this->props as $prop) {
            if ($request->has($prop)) {
                $model->$prop = $request->input($prop);
            }
        }

        $model->save();

        $this->afterPost($request);

        return $model;
    }

    public function delete($id, Request $request)
    {
        $this->beforeDelete($request);

        $model = $this->getModelOrAbort($id);

        $model->delete();

        $this->afterDelete($request);

        return $model;
    }

    public function put($id, Request $request)
    {
        $this->beforePut($request);

        $model = $this->getModelOrAbort($id);

        $request->validate($this->bodyValidate);

        foreach ($this->props as $p) {
            if ($request->has($p)) {
                $pV = $request->input($p);
                $model->$p = $pV;
            }
        }

        $model->save();

        $this->afterPut($request);

        return $model;
    }

    public function patch($id, Request $request)
    {
        $this->beforePatch($request);

        $model = $this->getModelOrAbort($id);

        foreach ($this->props as $p) {
            if ($request->has($p)) {
                $pV = $request->input($p);
                $this
                    ->getValidationFactory()
                    ->make([$p => $pV],[$p => $this->bodyValidate[$p]])
                    ->validate()
                ;
                $model->$p = $pV;
            }
        }

        $model->save();

        $this->afterPatch($request);

        return $model;
    }

    protected function beforeGet(Request $request) {}
    protected function afterGet(Request $request) {}
    protected function beforePost(Request $request) {}
    protected function afterPost(Request $request) {}
    protected function beforePatch(Request $request) {}
    protected function afterPatch(Request $request) {}
    protected function beforePut(Request $request) {}
    protected function afterPut(Request $request) {}
    protected function beforeDelete(Request $request) {}
    protected function afterDelete(Request $request) {}
}
