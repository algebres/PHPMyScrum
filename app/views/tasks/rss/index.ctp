<?php
$title = "";
if (@$project_info["name"] != "")
{
	$title .= h($project_info["name"]) . " | ";
}
$title .= __("Task", true);


$this->set('channel', array (  
    'title' => $title,
    'link' => $html->url('/'),  
    'description' => __("Task", true),
));  
  
echo $rss->items($tasks, 'transformRSS');  
  
function transformRSS($tasks) {  
    return array(  
        'title' => $tasks['Task']['name'],  
        'link' => array('action' => 'view', $tasks['Task']['id']),  
        'guid' => array('action' => 'view', $tasks['Task']['id']),  
        'description' => $tasks['Story']['name'] ." \n" . $tasks['Task']['description'],  
        'pubDate' => $tasks['Task']['created']  
    );  
}  
?>
