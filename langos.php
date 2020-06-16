<?php
/**
 * @package    Joomla - Content plugin to show values of language constants in eg an article
 * @version    1.0.0
 * @author     Artem Vasilev - Webmasterskaya
 * @copyright  Copyright (c) 2020 Webmasterskaya. All rights reserved.
 * @license    GNU General Public License version 3 or later; see LICENSE.txt
 * @link       https://webmasterskaya.xyz/
 */

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\CMSPlugin;

defined('_JEXEC') or die;

/**
 * Plug-in to show values of language constants in eg an article
 * This uses the {langos LANGUAGE_CONSTANT} syntax
 *
 * @since  3.8.1
 */
class plgContentLangos extends CMSPlugin
{
	/**
	 * Application object
	 *
	 * @var    CMSApplication
	 * @since  1.0.0
	 */
	protected $app;

	/**
	 * Database object
	 *
	 * @var    JDatabaseDriver
	 * @since  1.0.0
	 */
	protected $db;

	/**
	 * Affects constructor behavior. If true, language files will be loaded automatically.
	 *
	 * @var    boolean
	 * @since  1.0.0
	 */
	protected $autoloadLanguage = true;

	/**
	 * Plugin that shows a language constant.
	 *
	 * @param   string   $context  The context of the content being passed to the plugin.
	 * @param   object  &$item     The item object.  Note $article->text is also available
	 * @param   object  &$params   The article params
	 * @param   int      $page     The 'page' number
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	public function onContentPrepare($context, &$item, &$params, $page = 0)
	{
		// If the item has a context, overwrite the existing one
		if ($context == 'com_finder.indexer' && !empty($item->context))
		{
			$context = $item->context;
		}
		elseif ($context == 'com_finder.indexer')
		{
			// Don't run this plugin when the content is being indexed and we have no real context
			return;
		}

		// Don't run if there is no text property (in case of bad calls) or it is empty
		if (empty($item->text))
		{
			return;
		}

		// Simple performance check to determine whether bot should process further
		if (strpos($item->text, 'langos') === false)
		{
			return;
		}

		// Prepare the text
		if (isset($item->text))
		{
			$item->text = $this->prepare($item->text);
		}

		// Prepare the intro text
		if (isset($item->introtext))
		{
			$item->introtext = $this->prepare($item->introtext);
		}
	}

	/**
	 * Prepares the given string by parsing {langos} groups and replacing them.
	 *
	 * @param $string
	 *
	 * @return string|null
	 *
	 * @since 1.0.0
	 */
	protected function prepare($string)
	{
		// Search for {langos} tags and put the results into $matches.
		$regex = '/{(langos)\s+(.*?)}/i';
		preg_match_all($regex, $string, $matches, PREG_SET_ORDER);

		if (!$matches)
		{
			return $string;
		}

		foreach ($matches as $i => $match)
		{
			if ($match[1] == 'langos' && !empty($match[2]))
			{
				$string = preg_replace("|$match[0]|", Text::_(strtoupper(trim($match[2]))), $string, 1);
			}
		}

		return $string;
	}
}
