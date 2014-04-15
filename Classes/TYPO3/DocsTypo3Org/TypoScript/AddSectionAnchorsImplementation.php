<?php
namespace TYPO3\DocsTypo3Org\TypoScript;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "TYPO3.DocsTypo3Org".    *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\DocsTypo3Org\Service\ContentService;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Exception;
use TYPO3\TypoScript\Exception as TypoScriptException;
use TYPO3\TypoScript\TypoScriptObjects\TemplateImplementation;

/**
 * A TypoScript AddSectionAnchor object
 */
class AddSectionAnchorsImplementation extends TemplateImplementation {

	const ANCHOR_TEMPLATE = '<a name="@name"></a>@content';

	/**
	 * @Flow\Inject
	 * @var ContentService
	 */
	protected $contentService;

	/**
	 * The string to be processed
	 *
	 * @return string
	 */
	public function getValue() {
		return $this->tsValue('value');
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	public function evaluate() {
		$text = $this->getValue();
		if (!is_string($text)) {
			throw new Exception(sprintf('Only strings can be processed by this TypoScript object, given: "%s".', gettype($text)), 1397579446);
		}
		$matches = array();
		preg_match_all('/<h\d>([^<]*)<\/h\d>/iU', $text, $matches);
		foreach ($matches[0] as $key => $value) {
			$anchorName = $this->contentService->slugify($matches[1][$key]);
			$matches[1][$key] = str_replace(array('@name', '@content'), array($anchorName, $value), self::ANCHOR_TEMPLATE);
		}
		$text = str_replace($matches[0], $matches[1], $text);

		return $text;
	}
}