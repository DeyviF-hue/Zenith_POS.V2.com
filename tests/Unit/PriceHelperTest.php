<?php

namespace Tests\Unit;

use App\Helpers\PriceHelper;
use PHPUnit\Framework\TestCase;

class PriceHelperTest extends TestCase
{
    public function testFormatMoneyDefaults()
    {
        $this->assertEquals('1,234.56 USD', PriceHelper::formatMoney(1234.56));
    }

    public function testCalculateTotalWithTaxAndDiscount()
    {
        $subtotal = 100.0; // $100
        $total = PriceHelper::calculateTotal($subtotal, 0.1, 5.0); // 10% tax, $5 discount
        $this->assertEquals(105.0, $total);
    }
}
