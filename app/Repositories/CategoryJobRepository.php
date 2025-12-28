<?php

namespace App\Repositories;

use App\Models\CategoryJob;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CategoryJobRepository
 * @package App\Repositories
 * @version March 9, 2018, 12:06 pm UTC
 *
 * @method CategoryJob findWithoutFail($id, $columns = ['*'])
 * @method CategoryJob find($id, $columns = ['*'])
 * @method CategoryJob first($columns = ['*'])
*/
class CategoryJobRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'position_id',
        'category_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CategoryJob::class;
    }
}
