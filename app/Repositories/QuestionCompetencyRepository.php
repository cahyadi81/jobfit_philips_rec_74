<?php

namespace App\Repositories;

use App\Models\QuestionCompetency;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class QuestionCompetencyRepository
 * @package App\Repositories
 * @version February 9, 2018, 12:36 pm UTC
 *
 * @method QuestionCompetency findWithoutFail($id, $columns = ['*'])
 * @method QuestionCompetency find($id, $columns = ['*'])
 * @method QuestionCompetency first($columns = ['*'])
*/
class QuestionCompetencyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'question_id',
        'categori_id',
        'description',
        'answer'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return QuestionCompetency::class;
    }
}
