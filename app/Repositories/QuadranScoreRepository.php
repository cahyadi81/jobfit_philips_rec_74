<?php

namespace App\Repositories;

use App\Models\QuadranScore;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class QuadranScoreRepository
 * @package App\Repositories
 * @version February 9, 2018, 12:24 pm UTC
 *
 * @method QuadranScore findWithoutFail($id, $columns = ['*'])
 * @method QuadranScore find($id, $columns = ['*'])
 * @method QuadranScore first($columns = ['*'])
*/
class QuadranScoreRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'quatril',
        'score'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return QuadranScore::class;
    }
}
