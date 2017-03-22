<?php
/* For licensing terms, see /license.txt */

/**
 *	@package chamilo.tracking
 */

/* INIT SECTION */

$pathopen = isset($_REQUEST['pathopen']) ? $_REQUEST['pathopen'] : null;

// Language files that need to be included.
$language_file = array('admin', 'tracking', 'scorm', 'exercice');

// Including the global initialization file
require_once '../inc/global.inc.php';
$current_course_tool = TOOL_TRACKING;

$course_info = api_get_course_info(api_get_course_id());

if (!empty($course_info)) {
    //api_protect_course_script();
}

$from_myspace = false;
$from = isset($_GET['from']) ? $_GET['from'] : null;

// Starting the output buffering when we are exporting the information.

$session_id = intval($_REQUEST['id_session']);

if ($from == 'myspace') {
    $from_myspace = true;
    $this_section = "session_my_space";
} else {
    $this_section = SECTION_COURSES;
}

// Access restrictions.
$is_allowedToTrack = api_is_platform_admin() || api_is_allowed_to_create_course() || api_is_session_admin() || api_is_drh() || api_is_course_tutor();

if (!$is_allowedToTrack) {
    api_not_allowed(true);
    exit;
}


// Including additional libraries.


$view = (isset($_REQUEST['view']) ? $_REQUEST['view'] : '');
$nameTools = get_lang('ToolIndividualise');

// Display the header.
Display::display_header($nameTools, 'indivi');

// getting all the students of the course
if (empty($session_id)) {
    // Registered students in a course outside session.
    $a_students = CourseManager :: get_student_list_from_course_code(api_get_course_id());
} else {
    // Registered students in session.
    $a_students = CourseManager :: get_student_list_from_course_code(api_get_course_id(), true, api_get_session_id());
}

$nbStudents = count($a_students);

// Getting all the additional information of an additional profile field.
if (isset($_GET['additional_profile_field']) && is_numeric($_GET['additional_profile_field'])) {
    $user_array = array();
    foreach ($a_students as $key => $item) {
        $user_array[] = $key;
    }
    // Fetching only the user that are loaded NOT ALL user in the portal.
    $additional_user_profile_info = TrackingCourseLog::get_addtional_profile_information_of_field_by_user($_GET['additional_profile_field'],$user_array);
    $extra_info = UserManager::get_extra_field_information($_GET['additional_profile_field']);
}


/* MAIN CODE */
echo '<a >'.get_lang('langSeeIndividualTracking').'</a>&nbsp;';
echo '<div class="actions">';

echo '<a href="../horaire/index.php"><img align="absbottom" src="../img/calendar_week.gif">'.get_lang('Horaire').'</a>&nbsp;';
echo '<a href="../horaire/config_mod.php"><img align="absbottom" src="../img/icons/22/settings.png">'.get_lang('config_mod').'</a>&nbsp;';


Display::display_footer();
