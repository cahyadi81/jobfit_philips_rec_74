<?php

namespace App\Repositories;

use App\Models\Position;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PositionRepository
 * @package App\Repositories
 * @version March 5, 2018, 8:40 am UTC
 *
 * @method Position findWithoutFail($id, $columns = ['*'])
 * @method Position find($id, $columns = ['*'])
 * @method Position first($columns = ['*'])
*/
class PositionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'position_name',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Position::class;
    }
}
