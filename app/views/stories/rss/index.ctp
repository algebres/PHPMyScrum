<?php
$title = "";
if (@$project_info["name"] != "")
{
	$title .= h($project_info["name"]) . " | ";
}
$title .= __("Story", true);


$this->set('channel', array (  
    'title' => $title,
    'link' => $html->url('/'),  
    'description' => __("Story", true),
));  
  
echo $rss->items($stories, 'transformRSS');  
  
function transformRSS($stories) {  
    return array(  
        'title' => $stories['Story']['name'],  
        'link' => array('action' => 'view', $stories['Story']['id']),  
        'guid' => array('action' => 'view', $stories['Story']['id']),  
        'description' => $stories['Story']['description'],  
        'pubDate' => $stories['Story']['created']  
    );  
}  
?>
