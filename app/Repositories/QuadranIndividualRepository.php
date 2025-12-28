<?php

namespace App\Repositories;

use App\Models\QuadranIndividual;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class QuadranIndividualRepository
 * @package App\Repositories
 * @version February 9, 2018, 9:11 am UTC
 *
 * @method QuadranIndividual findWithoutFail($id, $columns = ['*'])
 * @method QuadranIndividual find($id, $columns = ['*'])
 * @method QuadranIndividual first($columns = ['*'])
*/
class QuadranIndividualRepository extends BaseRepository
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
        return QuadranIndividual::class;
    }
}
