<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryJobRequest;
use App\Http\Requests\UpdateCategoryJobRequest;
use App\Repositories\CategoryJobRepository;
use App\Repositories\PositionRepository;
use App\Repositories\CategoryCompetencyRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CategoryJobController extends AppBaseController
{
    /** @var  CategoryJobRepository */
    private $categoryJobRepository;

    public function __construct(CategoryJobRepository $categoryJobRepo, PositionRepository $positionRepo, CategoryCompetencyRepository $categoryCompetencyRepo)
    {
        $this->categoryJobRepository        = $categoryJobRepo;
        $this->positionRepoRepository       = $positionRepo;
        $this->categoryCompetencyRepository = $categoryCompetencyRepo;
    }

    /**
     * Display a listing of the CategoryJob.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->categoryJobRepository->pushCriteria(new RequestCriteria($request));
        $categoryJobs = $this->categoryJobRepository->paginate(10);

        return view('category_jobs.index')
            ->with('categoryJobs', $categoryJobs);
    }

    /**
     * Show the form for creating a new CategoryJob.
     *
     * @return Response
     */
    public function create()
    {
        $position = $this->positionRepoRepository->all();
        $category = $this->categoryCompetencyRepository->all();
        return view('category_jobs.create')->with(['position' => $position, 'category_competencies' => $category]);
    }

    /**
     * Store a newly created CategoryJob in storage.
     *
     * @param CreateCategoryJobRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoryJobRequest $request)
    {
        $input = $request->all();

        $categoryJob = $this->categoryJobRepository->create($input);

        Flash::success('Category Job saved successfully.');

        return redirect(route('categoryJobs.index'));
    }

    /**
     * Display the specified CategoryJob.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $categoryJob = $this->categoryJobRepository->findWithoutFail($id);

        if (empty($categoryJob)) {
            Flash::error('Category Job not found');

            return redirect(route('categoryJobs.index'));
        }

        return view('category_jobs.show')->with('categoryJob', $categoryJob);
    }

    /**
     * Show the form for editing the specified CategoryJob.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $categoryJob    = $this->categoryJobRepository->findWithoutFail($id);
        $position       = $this->positionRepoRepository->all();
        $category       = $this->categoryCompetencyRepository->all();

        if (empty($categoryJob)) {
            Flash::error('Category Job not found');

            return redirect(route('categoryJobs.index'));
        }

        return view('category_jobs.edit')->with(['categoryJob' => $categoryJob, 'position' => $position, 'category_competencies' => $category]);
    }

    /**
     * Update the specified CategoryJob in storage.
     *
     * @param  int              $id
     * @param UpdateCategoryJobRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryJobRequest $request)
    {
        $categoryJob = $this->categoryJobRepository->findWithoutFail($id);

        if (empty($categoryJob)) {
            Flash::error('Category Job not found');

            return redirect(route('categoryJobs.index'));
        }

        $categoryJob = $this->categoryJobRepository->update($request->all(), $id);

        Flash::success('Category Job updated successfully.');

        return redirect(route('categoryJobs.index'));
    }

    /**
     * Remove the specified CategoryJob from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $categoryJob = $this->categoryJobRepository->findWithoutFail($id);

        if (empty($categoryJob)) {
            Flash::error('Category Job not found');

            return redirect(route('categoryJobs.index'));
        }

        $this->categoryJobRepository->delete($id);

        Flash::success('Category Job deleted successfully.');

        return redirect(route('categoryJobs.index'));
    }
}
