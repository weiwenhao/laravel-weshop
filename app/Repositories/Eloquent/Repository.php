<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;

abstract class Repository implements RepositoryInterface
{
    private $app;
    protected $model; //子类可以通过 $this->model直接使用模型
    /**
     * Repository constructor.
     * @param $app
     */
    public function __construct(Container $app)
    {
        $this->app = $app;//Ioc 容器,可以直接调用bind将类的实例注册至容器中和make方法实例化一个实例
        $this->makeModel();
    }
    /**
     * Specify Model class name   该方法返回需要实例化的模型的完全限定名称
     * return  App/Models/User::class
     * @return mixed
     */
    abstract public function modelName();
    /**
     * @return Model|mixed
     */
    private function makeModel()
    {
        $model = $this->app->make($this->modelName());
        if (!$model instanceof Model)
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        return $this->model = $model;
    }
    public function all($columns = array('*')) {
        return $this->model->get($columns);
    }
    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*')) {
        return $this->model->paginate($perPage, $columns);
    }
    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data) {
        return $this->model->create($data);
    }
    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id) {
        $model = $this->model->findOrFail($id);
        if ($model->update($data))
            return $model;
        return false;
    }
    /**
     * @param $id
     * @return mixed
     */
    public function delete($id) {
        return $this->model->destroy($id);
    }
    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*')) {
        return $this->model->find($id, $columns);
    }
    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->get($columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function firstBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }
}