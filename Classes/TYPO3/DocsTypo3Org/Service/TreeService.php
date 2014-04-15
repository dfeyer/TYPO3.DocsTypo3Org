<?php
namespace TYPO3\DocsTypo3Org\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "TYPO3.DocsTypo3Org".    *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Exception;
use TYPO3\TypoScript\Exception as TypoScriptException;

/**
 * Tree Service
 */
class TreeService {

	/**
	 * @param array $elements
	 * @param integer $parentIdentifier
	 * @return array
	 * @throws Exception
	 */
	public function buildTree(array &$elements, $parentIdentifier = 0) {
		$branch = array();

		foreach ($elements as $key => $element) {
			if (empty($element['identifier'])) {
				throw new Exception('Element must have a identifier key', 1397478060);
			}
			if ($element['parentIdentifier'] === $element['identifier']) {
				throw new Exception('Parent Identifier must be different from the current identifier', 1397479248);
			}
			if ($element['parentIdentifier'] == $parentIdentifier) {
				$children = $this->buildTree($elements, $element['identifier']);
				if ($children !== array()) {
					$element['subItems'] = $children;
				}
				$branch[$element['identifier']] = $element;
				unset($elements[$key]);
			}
		}

		return $branch;
	}

}