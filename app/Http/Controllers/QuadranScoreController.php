<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQuadranScoreRequest;
use App\Http\Requests\UpdateQuadranScoreRequest;
use App\Repositories\QuadranScoreRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class QuadranScoreController extends AppBaseController
{
    /** @var  QuadranScoreRepository */
    private $quadranScoreRepository;

    public function __construct(QuadranScoreRepository $quadranScoreRepo)
    {
        $this->quadranScoreRepository = $quadranScoreRepo;
    }

    /**
     * Display a listing of the QuadranScore.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->quadranScoreRepository->pushCriteria(new RequestCriteria($request));
        $quadranScores = $this->quadranScoreRepository->paginate(10);

        return view('quadran_scores.index')
            ->with('quadranScores', $quadranScores);
    }

    /**
     * Show the form for creating a new QuadranScore.
     *
     * @return Response
     */
    public function create()
    {
        return view('quadran_scores.create');
    }

    /**
     * Store a newly created QuadranScore in storage.
     *
     * @param CreateQuadranScoreRequest $request
     *
     * @return Response
     */
    public function store(CreateQuadranScoreRequest $request)
    {
        $input = $request->all();

        $quadranScore = $this->quadranScoreRepository->create($input);

        Flash::success('Quadran Score saved successfully.');

        return redirect(route('quadranScores.index'));
    }

    /**
     * Display the specified QuadranScore.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $quadranScore = $this->quadranScoreRepository->findWithoutFail($id);

        if (empty($quadranScore)) {
            Flash::error('Quadran Score not found');

            return redirect(route('quadranScores.index'));
        }

        return view('quadran_scores.show')->with('quadranScore', $quadranScore);
    }

    /**
     * Show the form for editing the specified QuadranScore.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $quadranScore = $this->quadranScoreRepository->findWithoutFail($id);

        if (empty($quadranScore)) {
            Flash::error('Quadran Score not found');

            return redirect(route('quadranScores.index'));
        }

        return view('quadran_scores.edit')->with('quadranScore', $quadranScore);
    }

    /**
     * Update the specified QuadranScore in storage.
     *
     * @param  int              $id
     * @param UpdateQuadranScoreRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateQuadranScoreRequest $request)
    {
        $quadranScore = $this->quadranScoreRepository->findWithoutFail($id);

        if (empty($quadranScore)) {
            Flash::error('Quadran Score not found');

            return redirect(route('quadranScores.index'));
        }

        $quadranScore = $this->quadranScoreRepository->update($request->all(), $id);

        Flash::success('Quadran Score updated successfully.');

        return redirect(route('quadranScores.index'));
    }

    /**
     * Remove the specified QuadranScore from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $quadranScore = $this->quadranScoreRepository->findWithoutFail($id);

        if (empty($quadranScore)) {
            Flash::error('Quadran Score not found');

            return redirect(route('quadranScores.index'));
        }

        $this->quadranScoreRepository->delete($id);

        Flash::success('Quadran Score deleted successfully.');

        return redirect(route('quadranScores.index'));
    }
}
