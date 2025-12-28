<?php

namespace App\Repositories;

use App\Models\AgreementScore;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AgreementScoreRepository
 * @package App\Repositories
 * @version March 9, 2018, 12:09 pm UTC
 *
 * @method AgreementScore findWithoutFail($id, $columns = ['*'])
 * @method AgreementScore find($id, $columns = ['*'])
 * @method AgreementScore first($columns = ['*'])
*/
class AgreementScoreRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'agreement_id',
        'norma'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AgreementScore::class;
    }
}
