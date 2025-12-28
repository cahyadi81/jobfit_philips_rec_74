<?php

namespace App\Repositories;

use App\Models\JobfitBasic;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class JobfitBasicRepository
 * @package App\Repositories
 * @version March 9, 2018, 9:50 am UTC
 *
 * @method JobfitBasic findWithoutFail($id, $columns = ['*'])
 * @method JobfitBasic find($id, $columns = ['*'])
 * @method JobfitBasic first($columns = ['*'])
*/
class JobfitBasicRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'category_competencies_id',
        'jobfit_id',
        'values',
        'percent'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return JobfitBasic::class;
    }
}
