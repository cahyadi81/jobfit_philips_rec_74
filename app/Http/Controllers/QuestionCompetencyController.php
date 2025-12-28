<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQuestionCompetencyRequest;
use App\Http\Requests\UpdateQuestionCompetencyRequest;
use App\Repositories\QuestionCompetencyRepository;
use App\Repositories\CategoryCompetencyRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class QuestionCompetencyController extends AppBaseController
{
    /** @var  QuestionCompetencyRepository */
    private $questionCompetencyRepository;

    public function __construct(QuestionCompetencyRepository $questionCompetencyRepo, CategoryCompetencyRepository $categoryCompetencyRepo)
    {
        $this->questionCompetencyRepository = $questionCompetencyRepo;
        $this->categoryCompetencyRepo       = $categoryCompetencyRepo;
    }

    /**
     * Display a listing of the QuestionCompetency.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->questionCompetencyRepository->pushCriteria(new RequestCriteria($request));
        $questionCompetencies = $this->questionCompetencyRepository->paginate(10);

        return view('question_competencies.index')
            ->with('questionCompetencies', $questionCompetencies);
    }

    /**
     * Show the form for creating a new QuestionCompetency.
     *
     * @return Response
     */
    public function create()
    {
        $category = $this->categoryCompetencyRepo->all();
        return view('question_competencies.create')
               ->with('category', $category);
    }

    /**
     * Store a newly created QuestionCompetency in storage.
     *
     * @param CreateQuestionCompetencyRequest $request
     *
     * @return Response
     */
    public function store(CreateQuestionCompetencyRequest $request)
    {
        $input = $request->all();

        $questionCompetency = $this->questionCompetencyRepository->create($input);

        Flash::success('Question Competency saved successfully.');

        return redirect(route('questionCompetencies.index'));
    }

    /**
     * Display the specified QuestionCompetency.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $questionCompetency = $this->questionCompetencyRepository->findWithoutFail($id);

        if (empty($questionCompetency)) {
            Flash::error('Question Competency not found');

            return redirect(route('questionCompetencies.index'));
        }

        return view('question_competencies.show')->with('questionCompetency', $questionCompetency);
    }

    /**
     * Show the form for editing the specified QuestionCompetency.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $questionCompetency = $this->questionCompetencyRepository->findWithoutFail($id);
        $category           = $this->categoryCompetencyRepo->all();

        if (empty($questionCompetency)) {
            Flash::error('Question Competency not found');

            return redirect(route('questionCompetencies.index'));
        }

        return view('question_competencies.edit')->with(['questionCompetency' => $questionCompetency, 'category' => $category]);
    }

    /**
     * Update the specified QuestionCompetency in storage.
     *
     * @param  int              $id
     * @param UpdateQuestionCompetencyRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateQuestionCompetencyRequest $request)
    {
        $questionCompetency = $this->questionCompetencyRepository->findWithoutFail($id);

        if (empty($questionCompetency)) {
            Flash::error('Question Competency not found');

            return redirect(route('questionCompetencies.index'));
        }

        $questionCompetency = $this->questionCompetencyRepository->update($request->all(), $id);

        Flash::success('Question Competency updated successfully.');

        return redirect(route('questionCompetencies.index'));
    }

    /**
     * Remove the specified QuestionCompetency from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $questionCompetency = $this->questionCompetencyRepository->findWithoutFail($id);

        if (empty($questionCompetency)) {
            Flash::error('Question Competency not found');

            return redirect(route('questionCompetencies.index'));
        }

        $this->questionCompetencyRepository->delete($id);

        Flash::success('Question Competency deleted successfully.');

        return redirect(route('questionCompetencies.index'));
    }
}
