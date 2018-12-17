<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

trait BaseRepository
{



    /**
     * Get number of records
     *
     * @return array
     */
    public function getNumber()
    {
        return $this->model->count();
    }

    /**
     * Update columns in the record by id.
     *
     * @param $id
     * @param $input
     * @return App\Model|User
     */
    public function updateColumn($id, $input)
    {
        $this->model = $this->getById($id);

        foreach ($input as $key => $value) {
            $this->model->{$key} = $value;
        }

        return $this->model->save();
    }

    /**
     * Destroy a model.
     *
     * @param  $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->getById($id)->delete();
    }

    /**
     * Get model by id.
     *
     * @return App\Model
     */
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Get all the records
     *
     * @return array User
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Get number of the records
     *
     * @param  int $number
     * @param  string $sort
     * @param  string $sortColumn
     * @return Paginate
     */
    public function page($number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        return $this->model->orderBy($sortColumn, $sort)->paginate($number);
    }

    /**
     * Store a new record.
     *
     * @param  $input
     * @return User
     */
    public function store($input)
    {
        return $this->save($this->model, $input);
    }

    /**
     * Update a record by id.
     *
     * @param  $id
     * @param  $input
     * @return User
     */
    public function update($id, $input)
    {
        $this->model = $this->getById($id);

        return $this->save($this->model, $input);
    }

    /**
     * Save the input's data.
     *
     * @param  $model
     * @param  $input
     * @return User
     */
    public function save($model, $input)
    {
        $model->fill($input);

        $model->save();

        return $model;
    }

    /**
     * Search by a keyword in a field
     *
     * @param $field
     * @param $val
     * @return mixed
     */
    public function getByLike($field, $val){
        return $this->model->where($field, 'like', '%' . $val . '%');
    }

    /**
     * @param $type
     * @return records for chart
     *
     */
    public function getChart($type){

        $YEARLY = 'yearly';
        $MONTHLY = 'monthly';
        $DAILY = 'daily';

        switch ($type){
            case $YEARLY:
                return $this->model
                    ->select(DB::raw('CONCAT(YEAR(created_at), " year" ) AS period , COUNT(*) AS model'))
                    ->groupBy('period')
                    ->get();
            case $MONTHLY:
                return $this->model
                    ->select(DB::raw('CONCAT(YEAR(NOW()), "-", MONTH(created_at)) AS period, COUNT(*) AS model'))
                    ->whereRaw('YEAR(created_at) = YEAR(NOW())')
                    ->groupBy('period')
                    ->get();
            case $DAILY:
                return $this->model
                    ->select(DB::raw('CONCAT(YEAR(NOW()), "-", MONTH(NOW()), "-", DAY(created_at)) AS period, COUNT(*) AS model'))
                    ->whereRaw('YEAR(created_at) = YEAR(NOW()) AND MONTH(created_at) = MONTH(NOW())')
                    ->groupBy('period')
                    ->get();
        }
        return null;
    }
}
