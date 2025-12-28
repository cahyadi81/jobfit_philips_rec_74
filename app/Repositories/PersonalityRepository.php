<?php

namespace App\Repositories;

use App\Models\Personality;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PersonalityRepository
 * @package App\Repositories
 * @version March 9, 2018, 2:49 am UTC
 *
 * @method Personality findWithoutFail($id, $columns = ['*'])
 * @method Personality find($id, $columns = ['*'])
 * @method Personality first($columns = ['*'])
*/
class PersonalityRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'alias',
        'personality_name',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Personality::class;
    }
}
