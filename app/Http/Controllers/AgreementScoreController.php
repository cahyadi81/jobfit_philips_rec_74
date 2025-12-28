<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAgreementScoreRequest;
use App\Http\Requests\UpdateAgreementScoreRequest;
use App\Repositories\AgreementScoreRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AgreementScoreController extends AppBaseController
{
    /** @var  AgreementScoreRepository */
    private $agreementScoreRepository;

    public function __construct(AgreementScoreRepository $agreementScoreRepo)
    {
        $this->agreementScoreRepository = $agreementScoreRepo;
    }

    /**
     * Display a listing of the AgreementScore.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->agreementScoreRepository->pushCriteria(new RequestCriteria($request));
        $agreementScores = $this->agreementScoreRepository->paginate(10);

        return view('agreement_scores.index')
            ->with('agreementScores', $agreementScores);
    }

    /**
     * Show the form for creating a new AgreementScore.
     *
     * @return Response
     */
    public function create()
    {
        return view('agreement_scores.create');
    }

    /**
     * Store a newly created AgreementScore in storage.
     *
     * @param CreateAgreementScoreRequest $request
     *
     * @return Response
     */
    public function store(CreateAgreementScoreRequest $request)
    {
        $input = $request->all();

        $agreementScore = $this->agreementScoreRepository->create($input);

        Flash::success('Agreement Score saved successfully.');

        return redirect(route('agreementScores.index'));
    }

    /**
     * Display the specified AgreementScore.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $agreementScore = $this->agreementScoreRepository->findWithoutFail($id);

        if (empty($agreementScore)) {
            Flash::error('Agreement Score not found');

            return redirect(route('agreementScores.index'));
        }

        return view('agreement_scores.show')->with('agreementScore', $agreementScore);
    }

    /**
     * Show the form for editing the specified AgreementScore.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $agreementScore = $this->agreementScoreRepository->findWithoutFail($id);

        if (empty($agreementScore)) {
            Flash::error('Agreement Score not found');

            return redirect(route('agreementScores.index'));
        }

        return view('agreement_scores.edit')->with('agreementScore', $agreementScore);
    }

    /**
     * Update the specified AgreementScore in storage.
     *
     * @param  int              $id
     * @param UpdateAgreementScoreRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAgreementScoreRequest $request)
    {
        $agreementScore = $this->agreementScoreRepository->findWithoutFail($id);

        if (empty($agreementScore)) {
            Flash::error('Agreement Score not found');

            return redirect(route('agreementScores.index'));
        }

        $agreementScore = $this->agreementScoreRepository->update($request->all(), $id);

        Flash::success('Agreement Score updated successfully.');

        return redirect(route('agreementScores.index'));
    }

    /**
     * Remove the specified AgreementScore from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $agreementScore = $this->agreementScoreRepository->findWithoutFail($id);

        if (empty($agreementScore)) {
            Flash::error('Agreement Score not found');

            return redirect(route('agreementScores.index'));
        }

        $this->agreementScoreRepository->delete($id);

        Flash::success('Agreement Score deleted successfully.');

        return redirect(route('agreementScores.index'));
    }
}
