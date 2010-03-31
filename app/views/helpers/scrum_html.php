<?php
/* /app/views/helpers/scrumlink.php */

class ScrumHtmlHelper extends AppHelper {
	var $helpers = array('Html');

	/**
	 * 画像付きリンク
	 *
	 * <a href="<?php echo $html->url("/tasks/edit/" . $task['Task']['id']); ?>"><?php echo $html->image('edit.png'); ?></a>
	 * <a href="<?php echo $html->url(array('controller' => "tasks", 'action' => "delete", $id)); ?>" onclick="return confirm('<?php echo sprintf(__('hoge # %s?', true), $id); ?>');"><?php echo $this->Html->image('delete.png'); ?></a>
	 *
	 */
	function link($image_path, $image_opt, $url, $confirm_message = "") 
	{
		//return "aaa";
		$result = "";

		if($confirm_message != "")
		{
			$result .= sprintf('<a href="%s" onclick="return confirm(\'%s\');">', $this->Html->url($url), $confirm_message);
		}
		else
		{
			$result .= sprintf('<a href="%s">', $this->Html->url($url));
		}
		$result .= $this->Html->image($image_path, $image_opt);
		$result .= "</a>";

		return $result;
	}
}
?>