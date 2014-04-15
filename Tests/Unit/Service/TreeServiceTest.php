<?php
namespace TYPO3\DocsTypo3Org\Tests\Unit\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "TYPO3.DocsTypo3Org".    *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\DocsTypo3Org\Service\TreeService;

/**
 * Testcase for the "TreeService"
 *
 */
class TreeServiceTest extends \TYPO3\Flow\Tests\UnitTestCase {

	/**
	 * @test
	 * @expectedException \TYPO3\Flow\Exception
	 */
	public function buildTreeReturnAnExceptionIfTheIdentifierKeyIsEmpty() {
		$service = new TreeService();
		$sourceArray = array('foo');
		$service->buildTree($sourceArray);
	}

	/**
	 * @test
	 * @expectedException \TYPO3\Flow\Exception
	 */
	public function buildTreeParentIdentifierMustBeDifferentFromIdentifier() {
		$service = new TreeService();
		$sourceArray = array(array(array(
			'identifier' => 'B',
			'parentIdentifier' => 'B'
		)));
		$service->buildTree($sourceArray);
	}

	public function buildTreeConvertArrayToHierarchicalTreeDataProvider() {
		return array(
			array(
				'sourceArray' => array(
					array(
						'identifier' => 'A',
						'parentIdentifier' => NULL
					)
				),
				'expectedTree' => array(
					'A' => array(
						'identifier' => 'A',
						'parentIdentifier' => NULL
					)
				)
			),
			array(
				'sourceArray' => array(
					array(
						'identifier' => 'A',
						'parentIdentifier' => NULL
					),
					array(
						'identifier' => 'B',
						'parentIdentifier' => NULL
					)
				),
				'expectedTree' => array(
					'A' => array(
						'identifier' => 'A',
						'parentIdentifier' => NULL
					),
					'B' => array(
						'identifier' => 'B',
						'parentIdentifier' => NULL
					)
				)
			),
			array(
				'sourceArray' => array(
					array(
						'identifier' => 'A',
						'parentIdentifier' => NULL
					),
					array(
						'identifier' => 'B',
						'parentIdentifier' => 'A'
					)
				),
				'expectedTree' => array(
					'A' => array(
						'identifier' => 'A',
						'parentIdentifier' => NULL,
						'subItems' => array(
							'B' => array(
								'identifier' => 'B',
								'parentIdentifier' => 'A'
							)
						)
					)
				)
			),
			array(
				'sourceArray' => array(
					array(
						'identifier' => 'A',
						'parentIdentifier' => NULL
					),
					array(
						'identifier' => 'B',
						'parentIdentifier' => 'A'
					),
					array(
						'identifier' => 'C',
						'parentIdentifier' => 'A'
					),
					array(
						'identifier' => 'D',
						'parentIdentifier' => 'C'
					),
					array(
						'identifier' => 'E',
						'parentIdentifier' => 'D'
					)
				),
				'expectedTree' => array(
					'A' => array(
						'identifier' => 'A',
						'parentIdentifier' => NULL,
						'subItems' => array(
							'B' => array(
								'identifier' => 'B',
								'parentIdentifier' => 'A'
							),
							'C' => array(
								'identifier' => 'C',
								'parentIdentifier' => 'A',
								'subItems' => array(
									'D' => array(
										'identifier' => 'D',
										'parentIdentifier' => 'C',
										'subItems' => array(
											'E' => array(
												'identifier' => 'E',
												'parentIdentifier' => 'D',
											)
										)
									)
								)
							)
						)
					)
				)
			)
		);
	}

	/**
	 * @test
	 * @param array $sourceArray
	 * @param array $expectedTree
	 * @dataProvider buildTreeConvertArrayToHierarchicalTreeDataProvider
	 */
	public function buildTreeConvertArrayToHierarchicalTree(array $sourceArray, array $expectedTree) {
		$service = new TreeService();
		$this->assertSame($expectedTree, $service->buildTree($sourceArray));
	}
}
