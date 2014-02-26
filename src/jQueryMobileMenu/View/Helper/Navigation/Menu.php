<?php

namespace jQueryMobileMenu\View\Helper\Navigation;

use \Zend\Navigation\Page\AbstractPage;
use \Zend\View\Helper\Navigation\Menu as ZendNavigationHelper;

/**
 * Class Menu
 *
 * Helper for rendering menus from navigation containers
 *
 * @package jQueryMobileMenu\View\Helper\Navigation
 */
class Menu extends ZendNavigationHelper
{
    /**
     * Returns an HTML string containing an 'a' element for the given page if
     * the page's href is not empty, and a 'span' element if it is empty
     *
     * Overrides {@link AbstractHelper::htmlify()}.
     *
     * @param  \Zend\Navigation\Page\Mvc $page        page to generate HTML for
     * @param  bool                      $escapeLabel Whether or not to escape the label
     * @return string
     */
    public function htmlify(AbstractPage $page, $escapeLabel = true, $addClassToListItem = false)
    {
        // get label and title for translating
        $label = $page->getLabel();
        $title = $page->getTitle();

        // translate label and title?
        if (null !== ($translator = $this->getTranslator())) {
            $textDomain = $this->getTranslatorTextDomain();
            if (is_string($label) && !empty($label)) {
                $label = $translator->translate($label, $textDomain);
            }
            if (is_string($title) && !empty($title)) {
                $title = $translator->translate($title, $textDomain);
            }
        }

        // get attribs for element
        $attribs = array(
            'id'     => $page->getId(),
            'title'  => $title,
        );

        if ($addClassToListItem === false) {
            $attribs['class'] = $page->getClass();
        }

        // does page have a href?
        $href = $page->getHref();
        if ($href) {
            $element = 'a';
            $attribs['href']   = $href;
            $attribs['id']     = 'nav' . str_replace('/', '-', $href);
            $attribs['target'] = $page->getTarget();
        } else {
            $element = 'span';
        }

        // add extra properties to a tag
        $properties = $page->toArray();
        if (isset($properties['a_params'])) {
            $attribs = array_merge($attribs, $properties['a_params']);
            if ($page->isActive(true)) {
                $attribs['class'] = array('ui-btn-active', 'ui-state-persist');
            }
        }

        $html = '<' . $element . $this->htmlAttribs($attribs) . '>';
        if ($escapeLabel === true) {
            /** @var \Zend\View\Helper\EscapeHtml $escapeHtmlHelper */
            $escapeHtmlHelper = $this->view->plugin('escapeHtml');
            $html .= $escapeHtmlHelper($label);
        } else {
            $html .= $label;
        }
        $html .= '</' . $element . '>';

        return $html;
    }
}
