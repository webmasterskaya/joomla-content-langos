<?php

/**
 * @package    Joomla - Content plugin to show values of language constants in eg an article
 * @version    1.0.0
 * @author     Artem Vasilev - Webmasterskaya
 * @copyright  Copyright (c) 2020 Webmasterskaya. All rights reserved.
 * @license    GNU General Public License version 3 or later; see LICENSE.txt
 * @link       https://webmasterskaya.xyz/
 */

namespace Joomla\Plugin\Content\Langos\Extension;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Event\Event;
use Joomla\Event\SubscriberInterface;

\defined('_JEXEC') or die;

/**
 * Plug-in to show values of language constants in eg an article
 * This uses the {langos LANGUAGE_CONSTANT} syntax
 *
 * @since  3.8.1
 */
final class Plugin extends CMSPlugin implements SubscriberInterface
{
    /**
     * Affects constructor behavior. If true, language files will be loaded automatically.
     *
     * @var    boolean
     * @since  1.0.0
     */
    protected $autoloadLanguage = true;

    /**
     * Returns an array of events this subscriber will listen to.
     *
     * @return array
     *
     * @since   2.0.0
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'onContentPrepare' => 'onContentPrepare',
        ];
    }

    /**
     * Plugin that shows a language constant.
     *
     * @param   Event  $event  The event object
     *
     * @return  void
     *
     * @since   1.0.0
     */
    public function onContentPrepare(Event $event): void
    {
        [$context, $item, $params, $page] = $event->getArguments();

        // If the item has a context, overwrite the existing one
        if ($context === 'com_finder.indexer') {
            // Don't run this plugin when the content is being indexed and we have no real context
            return;
        }

        // Don't run if there is no text property (in case of bad calls) or it is empty
        if (empty($item->text)) {
            return;
        }

        // Simple performance check to determine whether bot should process further
        if (str_contains($item->text, 'langos') === false) {
            return;
        }

        // Prepare the text
        $item->text = $this->prepare($item->text);

        // Prepare the intro text
        if (isset($item->introtext)) {
            $item->introtext = $this->prepare($item->introtext);
        }
    }

    /**
     * Prepares the given string by parsing {langos} groups and replacing them.
     *
     * @param   string  $string  The string to prepare
     *
     * @return  string
     *
     * @since   1.0.0
     */
    protected function prepare(string $string): string
    {
        // Search for {langos} tags and put the results into $matches.
        $regex = '/{(langos)\s+([A-Z\d_]+)(?:\s*,\s*(.*?))?}/i';
        preg_match_all($regex, $string, $matches, PREG_SET_ORDER);

        if (!$matches) {
            return $string;
        }

        $language = $this->getApplication()->getLanguage();

        foreach ($matches as $match) {
            if ($match[1] === 'langos' && !empty($match[2])) {
                $match[2] = preg_replace('/^\s+/u', '', $match[2]);

                if (!empty($match[3])) {
                    $match[3] = preg_replace('/^\s+/u', '', $match[3]);
                    $language->load($match[3]);
                }

                $string = preg_replace("|$match[0]|", Text::_(strtoupper($match[2])), $string, 1);

                $string = str_replace('%date%', HTMLHelper::_('date', 'now', 'Y'), $string);
                $string = str_replace('%sitename%', $this->getApplication()->get('sitename', ''), $string);
            }
        }

        return $string;
    }
}
