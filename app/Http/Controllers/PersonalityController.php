<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePersonalityRequest;
use App\Http\Requests\UpdatePersonalityRequest;
use App\Repositories\PersonalityRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PersonalityController extends AppBaseController
{
    /** @var  PersonalityRepository */
    private $personalityRepository;

    public function __construct(PersonalityRepository $personalityRepo)
    {
        $this->personalityRepository = $personalityRepo;
    }

    /**
     * Display a listing of the Personality.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->personalityRepository->pushCriteria(new RequestCriteria($request));
        $personalities = $this->personalityRepository->paginate(10);

        return view('personalities.index')
            ->with('personalities', $personalities);
    }

    /**
     * Show the form for creating a new Personality.
     *
     * @return Response
     */
    public function create()
    {
        return view('personalities.create');
    }

    /**
     * Store a newly created Personality in storage.
     *
     * @param CreatePersonalityRequest $request
     *
     * @return Response
     */
    public function store(CreatePersonalityRequest $request)
    {
        $input = $request->all();

        $personality = $this->personalityRepository->create($input);

        Flash::success('Personality saved successfully.');

        return redirect(route('personalities.index'));
    }

    /**
     * Display the specified Personality.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $personality = $this->personalityRepository->findWithoutFail($id);

        if (empty($personality)) {
            Flash::error('Personality not found');

            return redirect(route('personalities.index'));
        }

        return view('personalities.show')->with('personality', $personality);
    }

    /**
     * Show the form for editing the specified Personality.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $personality = $this->personalityRepository->findWithoutFail($id);

        if (empty($personality)) {
            Flash::error('Personality not found');

            return redirect(route('personalities.index'));
        }

        return view('personalities.edit')->with('personality', $personality);
    }

    /**
     * Update the specified Personality in storage.
     *
     * @param  int              $id
     * @param UpdatePersonalityRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePersonalityRequest $request)
    {
        $personality = $this->personalityRepository->findWithoutFail($id);

        if (empty($personality)) {
            Flash::error('Personality not found');

            return redirect(route('personalities.index'));
        }

        $personality = $this->personalityRepository->update($request->all(), $id);

        Flash::success('Personality updated successfully.');

        return redirect(route('personalities.index'));
    }

    /**
     * Remove the specified Personality from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $personality = $this->personalityRepository->findWithoutFail($id);

        if (empty($personality)) {
            Flash::error('Personality not found');

            return redirect(route('personalities.index'));
        }

        $this->personalityRepository->delete($id);

        Flash::success('Personality deleted successfully.');

        return redirect(route('personalities.index'));
    }
}
