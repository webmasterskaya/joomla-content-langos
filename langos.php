<?php
/**
 * @package    joomla-contnent-langs
 *
 * @author     Артём <your@email.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       http://your.url.com
 */

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\CMSPlugin;

defined('_JEXEC') or die;

/**
 * Joomla-contnent-langs plugin.
 *
 * @package   joomla-contnent-langs
 * @since     1.0.0
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
	 * onAfterInitialise.
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
			$item->text = $this->prepare($item->text, $context, $item);
		}

		// Prepare the intro text
		if (isset($item->introtext))
		{
			$item->introtext = $this->prepare($item->introtext, $context, $item);
		}
	}

	protected function prepare($string, $context, $item)
	{
		// Search for {field ID} or {fieldgroup ID} tags and put the results into $matches.
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
