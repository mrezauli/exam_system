<?php


Route::group(array('prefix' => 'reports','modules'=>'Reports', 'namespace' => 'Modules\Reports\Controllers','middleware'=>['auth','access_control:reports']), function() {

    Route::any('lead-client-management', [
        'as' => 'lead-client-management',
        'uses' => 'ReportController@index'
    ]);

    Route::any('datewise-movement', [
        'as' => 'datewise-movement',
        'uses' => 'ReportController@datewise_movement'
    ]);

    Route::any('generate-datewise-movement', [
        //'middleware' => 'acl_access:reports/search-user',
        'as' => 'generate-datewise-movement',
        'uses' => 'ReportController@generate_datewise_movement'
    ]);

    Route::any('meeting-details/{task_id}/{meeting_id}', [
        //'middleware' => 'acl_access:reports/meeting-details/{task_id}/{meeting_id}',
        'as' => 'meeting-details',
        'uses' => 'ReportController@meeting_details'
    ]);

    Route::any('task-report', [
        'as' => 'task-report',
        'uses' => 'ReportController@task_report'
    ]);

    Route::any('generate-task-report', [
        'as' => 'generate-task-report',
        'uses' => 'ReportController@generate_task_report'
    ]);

    Route::any('task-detail/{task_id}', [
        'as' => 'task-detail',
        'uses' => 'ReportController@task_detail'
    ]);






    Route::any('visiting-information', [
        'as' => 'visiting-information',
        'uses' => 'ReportController@visiting_information'
    ]);

    Route::any('generate-visiting-information', [
        //'middleware' => 'acl_access:reports/search-user',
        'as' => 'generate-visiting-information',
        'uses' => 'ReportController@generate_visiting_information'
    ]);

    Route::any('visiting-information-details/{task_id}/{meeting_id}', [
        //'middleware' => 'acl_access:reports/meeting-detail/{task_id}/{meeting_id}',
        'as' => 'visiting-information-details',
        'uses' => 'ReportController@visiting_information_details'
    ]);

    Route::any('visiting-info-pdf/{task_id}/{meeting_id}', [
        //'middleware' => 'acl_access:reports/meeting-detail/{task_id}/{meeting_id}',
        'as' => 'visiting-info-pdf',
        'uses' => 'ReportController@visiting_info_pdf'
    ]);

    Route::any('datewise-movement-pdf/{task_id}/{meeting_id}', [
        //'middleware' => 'acl_access:reports/meeting-detail/{task_id}/{meeting_id}',
        'as' => 'datewise-movement-pdf',
        'uses' => 'ReportController@datewise_movement_pdf'
    ]);

    Route::any('task-detail-pdf/{task_id}', [
        //'middleware' => 'acl_access:reports/meeting-detail/{task_id}/{meeting_id}',
        'as' => 'task-detail-pdf',
        'uses' => 'ReportController@task_detail_pdf'
    ]);








    Route::any('typing-test-report', [
        'as' => 'typing-test-report',
        'uses' => 'TypingTestReportController@typing_test_report'
    ]);

    Route::any('generate-typing-test-report', [
        'as' => 'generate-typing-test-report',
        'uses' => 'TypingTestReportController@generate_typing_test_report'
    ]);

    Route::any('typing-test-details/{bangla_exam_id}/{english_exam_id}', [
        'as' => 'typing-test-details',
        'uses' => 'TypingTestReportController@typing_test_details'
    ]);

    Route::any('edit-typing-test-details/{id}', [
        'as' => 'edit-typing-test-details',
        'uses' => 'TypingTestReportController@edit_typing_test_details'
    ]);

    Route::any('update-typing-test-details/{id}', [
        'as' => 'update-typing-test-details',
        'uses' => 'TypingTestReportController@update_typing_test_details'
    ]);

    Route::any('typing-test-manual-checking-details/{bangla_exam_id}/{english_exam_id}', [
        'as' => 'typing-test-manual-checking-details',
        'uses' => 'TypingTestReportController@typing_test_manual_checking_details'
    ]);

    Route::any('all-graph-report', [
        'as' => 'all-graph-report',
        'uses' => 'TypingTestReportController@all_graph_report'
    ]);

    Route::any('typing-test-report-pdf/{company_id}/{designation_id}/{exam_date_from}/{exam_date_to}/{bangla_speed}/{english_speed}', [
        //'middleware' => 'acl_access:reports/meeting-detail/{company_id}/{meeting_id}',
        'as' => 'typing-test-report-pdf',
        'uses' => 'TypingTestReportController@typing_test_report_pdf'
    ]);




    Route::any('roll-wise-typing-test-report', [
        'as' => 'roll-wise-typing-test-report',
        'uses' => 'RollWiseTypingTestReportController@typing_test_report'
    ]);

    Route::any('generate-roll-wise-typing-test-report', [
        'as' => 'generate-roll-wise-typing-test-report',
        'uses' => 'RollWiseTypingTestReportController@generate_typing_test_report'
    ]);

    Route::any('roll-wise-typing-test-details/{bangla_exam_id}/{english_exam_id}', [
        'as' => 'roll-wise-typing-test-details',
        'uses' => 'RollWiseTypingTestReportController@typing_test_details'
    ]);

    Route::any('edit-roll-wise-typing-test-details/{id}', [
        'as' => 'edit-roll-wise-typing-test-details',
        'uses' => 'RollWiseTypingTestReportController@edit_typing_test_details'
    ]);

    Route::any('update-roll-wise-typing-test-details/{id}', [
        'as' => 'update-roll-wise-typing-test-details',
        'uses' => 'RollWiseTypingTestReportController@update_typing_test_details'
    ]);

    Route::any('roll-wise-typing-test-manual-checking-details/{bangla_exam_id}/{english_exam_id}', [
        'as' => 'roll-wise-typing-test-manual-checking-details',
        'uses' => 'RollWiseTypingTestReportController@typing_test_manual_checking_details'
    ]);

    Route::any('roll-wise-all-graph-report', [
        'as' => 'roll-wise-all-graph-report',
        'uses' => 'RollWiseTypingTestReportController@all_graph_report'
    ]);

    Route::any('roll-wise-typing-test-report-pdf/{company_id}/{designation_id}/{exam_date_from}/{exam_date_to}/{bangla_speed}/{english_speed}', [
        //'middleware' => 'acl_access:reports/meeting-detail/{company_id}/{meeting_id}',
        'as' => 'roll-wise-typing-test-report-pdf',
        'uses' => 'RollWiseTypingTestReportController@typing_test_report_pdf'
    ]);




    Route::any('short-typing-test-report', [
        'as' => 'short-typing-test-report',
        'uses' => 'ShortTypingTestReportController@typing_test_report'
    ]);

    Route::any('generate-short-typing-test-report', [
        'as' => 'generate-short-typing-test-report',
        'uses' => 'ShortTypingTestReportController@generate_typing_test_report'
    ]);

    Route::any('short-typing-test-details/{bangla_exam_id}/{english_exam_id}', [
        'as' => 'short-typing-test-details',
        'uses' => 'ShortTypingTestReportController@typing_test_details'
    ]);

    Route::any('edit-short-typing-test-details/{id}', [
        'as' => 'edit-short-typing-test-details',
        'uses' => 'ShortTypingTestReportController@edit_typing_test_details'
    ]);

    Route::any('update-short-typing-test-details/{id}', [
        'as' => 'update-short-typing-test-details',
        'uses' => 'ShortTypingTestReportController@update_typing_test_details'
    ]);

    Route::any('short-typing-test-manual-checking-details/{bangla_exam_id}/{english_exam_id}', [
        'as' => 'short-typing-test-manual-checking-details',
        'uses' => 'ShortTypingTestReportController@typing_test_manual_checking_details'
    ]);

    Route::any('all-short-graph-report', [
        'as' => 'all-short-graph-report',
        'uses' => 'ShortTypingTestReportController@all_graph_report'
    ]);

    Route::any('short-typing-test-report-pdf/{company_id}/{designation_id}/{exam_date_from}/{exam_date_to}/{bangla_speed}/{english_speed}', [
        //'middleware' => 'acl_access:reports/meeting-detail/{company_id}/{meeting_id}',
        'as' => 'short-typing-test-report-pdf',
        'uses' => 'ShortTypingTestReportController@typing_test_report_pdf'
    ]);



    


    Route::any('roll-wise-short-typing-test-report', [
        'as' => 'roll-wise-short-typing-test-report',
        'uses' => 'RollWiseShortTypingTestReportController@typing_test_report'
    ]);

    Route::any('generate-roll-wise-short-typing-test-report', [
        'as' => 'generate-roll-wise-short-typing-test-report',
        'uses' => 'RollWiseShortTypingTestReportController@generate_typing_test_report'
    ]);

    Route::any('roll-wise-short-typing-test-details/{bangla_exam_id}/{english_exam_id}', [
        'as' => 'roll-wise-short-typing-test-details',
        'uses' => 'RollWiseShortTypingTestReportController@typing_test_details'
    ]);

    Route::any('edit-roll-wise-short-typing-test-details/{id}', [
        'as' => 'edit-roll-wise-short-typing-test-details',
        'uses' => 'RollWiseShortTypingTestReportController@edit_typing_test_details'
    ]);

    Route::any('update-roll-wise-short-typing-test-details/{id}', [
        'as' => 'update-roll-wise-short-typing-test-details',
        'uses' => 'RollWiseShortTypingTestReportController@update_typing_test_details'
    ]);

    Route::any('roll-wise-short-typing-test-manual-checking-details/{bangla_exam_id}/{english_exam_id}', [
        'as' => 'roll-wise-short-typing-test-manual-checking-details',
        'uses' => 'RollWiseShortTypingTestReportController@typing_test_manual_checking_details'
    ]);

    Route::any('roll-wise-all-short-graph-report', [
        'as' => 'roll-wise-all-short-graph-report',
        'uses' => 'RollWiseShortTypingTestReportController@all_graph_report'
    ]);

    Route::any('roll-wise-short-typing-test-report-pdf/{company_id}/{designation_id}/{exam_date_from}/{exam_date_to}/{bangla_speed}/{english_speed}', [
        //'middleware' => 'acl_access:reports/meeting-detail/{company_id}/{meeting_id}',
        'as' => 'roll-wise-short-typing-test-report-pdf',
        'uses' => 'RollWiseShortTypingTestReportController@typing_test_report_pdf'
    ]);





    Route::any('aptitude-test-report', [
        'as' => 'aptitude-test-report',
        'uses' => 'AptitudeTestReportController@aptitude_test_report'
    ]);

    Route::any('generate-aptitude-test-report', [
        'as' => 'generate-aptitude-test-report',
        'uses' => 'AptitudeTestReportController@generate_aptitude_test_report'
    ]);

    Route::any('aptitude-test-details/{user_id}', [
        'as' => 'aptitude-test-details',
        'uses' => 'AptitudeTestReportController@aptitude_test_details'
    ]);

    Route::any('aptitude-test-report-pdf/{company_id}/{designation_id}/{exam_date}', [
        //'middleware' => 'acl_access:reports/meeting-detail/{company_id}/{meeting_id}',
        'as' => 'aptitude-test-report-pdf',
        'uses' => 'AptitudeTestReportController@aptitude_test_report_pdf'
    ]);






    Route::any('short-aptitude-test-report', [
        'as' => 'short-aptitude-test-report',
        'uses' => 'ShortAptitudeTestReportController@aptitude_test_report'
    ]);

    Route::any('generate-short-aptitude-test-report', [
        'as' => 'generate-short-aptitude-test-report',
        'uses' => 'ShortAptitudeTestReportController@generate_aptitude_test_report'
    ]);

    Route::any('short-aptitude-test-details/{user_id}', [
        'as' => 'short-aptitude-test-details',
        'uses' => 'ShortAptitudeTestReportController@aptitude_test_details'
    ]);

    Route::any('short-aptitude-test-report-pdf/{company_id}/{designation_id}/{exam_date}', [
        //'middleware' => 'acl_access:reports/meeting-detail/{company_id}/{meeting_id}',
        'as' => 'short-aptitude-test-report-pdf',
        'uses' => 'ShortAptitudeTestReportController@aptitude_test_report_pdf'
    ]);




    Route::any('attendance-sheet-report', [
        'as' => 'attendance-sheet-report',
        'uses' => 'AttendanceSheetReportController@attendance_sheet_report'
    ]);

    Route::any('generate-attendance-sheet-report', [
        'as' => 'generate-attendance-sheet-report',
        'uses' => 'AttendanceSheetReportController@generate_attendance_sheet_report'
    ]);

    Route::any('attendance-sheet-details/{user_id}', [
        'as' => 'attendance-sheet-details',
        'uses' => 'AttendanceSheetReportController@attendance_sheet_details'
    ]);

    Route::any('attendance-sheet-report-pdf/{company_id}/{exam_date_from?}/{designation_id}/{exam_date_to?}', [
        //'middleware' => 'acl_access:reports/meeting-detail/{company_id}/{meeting_id}',
        'as' => 'attendance-sheet-report-pdf',
        'uses' => 'AttendanceSheetReportController@attendance_sheet_report_pdf'
    ]);





    Route::any('roll-wise-attendance-sheet-report', [
        'as' => 'roll-wise-attendance-sheet-report',
        'uses' => 'RollWiseAttendanceSheetReportController@attendance_sheet_report'
    ]);

    Route::any('generate-roll-wise-attendance-sheet-report', [
        'as' => 'generate-roll-wise-attendance-sheet-report',
        'uses' => 'RollWiseAttendanceSheetReportController@generate_attendance_sheet_report'
    ]);

    Route::any('roll-wise-attendance-sheet-details/{user_id}', [
        'as' => 'roll-wise-attendance-sheet-details',
        'uses' => 'RollWiseAttendanceSheetReportController@attendance_sheet_details'
    ]);

    Route::any('attendance-sheet-report-pdf/{company_id}/{exam_date_from?}/{designation_id}/{exam_date_to?}', [
        //'middleware' => 'acl_access:reports/meeting-detail/{company_id}/{meeting_id}',
        'as' => 'attendance-sheet-report-pdf',
        'uses' => 'AttendanceSheetReportController@attendance_sheet_report_pdf'
    ]);


});