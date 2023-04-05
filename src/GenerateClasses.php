<?php

namespace Tijanidevit\DevApi\Src\GenerateClasses;

use Illuminate\Support\Facades\File;

class GenerateClasses
{
    protected $namespace;

    public function __construct($namespace)
    {
        $this->namespace = $namespace;
    }

    public function generate($resourceName)
    {
        $this->generateModel($resourceName);
        $this->generateService($resourceName);
        $this->generateController($resourceName);
        $this->generateStoreRequest($resourceName);
        $this->generateUpdateRequest($resourceName);
        $this->generateResponse($resourceName);
    }

    protected function generateModel($resourceName)
    {
        $modelStub = File::get(__DIR__ . '/../stubs/model.stub');

        $modelContents = str_replace(
            ['DummyNamespace', 'DummyClass'],
            [$this->getModelNamespace(), $resourceName],
            $modelStub
        );

        File::put($this->getModelFilePath($resourceName), $modelContents);
    }

    protected function generateService($resourceName)
    {
        $serviceStub = File::get(__DIR__ . '/../stubs/service.stub');

        $serviceContents = str_replace(
            ['DummyNamespace', 'DummyClass', 'DummyModelNamespace', 'DummyModelClass'],
            [$this->getServiceNamespace(), "{$resourceName}Service", $this->getModelNamespace(), $resourceName],
            $serviceStub
        );

        File::put($this->getServiceFilePath($resourceName), $serviceContents);
    }

    protected function generateController($resourceName)
    {
        $controllerStub = File::get(__DIR__ . '/../stubs/controller.stub');

        $controllerContents = str_replace(
            ['DummyNamespace', 'DummyClass', 'DummyServiceNamespace', 'DummyServiceClass', 'DummyModelNamespace', 'DummyModelClass'],
            [$this->getControllerNamespace(), "{$resourceName}Controller", $this->getServiceNamespace(), "{$resourceName}Service", $this->getModelNamespace(), $resourceName],
            $controllerStub
        );

        File::put($this->getControllerFilePath($resourceName), $controllerContents);
    }

    protected function generateStoreRequest($resourceName)
    {
        $resourceName = "Store{$resourceName}";
        $requestStub = File::get(__DIR__ . '/../stubs/request.stub');

        $requestContents = str_replace(
            ['DummyNamespace', 'DummyClass'],
            [$this->getRequestNamespace(), "{$resourceName}Request"],
            $requestStub
        );

        File::put($this->getRequestFilePath("$resourceName"), $requestContents);
    }

    protected function generateUpdateRequest($resourceName)
    {
        $resourceName = "Update{$resourceName}";
        $requestStub = File::get(__DIR__ . '/../stubs/request.stub');

        $requestContents = str_replace(
            ['DummyNamespace', 'DummyClass'],
            [$this->getRequestNamespace(), "{$resourceName}Request"],
            $requestStub
        );

        File::put($this->getRequestFilePath("$resourceName"), $requestContents);
    }

    protected function generateRequest($resourceName)
    {
        $requestStub = File::get(__DIR__ . '/../stubs/request.stub');

        $requestContents = str_replace(
            ['DummyNamespace', 'DummyClass'],
            [$this->getRequestNamespace(), "{$resourceName}Request"],
            $requestStub
        );

        File::put($this->getRequestFilePath($resourceName), $requestContents);
    }

    protected function generateResponse($resourceName)
    {
        $responseStub = File::get(__DIR__ . '/../stubs/response.stub');

        $responseContents = str_replace(
            ['DummyNamespace', 'DummyClass'],
            [$this->getResponseNamespace(), "{$resourceName}Resource"],
            $responseStub
        );

        File::put($this->getResponseFilePath($resourceName), $responseContents);
    }

    protected function getModelNamespace()
    {
        return "{$this->namespace}\\Models";
    }

    protected function getModelFilePath($resourceName)
    {
        return "src/Models/{$resourceName}.php";
    }

    protected function getServiceNamespace()
    {
        return "{$this->namespace}\\Services";
    }

    protected function getServiceFilePath($resourceName)
    {
        return "src/Services/{$resourceName}Service.php";
    }

    protected function getControllerNamespace()
    {
        return "{$this->namespace}\\Http\\Controllers";
    }

    protected function getControllerFilePath($resourceName)
    {
        return "src/Http/Controllers/{$resourceName}Controller.php";
    }

    protected function getRequestNamespace()
    {
        return "{$this->namespace}\\Http\\Requests";
    }

    protected function getRequestFilePath($resourceName)
    {
        return "src/Http/Requests/{$resourceName}Request.php";
    }

    protected function getResponseNamespace()
    {
        return "{$this->namespace}\\Http\\Resources";
    }

    protected function getResponseFilePath($resourceName)
    {
        return "src/Http/Resources/{$resourceName}Resource.php";
    }
}

