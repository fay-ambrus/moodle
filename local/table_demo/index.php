<?php
require('../../config.php');

require_login();
require_admin();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/table_demo/index.php'));
$PAGE->set_title(get_string('title', 'local_table_demo'));
$PAGE->set_heading(get_string('title', 'local_table_demo'));

$PAGE->requires->css(new moodle_url('https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css'));
$PAGE->requires->js_call_amd('local_table_demo/main', 'init');

global $DB;

$users = $DB->get_records('user', ['deleted' => 0], 'email ASC',
                        'id, email, firstname, lastname');

// Add data on membership data to user
foreach ($users as $user) {
    $groups_members = $DB->get_records('groups_members', ['userid' => $user->id], null, 'groupid');
    $temp_array = array();
    foreach ($groups_members as $group_memeber) {
        $groups = $DB->get_records('groups', ['id' => $group_memeber->groupid], null, 'name');
        foreach ($groups as $group) {
            array_push( $temp_array, $group->name);
        }
    }
    $user->groups = implode(', ', $temp_array);
}

$users_array = array_map(function($u) {
    return [
        'id' => $u->id,
        'email' => $u->email,
        'name' => implode(' ', [$u->firstname, $u->lastname]),
        'groups' => $u->groups
    ];
}, $users);

echo $OUTPUT->header();
echo '<pre>';
print_r($users_array);
echo '</pre>';
echo $OUTPUT->render_from_template('local_table_demo/main_page', ['users' => array_values($users_array)]);
echo $OUTPUT->footer();
