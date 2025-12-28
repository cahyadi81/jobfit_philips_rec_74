<?php

namespace App\Repositories;

use App\Models\CategoryCompetency;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CategoryCompetencyRepository
 * @package App\Repositories
 * @version March 5, 2018, 8:52 am UTC
 *
 * @method CategoryCompetency findWithoutFail($id, $columns = ['*'])
 * @method CategoryCompetency find($id, $columns = ['*'])
 * @method CategoryCompetency first($columns = ['*'])
*/
class CategoryCompetencyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'alias',
        'category_name',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CategoryCompetency::class;
    }
}
