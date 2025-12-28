<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryCompetencyRequest;
use App\Http\Requests\UpdateCategoryCompetencyRequest;
use App\Repositories\CategoryCompetencyRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CategoryCompetencyController extends AppBaseController
{
    /** @var  CategoryCompetencyRepository */
    private $categoryCompetencyRepository;

    public function __construct(CategoryCompetencyRepository $categoryCompetencyRepo)
    {
        $this->categoryCompetencyRepository = $categoryCompetencyRepo;
    }

    /**
     * Display a listing of the CategoryCompetency.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->categoryCompetencyRepository->pushCriteria(new RequestCriteria($request));
        $categoryCompetencies = $this->categoryCompetencyRepository->paginate(10);

        return view('category_competencies.index')
            ->with('categoryCompetencies', $categoryCompetencies);
    }

    /**
     * Show the form for creating a new CategoryCompetency.
     *
     * @return Response
     */
    public function create()
    {
        return view('category_competencies.create');
    }

    /**
     * Store a newly created CategoryCompetency in storage.
     *
     * @param CreateCategoryCompetencyRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoryCompetencyRequest $request)
    {
        $input = $request->all();

        $categoryCompetency = $this->categoryCompetencyRepository->create($input);

        Flash::success('Category Competency saved successfully.');

        return redirect(route('categoryCompetencies.index'));
    }

    /**
     * Display the specified CategoryCompetency.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $categoryCompetency = $this->categoryCompetencyRepository->findWithoutFail($id);

        if (empty($categoryCompetency)) {
            Flash::error('Category Competency not found');

            return redirect(route('categoryCompetencies.index'));
        }

        return view('category_competencies.show')->with('categoryCompetency', $categoryCompetency);
    }

    /**
     * Show the form for editing the specified CategoryCompetency.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $categoryCompetency = $this->categoryCompetencyRepository->findWithoutFail($id);

        if (empty($categoryCompetency)) {
            Flash::error('Category Competency not found');

            return redirect(route('categoryCompetencies.index'));
        }

        return view('category_competencies.edit')->with('categoryCompetency', $categoryCompetency);
    }

    /**
     * Update the specified CategoryCompetency in storage.
     *
     * @param  int              $id
     * @param UpdateCategoryCompetencyRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryCompetencyRequest $request)
    {
        $categoryCompetency = $this->categoryCompetencyRepository->findWithoutFail($id);

        if (empty($categoryCompetency)) {
            Flash::error('Category Competency not found');

            return redirect(route('categoryCompetencies.index'));
        }

        $categoryCompetency = $this->categoryCompetencyRepository->update($request->all(), $id);

        Flash::success('Category Competency updated successfully.');

        return redirect(route('categoryCompetencies.index'));
    }

    /**
     * Remove the specified CategoryCompetency from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $categoryCompetency = $this->categoryCompetencyRepository->findWithoutFail($id);

        if (empty($categoryCompetency)) {
            Flash::error('Category Competency not found');

            return redirect(route('categoryCompetencies.index'));
        }

        $this->categoryCompetencyRepository->delete($id);

        Flash::success('Category Competency deleted successfully.');

        return redirect(route('categoryCompetencies.index'));
    }

    public function datatable() {
        $categoryCompetencies = $this->categoryCompetencyRepository->all();

        return \DataTables::of($categoryCompetencies)->make(true);
    }

}
