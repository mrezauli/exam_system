{{--<li class="sub-menu">
    <a class="" href="{{ URL::route('dashboard') }}">
        <i class="icon-dashboard"></i>
        <span>Home</span>
    </a>
</li>--}}
<?php $role_name = Session::get('role_title'); ?>

@if($role_name == 'admin' || $role_name == 'organization' || $role_name == 'super-admin')
<li class="sub-menu">
    <a href="javascript:;" >
        <i class="icon-cogs"></i>
        <span>Master Setup</span>
    </a>
    <ul class="sub">
        <li><a  href="{{URL::to('admin/organization')}}">Organization</a></li>
    </ul>

    @if($role_name == 'admin' || $role_name == 'super-admin')
        <ul class="sub">
            <li><a  href="{{URL::to('admin/designation')}}">Name of the Post</a></li>
        </ul>
        <ul class="sub">
            <li><a  href="{{URL::to('admin/exam-time')}}">Examination Time</a></li>
        </ul>
        <ul class="sub">
            <li><a  href="{{URL::to('admin/exam-code')}}">Exam Code</a></li>
        </ul>
    @endif
</li>
@endif


@if($role_name == 'admin' || $role_name == 'super-admin')
    <li class="sub-menu">
        <a href="javascript:;">
            <i class="fa fa-envelope" aria-hidden="true"></i>
            <span>Application-BCC</span>
        </a>
        <ul class="sub">
            <li><a href="{{URL::to('application/bcc-file-upload')}}">Send Email</a></li>
        </ul>
        <ul class="sub">
            <li><a href="{{URL::to('application/received-email-bcc-file-upload')}}">Received Email</a></li>
        </ul>
    </li>
@endif


@if($role_name == 'admin' || $role_name == 'organization' || $role_name == 'super-admin')
    <li class="sub-menu">
        <a href="javascript:;">
            <i class="fa fa-envelope" aria-hidden="true"></i>
            <span>Application-Org.</span>
        </a>
        <ul class="sub">
            <li><a href="{{URL::to('application/organization-file-upload')}}">Send Email</a></li>
        </ul>
        <ul class="sub">
            <li><a href="{{URL::to('application/received-email-organization-file-upload')}}">Received Email</a></li>
        </ul>
        <ul class="sub">
            <li><a href="{{URL::to('application/excel-format')}}">Candidate Excel Format</a></li>
        </ul>
    </li>
@endif

@if($role_name == 'admin' || $role_name == 'super-admin')

    <li class="sub-menu">
        <a href="javascript:;" >
            <i class="fa fa-book"></i>
            <span>Question Bank</span>
        </a>
        <ul class="sub">
            <li><a  href="{{route('qbank-typing-test')}}">Typing Test</a></li>
        </ul>
        <ul class="sub">
            <li><a  href="{{route('qbank-aptitude-test')}}">Aptitude Test</a></li>
        </ul>
        <ul class="sub">
            <li><a  href="#">MCQ Test</a></li>
        </ul>
    </li>


    <li class="sub-menu">
        <a href="javascript:;" >
            <i class="fa fa-question-circle"></i>
            <span>Question Paper</span>
        </a>
        <ul class="sub">
            <li><a  href="{{route('question-paper-set')}}">Aptitude Test</a></li>
        </ul>
    </li>

    <li class="sub-menu">
        <a href="javascript:;" >
            <i class="fa fa-check-square"></i>
            <span>Question Selection</span>
        </a>
        <ul class="sub">
            <li><a  href="{{route('qselection-typing-test')}}">Typing Test</a></li>
        </ul>
        <ul class="sub">
            <li><a  href="{{route('qselection-aptitude-test')}}">Aptitude Test</a></li>
        </ul>
        <ul class="sub">
            <li><a  href="#">MCQ Test</a></li>
        </ul>
    </li>

    <li class="sub-menu">
        <a href="javascript:;" >
            <i class="icon-laptop"></i>
            <span>Examination</span>
        </a>
        {{-- <ul class="sub">
            <li><a  href="{{URL::to('exam/typing-exams')}}">Typing Test Exam</a></li>
        </ul>
        <ul class="sub">
            <li><a  href="{{URL::to('exam/aptitude-exams')}}">Aptitude Test Exam</a></li>
        </ul> --}}
        <ul class="sub">
            <li><a  href="{{URL::to('exam/examiner-selection')}}">Examiner Selection</a></li>
        </ul>
        <ul class="sub">
            <li><a  href="{{URL::to('exam/exam-process')}}">Examination Process</a></li>
        </ul>
        <ul class="sub">
            <li><a  href="{{URL::to('exam/candidate-re-exam')}}">Candidate Re-Exam</a></li>
        </ul>
    </li>
@endif

@if($role_name == 'admin' || $role_name == 'examiner' || $role_name == 'super-admin')
    <li class="sub-menu">
        <a href="javascript:;" >
            <i class="fa fa-question-circle"></i>
            <span>Answer Sheet</span>
        </a>
        <ul class="sub">
            <li><a  href="{{URL::to('exam/answer-checking')}}">Answer Sheet Checking</a></li>
        </ul>
    </li>
@endif

{{--@if($role_name == 'admin')
    <li class="sub-menu">
    <a class="" href="{{ URL::to('user/login') }}">
        <i class="fa fa-user-plus"></i>
        <span>Organization LogIn</span>
    </a>
    </li>
@endif--}}

@if($role_name != 'organization')
    <li class="sub-menu">
        <a href="javascript:;">
            <i class="fa fa-user"></i>
            <span>User</span>
        </a>
        <ul class="sub">
            <li><a href="{{URL::to('user/user-list')}}">User List</a></li>
            @if($role_name == 'admin' || $role_name == 'super-admin')
                <li><a href="{{URL::to('user/organization-user-list')}}">Org. User List</a></li>
                {{--<li><a href="{{URL::to('user/index-role-user')}}">Role User</a></li>--}}
                {{--<li><a href="{{route('index-permission-role')}}">Permission Role</a></li>--}}
                <li><a href="{{URL::to('user/candidate-list')}}">Candidate List</a></li>
            @endif
        </ul>
    </li>
@endif



@if($role_name == 'admin' || $role_name == 'super-admin')
    <li class="sub-menu">
        <a href="javascript:;">
            <i class="fa fa-graduation-cap"></i>
            <span>Reports</span>
        </a>
        <ul class="sub">
            <li><a href="{{URL::to('reports/typing-test-report')}}">Typing Test Report</a></li>
            <li><a href="{{URL::to('reports/short-typing-test-report')}}">Typing Test Report (Short)</a></li>
            <li><a href="{{URL::to('reports/roll-wise-typing-test-report')}}">Roll Wise Typing Test Report</a></li>
            <li><a href="{{URL::to('reports/roll-wise-short-typing-test-report')}}">Roll Wise Typing Test Report (Short)</a></li>
            <li><a href="{{URL::to('reports/aptitude-test-report')}}">Aptitude Test Report</a></li>
            <li><a href="{{URL::to('reports/short-aptitude-test-report')}}">Aptitude Test Report (Short)</a></li>
            <li><a href="{{URL::to('reports/attendance-sheet-report')}}">Attendance Sheet Report</a></li>
            <li><a href="{{URL::to('reports/roll-wise-attendance-sheet-report')}}">Roll Wise Attendance Sheet Report</a></li>
        </ul>
    </li>
@endif


<script>


$('ul.sub li.sub-menu:first-child').removeClass('active')


setTimeout(function(){

$('ul.sub li.sub-menu ul.sub').css('display', 'none');

$('.online-application > ul.sub').css('display', 'none');


}, 100);

</script>