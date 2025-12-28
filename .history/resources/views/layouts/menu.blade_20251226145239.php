<li class="header">MAIN NAVIGATION</li>
<!-- <li class="{{ Request::is('positions*') ? 'active' : '' }}">
    <a href="{!! route('positions.index') !!}"><i class="fa fa-edit"></i><span>Job Positions</span></a>
</li>

<li class="{{ Request::is('quadranCompetencies*') ? 'active' : '' }}">
    <a href="{!! route('quadranCompetencies.index') !!}"><i class="fa fa-edit"></i><span>Quadran Competencies</span></a>
</li>

<li class="{{ Request::is('quadranIndividuals*') ? 'active' : '' }}">
    <a href="{!! route('quadranIndividuals.index') !!}"><i class="fa fa-edit"></i><span>Quadran Individuals</span></a>
</li>

<li class="{{ Request::is('quadranScores*') ? 'active' : '' }}">
    <a href="{!! route('quadranScores.index') !!}"><i class="fa fa-edit"></i><span>Quadran Scores</span></a>
</li>

<li class="{{ Request::is('categoryCompetencies*') ? 'active' : '' }}">
    <a href="{!! route('categoryCompetencies.index') !!}"><i class="fa fa-edit"></i><span>Category Competencies</span></a>
</li>

<li class="{{ Request::is('questionCompetencies*') ? 'active' : '' }}">
    <a href="{!! route('questionCompetencies.index') !!}"><i class="fa fa-edit"></i><span>Question Competencies</span></a>
</li>

<li class="{{ Request::is('jobfitBasics*') ? 'active' : '' }}">
    <a href="{!! route('jobfitBasics.index') !!}"><i class="fa fa-edit"></i><span>Jobfit Basics</span></a>
</li>

<li class="{{ Request::is('categoryJobs*') ? 'active' : '' }}">
    <a href="{!! route('categoryJobs.index') !!}"><i class="fa fa-edit"></i><span>Category Jobs</span></a>
</li>

<li class="{{ Request::is('agreementScores*') ? 'active' : '' }}">
    <a href="{!! route('agreementScores.index') !!}"><i class="fa fa-edit"></i><span>Agreement Scores</span></a>
</li>

<li class="{{ Request::is('personalities*') ? 'active' : '' }}">
    <a href="{!! route('personalities.index') !!}"><i class="fa fa-edit"></i><span>Personalities</span></a>
</li>

<li class="{{ Request::is('groupUsers*') ? 'active' : '' }}">
    <a href="{!! route('groupUsers.index') !!}"><i class="fa fa-edit"></i><span>Group Users</span></a>
</li>
 -->
<!-- <li class="{{ Request::is('results*') ? 'active' : '' || Request::is('/') ? 'active' : ''}}">
    <a href="{!! route('results.index') !!}"><i class="fa fa-edit"></i><span>Results Job Fit</span></a>
</li> -->

<li class="{{ (Request::is('results*') || Request::is('/')) ? 'active' : '' }}">
    <a href="{{ route('results.index') }}">
        <i class="fa fa-edit"></i><span>Results Job Fit</span>
    </a>
</li>