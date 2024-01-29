<?php

namespace Orangecode\Service;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Orangecode\Repository\Repository;
use Orangecode\Repository\RepositoryAutoInstance;
use Orangecode\Service\Response\ServiceResponse;

abstract class ServiceBase implements Service
{
    use ServiceDataBase;
    use ServiceAutoInstance;
    use RepositoryAutoInstance;

    /** @var Repository */
    protected Repository $repository;

    /** @var ServiceResponse */
    protected ServiceResponse $response;

    /** @var array  */
    private ?array $autoInstance;

    /**
     * @param Repository $repository
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(Repository $repository, ?array $autoInstance = null)
    {
        $this->repository = $repository;
        $this->response = app()->make(ServiceResponse::class);
        $this->autoInstance = $autoInstance;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws \Exception
     */
    public function __call(string $name, array $arguments)
    {
        if (method_exists($this->repository, $name)) {
            $reflection = new \ReflectionMethod($this->repository, $name);
            $args = $reflection->getNumberOfParameters();
            for ($i = 0; $i < $args; $i++) {
                ${'arg_' . $i} = $arguments[$i] ?? null;
            }
            return $this->repository->$name($arg_0 ?? null, $arg_1 ?? null, $arg_2 ?? null, $arg_3 ?? null, $arg_4 ?? null);
        } else {
            throw new \Exception('Método não existe no service ou repository.', 500);
        }
    }

    /**
     * @param string $name
     * @return mixed
     * @throws BindingResolutionException
     */
    public function __get(string $name)
    {
        if (strpos($name, 'service') !== false) {
            return $this->instanceAutoService($name, $this->autoInstance['service'] ?? null);
        }
        return $this->instanceAutoRepository($name, $this->autoInstance['repository'] ?? null);
    }

    /**
     * Realiza a pesquisa do modelo
     * @param int $id
     * @return mixed
     */
    public function find(int $id): mixed
    {
        return $this->repository->find($id);
    }

    /**
     * Realiza o cadastro ou atualização dos dados
     * @param Request $request
     * @return void
     */
    public function manager(Request $request): mixed
    {
        $data = $this->validated($request);
        try {
            return $this->repository->save($data);
        } catch (\Exception $exception) {
            if ($exception->getCode() == '23000') {
                abort(400, "Erro no processamento do banco de dados. ({$exception->getMessage()})");
            }
            abort(500, $exception->getMessage());
        }
    }

    /**
     * Realiza a exclusão dos dados
     * @param Request $request
     * @return void
     */
    public function delete(Request $request): void
    {
        try {
            $this->repository->remove($request->id);
        } catch (\Exception $exception) {
            if ($exception->getCode() == '23000') {
                abort(400, "Erro no processamento do banco de dados. ({$exception->getMessage()})");
            }
            abort(500, $exception->getMessage());
        }
    }

    /**
     * Realiza a validação dos dados - OVERRIDE
     * @param Request $request
     * @return array
     */
    public function validated(Request $request): array
    {
        return [];
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->repository->getModel();
    }
}
