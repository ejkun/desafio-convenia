<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class AbstractApiController extends Controller
{
    protected $className;
    protected $props = [];
    protected $errorMessages = [];
    protected $bodyValidate = [];

    private function getModelOrAbort($id): Model {
        $model = $this->className::find($id);

        if ($model === null) {
            abort(404, $this->errorMessages[404] ?? 'Model não encontrado');
        }

        return $model;
    }

    public function get($id = null) {
        if ($id === null) {
            $models = $this->className::all();

            return $models;
        }

        $model = $this->getModelOrAbort($id);

        return $model;
    }

    public function post(Request $request)
    {
        $model = new $this->className();

        $request->validate($this->bodyValidate);

        foreach ($this->props as $prop) {
            if ($request->has($prop)) {
                $model->$prop = $request->input($prop);
            }
        }

        $model->save();

        return $model;
    }

    public function delete($id)
    {
        $model = $this->getModelOrAbort($id);

        $model->delete();

        return $model;
    }

    public function put($id, Request $request)
    {
        $model = $this->getModelOrAbort($id);

        $request->validate($this->bodyValidate);

        foreach ($this->props as $p) {
            if ($request->has($p)) {
                $pV = $request->input($p);
                $model->$p = $pV;
            }
        }

        $model->save();

        return $model;
    }

    public function patch($id, Request $request)
    {
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

        return $model;
    }
}
