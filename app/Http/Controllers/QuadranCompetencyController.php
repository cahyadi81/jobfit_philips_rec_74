<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQuadranCompetencyRequest;
use App\Http\Requests\UpdateQuadranCompetencyRequest;
use App\Repositories\QuadranCompetencyRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class QuadranCompetencyController extends AppBaseController
{
    /** @var  QuadranCompetencyRepository */
    private $quadranCompetencyRepository;
    private $session_id;

    public function __construct(QuadranCompetencyRepository $quadranCompetencyRepo)
    {
        $this->quadranCompetencyRepository  = $quadranCompetencyRepo;
    }

    /**
     * Display a listing of the QuadranCompetency.
     *
     * @param Request $request
     * @return Response
     */

    public function index(Request $request)
    {

        $this->quadranCompetencyRepository->pushCriteria(new RequestCriteria($request));
        $quadranCompetencies = $this->quadranCompetencyRepository->paginate(10);

        return view('quadran_competencies.index')
            ->with('quadranCompetencies', $quadranCompetencies);
    }

    /**
     * Show the form for creating a new QuadranCompetency.
     *
     * @return Response
     */
    public function create()
    {
        return view('quadran_competencies.create');
    }

    /**
     * Store a newly created QuadranCompetency in storage.
     *
     * @param CreateQuadranCompetencyRequest $request
     *
     * @return Response
     */
    public function store(CreateQuadranCompetencyRequest $request)
    {
        $input = $request->all();

        $quadranCompetency = $this->quadranCompetencyRepository->create($input);

        Flash::success('Quadran Competency saved successfully.');

        return redirect(route('quadranCompetencies.index'));
    }

    /**
     * Display the specified QuadranCompetency.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $quadranCompetency = $this->quadranCompetencyRepository->findWithoutFail($id);

        if (empty($quadranCompetency)) {
            Flash::error('Quadran Competency not found');

            return redirect(route('quadranCompetencies.index'));
        }

        return view('quadran_competencies.show')->with('quadranCompetency', $quadranCompetency);
    }

    /**
     * Show the form for editing the specified QuadranCompetency.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $quadranCompetency = $this->quadranCompetencyRepository->findWithoutFail($id);

        if (empty($quadranCompetency)) {
            Flash::error('Quadran Competency not found');

            return redirect(route('quadranCompetencies.index'));
        }

        return view('quadran_competencies.edit')->with('quadranCompetency', $quadranCompetency);
    }

    /**
     * Update the specified QuadranCompetency in storage.
     *
     * @param  int              $id
     * @param UpdateQuadranCompetencyRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateQuadranCompetencyRequest $request)
    {
        $quadranCompetency = $this->quadranCompetencyRepository->findWithoutFail($id);

        if (empty($quadranCompetency)) {
            Flash::error('Quadran Competency not found');

            return redirect(route('quadranCompetencies.index'));
        }

        $quadranCompetency = $this->quadranCompetencyRepository->update($request->all(), $id);

        Flash::success('Quadran Competency updated successfully.');

        return redirect(route('quadranCompetencies.index'));
    }

    /**
     * Remove the specified QuadranCompetency from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $quadranCompetency = $this->quadranCompetencyRepository->findWithoutFail($id);

        if (empty($quadranCompetency)) {
            Flash::error('Quadran Competency not found');

            return redirect(route('quadranCompetencies.index'));
        }

        $this->quadranCompetencyRepository->delete($id);

        Flash::success('Quadran Competency deleted successfully.');

        return redirect(route('quadranCompetencies.index'));
    }
}
