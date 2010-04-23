<?php

class PmsCommonComponent extends Object
{
	function getEachStoryPoints($sprints, $stories)
	{
		$total_story_point = 0;
		foreach($stories as $story)
		{
			$total_story_point += $story["Story"]["storypoints"];
		}

		$total_finished =0;
		foreach($sprints as $key => $sprint)
		{
			$point_per_sprint = 0;
			$finished_point_per_sprint = 0;
			foreach($stories as $story)
			{
				if($story["Story"]["sprint_id"] == $sprint["Sprint"]["id"])
				{
					$point_per_sprint += $story["Story"]["storypoints"];
					if($story["Story"]["resolution_id"] == RESOLUTION_DONE)
					{
						$finished_point_per_sprint += $story["Story"]["storypoints"];
					}
				}
			}
			$total_finished += $finished_point_per_sprint;
			$sprint["Sprint"]["point_per_sprint"] = $point_per_sprint;
			$sprint["Sprint"]["finished_point_per_sprint"] = $finished_point_per_sprint;
			$sprint["Sprint"]["total_remaining_point"] = $total_story_point - $total_finished;
			$sprints[$key] = $sprint;
		}
		return $sprints;
	}
}
?>