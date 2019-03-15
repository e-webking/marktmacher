<?php
namespace ARM\Armpackage\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Anisur Rahaman Mullick <anisur.mullick@gmail.com>
 */
class RegistrationTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \ARM\Armpackage\Domain\Model\Registration
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \ARM\Armpackage\Domain\Model\Registration();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getFeuserReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getFeuser()
        );
    }

    /**
     * @test
     */
    public function setFeuserForIntSetsFeuser()
    {
        $this->subject->setFeuser(12);

        self::assertAttributeEquals(
            12,
            'feuser',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getQtyReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getQty()
        );
    }

    /**
     * @test
     */
    public function setQtyForIntSetsQty()
    {
        $this->subject->setQty(12);

        self::assertAttributeEquals(
            12,
            'qty',
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
    public function getAmountReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getAmount()
        );
    }

    /**
     * @test
     */
    public function setAmountForFloatSetsAmount()
    {
        $this->subject->setAmount(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'amount',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getDiscountReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getDiscount()
        );
    }

    /**
     * @test
     */
    public function setDiscountForFloatSetsDiscount()
    {
        $this->subject->setDiscount(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'discount',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getVatReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getVat()
        );
    }

    /**
     * @test
     */
    public function setVatForFloatSetsVat()
    {
        $this->subject->setVat(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'vat',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getTotalReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getTotal()
        );
    }

    /**
     * @test
     */
    public function setTotalForFloatSetsTotal()
    {
        $this->subject->setTotal(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'total',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getPackageReturnsInitialValueForPackage()
    {
        self::assertEquals(
            null,
            $this->subject->getPackage()
        );
    }

    /**
     * @test
     */
    public function setPackageForPackageSetsPackage()
    {
        $packageFixture = new \ARM\Armpackage\Domain\Model\Package();
        $this->subject->setPackage($packageFixture);

        self::assertAttributeEquals(
            $packageFixture,
            'package',
            $this->subject
        );
    }
}
