<?php
/**
 * @package    Joomla - Content languages constants
 * @version    1.0.0
 * @author     Artem Vasilev - Webmasterskaya
 * @copyright  Copyright (c) 2020 Webmasterskaya. All rights reserved.
 * @license    GNU General Public License version 3 or later; see LICENSE.txt
 * @link       https://webmasterskaya.xyz/
 */

defined('_JEXEC') or die;

class plgContentLangosInstallerScript
{
	protected $minJoomla = '3.8.1';

	/**
	 * @param $type
	 * @param $parent
	 *
	 * @return bool|void
	 *
	 * @throws Exception
	 * @since 1.0.0
	 */
	function preflight($type, $parent)
	{
		jimport('joomla.version');
		// Check compatible Joomla version
		$jversion = new JVersion();

		if (!$jversion->isCompatible($this->minJoomla))
		{
			JFactory::getApplication()->enqueueMessage(JText::sprintf('PLG_CONTENT_WRONG_JOOMLA', $this->minJoomla),
				'error');

			return false;
		}
	}

	/**
	 * @param $type
	 * @param $parent
	 *
	 *
	 * @throws Exception
	 * @since 1.0.0
	 */
	function postflight($type, $parent)
	{
		JFactory::getApplication()->enqueueMessage(JText::_('PLG_CONTENT_WELCOME_MESSAGE'), 'notice');
	}
}