<?php

namespace App\Repositories;

use App\Models\Result;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ResultRepository
 * @package App\Repositories
 * @version March 1, 2018, 2:07 am UTC
 *
 * @method Result findWithoutFail($id, $columns = ['*'])
 * @method Result find($id, $columns = ['*'])
 * @method Result first($columns = ['*'])
*/
class ResultRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nik',
        'position_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Result::class;
    }
}
