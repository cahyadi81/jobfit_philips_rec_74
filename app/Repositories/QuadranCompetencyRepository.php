<?php

namespace App\Repositories;

use App\Models\QuadranCompetency;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class QuadranCompetencyRepository
 * @package App\Repositories
 * @version February 9, 2018, 9:04 am UTC
 *
 * @method QuadranCompetency findWithoutFail($id, $columns = ['*'])
 * @method QuadranCompetency find($id, $columns = ['*'])
 * @method QuadranCompetency first($columns = ['*'])
*/
class QuadranCompetencyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'quatril',
        'min',
        'max'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return QuadranCompetency::class;
    }
}
