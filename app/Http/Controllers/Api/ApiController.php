<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use App\Rules\OrderBy;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;

class ApiController extends Controller
{
    use ApiResponser;

    /**
     * The attribute to include into pagination resources
     *
     * @var int
     */
    protected $per_page;

    /**
     * The attribute to include into order function
     *
     * @var string
     */
    protected $order_by;

    /**
     * The attribute to order collection ascending or descending
     *
     * @var string
     */
    protected $direction;

    /**
     * The attribute to order collection ascending or descending
     *
     * @var string
     */
    protected $query;

    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        Validator::validate(request()->all(), [
            'query'      =>  'nullable|string',
            'per_page'   =>  'nullable|integer|min:2|max:100',
            'order_by'   =>  'nullable|string|min:2|max:20',
            'direction'  =>  ['nullable', 'string', new OrderBy],
        ]);
        $this->per_page = $this->getPerPageAttribute();
        $this->order_by = $this->getOrderByAttribute();
        $this->direction = $this->getDirectionAttribute();
        $this->query = $this->getQueryAttribute();
    }

    /**
     * Check and get the pagination quantity number
     *
     * @return int
     */
    protected function getPerPageAttribute()
    {
        return (request()->has('per_page')) ? (int) request()->get('per_page') : 15;
    }

    /**
     * Check and get the data ordering by specific column
     *
     * @return string
     */
    protected function getOrderByAttribute()
    {
        return (request()->has('order_by')) ? (string) request()->get('order_by') : 'id';
    }

    /**
     * Check and get the data ordering direction
     *
     * @return string
     */
    protected function getDirectionAttribute()
    {
        return (request()->has('direction')) ? (string) request()->get('direction') : 'asc';
    }

    /**
     * Check and get the data ordering direction
     *
     * @return string
     */
    protected function getQueryAttribute()
    {
        return (request()->has('query')) ? (string) request()->get('query') : null;
    }

    /**
     * @param $query
     * @return bool
     */
    protected function queryHasPipe($query)
    {
        return (strpos($query, '|') === false) ? false : true;
    }

    /**
     * @param $query
     * @return bool
     */
    protected function queryHasNotPipe($query)
    {
        return !$this->queryHasPipe($query);
    }

    protected function modelHasColumn($column, array $columns = [])
    {
        return in_array($column, $columns);
    }

    protected function getModel(Model $model, array $relations = [], $builder = null)
    {
        if (!$builder) {
            $builder = $model;
        }

        $order_by = ($this->modelHasColumn($this->order_by, $model->getFillable())) ? $this->order_by : $model->getTable() . '.id';
        $builder = ($this->direction === 'asc') ? $builder->orderBy($order_by) : $builder->orderByDesc($order_by);
        if ($this->query && $this->queryHasNotPipe($this->query)) {
            foreach ($model->getFillable() as $column) {
                $builder->orWhere($column, 'LIKE', '%' . $this->query . '%');
            }
        } else {
            $query = explode('|', $this->query);
            $column = isset($query[0]) ? $query[0] : 'id';
            $operator = isset($query[1]) ? $query[1] : '=';
            $value = isset($query[2]) ? $query[2] : '';
            if ("like" === strtolower($operator)) {
                $value = "%" . $value . "%";
            }
            $builder = ($this->modelHasColumn($column, $model->getFillable()))
                ? $builder->where($column, $operator, $value)
                : $builder;
        }
        if (count($relations) > 0) {
            $builder = $builder->with($relations);
        }
        $collection = $builder->paginate($this->per_page);

        return $collection;
    }
}
