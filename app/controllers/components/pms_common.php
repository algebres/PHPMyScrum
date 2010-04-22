<?php

class PmsCommonComponent extends Object
{
	function getEachStoryPoints($sprints, $stories)
	{
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
			$sprint["Sprint"]["point_per_sprint"] = $point_per_sprint;
			$sprint["Sprint"]["finished_point_per_sprint"] = $finished_point_per_sprint;
			$sprints[$key] = $sprint;
		}
		return $sprints;
	}
}
?>