<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQuadranIndividualRequest;
use App\Http\Requests\UpdateQuadranIndividualRequest;
use App\Repositories\QuadranIndividualRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class QuadranIndividualController extends AppBaseController
{
    /** @var  QuadranIndividualRepository */
    private $quadranIndividualRepository;

    public function __construct(QuadranIndividualRepository $quadranIndividualRepo)
    {
        $this->quadranIndividualRepository = $quadranIndividualRepo;
    }

    /**
     * Display a listing of the QuadranIndividual.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->quadranIndividualRepository->pushCriteria(new RequestCriteria($request));
        $quadranIndividuals = $this->quadranIndividualRepository->paginate(10);

        return view('quadran_individuals.index')
            ->with('quadranIndividuals', $quadranIndividuals);
    }

    /**
     * Show the form for creating a new QuadranIndividual.
     *
     * @return Response
     */
    public function create()
    {
        return view('quadran_individuals.create');
    }

    /**
     * Store a newly created QuadranIndividual in storage.
     *
     * @param CreateQuadranIndividualRequest $request
     *
     * @return Response
     */
    public function store(CreateQuadranIndividualRequest $request)
    {
        $input = $request->all();

        $quadranIndividual = $this->quadranIndividualRepository->create($input);

        Flash::success('Quadran Individual saved successfully.');

        return redirect(route('quadranIndividuals.index'));
    }

    /**
     * Display the specified QuadranIndividual.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $quadranIndividual = $this->quadranIndividualRepository->findWithoutFail($id);

        if (empty($quadranIndividual)) {
            Flash::error('Quadran Individual not found');

            return redirect(route('quadranIndividuals.index'));
        }

        return view('quadran_individuals.show')->with('quadranIndividual', $quadranIndividual);
    }

    /**
     * Show the form for editing the specified QuadranIndividual.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $quadranIndividual = $this->quadranIndividualRepository->findWithoutFail($id);

        if (empty($quadranIndividual)) {
            Flash::error('Quadran Individual not found');

            return redirect(route('quadranIndividuals.index'));
        }

        return view('quadran_individuals.edit')->with('quadranIndividual', $quadranIndividual);
    }

    /**
     * Update the specified QuadranIndividual in storage.
     *
     * @param  int              $id
     * @param UpdateQuadranIndividualRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateQuadranIndividualRequest $request)
    {
        $quadranIndividual = $this->quadranIndividualRepository->findWithoutFail($id);

        if (empty($quadranIndividual)) {
            Flash::error('Quadran Individual not found');

            return redirect(route('quadranIndividuals.index'));
        }

        $quadranIndividual = $this->quadranIndividualRepository->update($request->all(), $id);

        Flash::success('Quadran Individual updated successfully.');

        return redirect(route('quadranIndividuals.index'));
    }

    /**
     * Remove the specified QuadranIndividual from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $quadranIndividual = $this->quadranIndividualRepository->findWithoutFail($id);

        if (empty($quadranIndividual)) {
            Flash::error('Quadran Individual not found');

            return redirect(route('quadranIndividuals.index'));
        }

        $this->quadranIndividualRepository->delete($id);

        Flash::success('Quadran Individual deleted successfully.');

        return redirect(route('quadranIndividuals.index'));
    }
}
