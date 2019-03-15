<?php
namespace ARM\Armpackage\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Anisur Rahaman Mullick <anisur.mullick@gmail.com>
 */
class PackageTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \ARM\Armpackage\Domain\Model\Package
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \ARM\Armpackage\Domain\Model\Package();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getTitleReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle()
    {
        $this->subject->setTitle('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'title',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getSubtitleReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getSubtitle()
        );
    }

    /**
     * @test
     */
    public function setSubtitleForStringSetsSubtitle()
    {
        $this->subject->setSubtitle('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'subtitle',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getBriefReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getBrief()
        );
    }

    /**
     * @test
     */
    public function setBriefForStringSetsBrief()
    {
        $this->subject->setBrief('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'brief',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getRateReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getRate()
        );
    }

    /**
     * @test
     */
    public function setRateForFloatSetsRate()
    {
        $this->subject->setRate(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'rate',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getRebate2ReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getRebate2()
        );
    }

    /**
     * @test
     */
    public function setRebate2ForFloatSetsRebate2()
    {
        $this->subject->setRebate2(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'rebate2',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getRebate3to10ReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getRebate3to10()
        );
    }

    /**
     * @test
     */
    public function setRebate3to10ForFloatSetsRebate3to10()
    {
        $this->subject->setRebate3to10(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'rebate3to10',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getRebatemt10ReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getRebatemt10()
        );
    }

    /**
     * @test
     */
    public function setRebatemt10ForFloatSetsRebatemt10()
    {
        $this->subject->setRebatemt10(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'rebatemt10',
            $this->subject,
            '',
            0.000000001
        );
    }
}
