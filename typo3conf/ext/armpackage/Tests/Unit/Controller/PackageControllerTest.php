<?php
namespace ARM\Armpackage\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Anisur Rahaman Mullick <anisur.mullick@gmail.com>
 */
class PackageControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \ARM\Armpackage\Controller\PackageController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\ARM\Armpackage\Controller\PackageController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllPackagesFromRepositoryAndAssignsThemToView()
    {

        $allPackages = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $packageRepository = $this->getMockBuilder(\ARM\Armpackage\Domain\Repository\PackageRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $packageRepository->expects(self::once())->method('findAll')->will(self::returnValue($allPackages));
        $this->inject($this->subject, 'packageRepository', $packageRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('packages', $allPackages);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }
}
