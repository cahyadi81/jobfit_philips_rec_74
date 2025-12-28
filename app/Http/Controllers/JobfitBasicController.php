<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobfitBasicRequest;
use App\Http\Requests\UpdateJobfitBasicRequest;
use App\Repositories\JobfitBasicRepository;
use App\Repositories\PositionRepository;
use App\Repositories\CategoryCompetencyRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class JobfitBasicController extends AppBaseController
{
    /** @var  JobfitBasicRepository */
    private $jobfitBasicRepository;

    public function __construct(JobfitBasicRepository $jobfitBasicRepo, CategoryCompetencyRepository $categoryCompetencyRepo, PositionRepository $positionRepo)
    {
        $this->jobfitBasicRepository = $jobfitBasicRepo;
        $this->positionRepoRepository       = $positionRepo;
        $this->categoryCompetencyRepository = $categoryCompetencyRepo;
    }

    /**
     * Display a listing of the JobfitBasic.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->jobfitBasicRepository->pushCriteria(new RequestCriteria($request));
        $jobfitBasics = $this->jobfitBasicRepository->paginate(10);

        return view('jobfit_basics.index')
            ->with('jobfitBasics', $jobfitBasics);
    }

    /**
     * Show the form for creating a new JobfitBasic.
     *
     * @return Response
     */
    public function create()
    {
        $position = $this->positionRepoRepository->all();
        $categoryCompetency = $this->categoryCompetencyRepository->all();
        return view('jobfit_basics.create')->with(['position' => $position, 'categoryCompetency' => $categoryCompetency]);
    }

    /**
     * Store a newly created JobfitBasic in storage.
     *
     * @param CreateJobfitBasicRequest $request
     *
     * @return Response
     */
    public function store(CreateJobfitBasicRequest $request)
    {
        $input = $request->all();

        $jobfitBasic = $this->jobfitBasicRepository->create($input);

        Flash::success('Jobfit Basic saved successfully.');

        return redirect(route('jobfitBasics.index'));
    }

    /**
     * Display the specified JobfitBasic.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $jobfitBasic = $this->jobfitBasicRepository->findWithoutFail($id);

        if (empty($jobfitBasic)) {
            Flash::error('Jobfit Basic not found');

            return redirect(route('jobfitBasics.index'));
        }

        return view('jobfit_basics.show')->with(['jobfitBasic' => $jobfitBasic]);
    }

    /**
     * Show the form for editing the specified JobfitBasic.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $position = $this->positionRepoRepository->all();
        $jobfitBasic        = $this->jobfitBasicRepository->findWithoutFail($id);
        $categoryCompetency = $this->categoryCompetencyRepository->all();

        if (empty($jobfitBasic)) {
            Flash::error('Jobfit Basic not found');

            return redirect(route('jobfitBasics.index'));
        }

        return view('jobfit_basics.edit')->with(['position' => $position, 'jobfitBasic' => $jobfitBasic, 'categoryCompetency' => $categoryCompetency]);
    }

    /**
     * Update the specified JobfitBasic in storage.
     *
     * @param  int              $id
     * @param UpdateJobfitBasicRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateJobfitBasicRequest $request)
    {
        $jobfitBasic = $this->jobfitBasicRepository->findWithoutFail($id);

        if (empty($jobfitBasic)) {
            Flash::error('Jobfit Basic not found');

            return redirect(route('jobfitBasics.index'));
        }

        $jobfitBasic = $this->jobfitBasicRepository->update($request->all(), $id);

        Flash::success('Jobfit Basic updated successfully.');

        return redirect(route('jobfitBasics.index'));
    }

    /**
     * Remove the specified JobfitBasic from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $jobfitBasic = $this->jobfitBasicRepository->findWithoutFail($id);

        if (empty($jobfitBasic)) {
            Flash::error('Jobfit Basic not found');

            return redirect(route('jobfitBasics.index'));
        }

        $this->jobfitBasicRepository->delete($id);

        Flash::success('Jobfit Basic deleted successfully.');

        return redirect(route('jobfitBasics.index'));
    }
}
