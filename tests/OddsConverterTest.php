<?php
class OddsConverterTest extends WP_UnitTestCase {
    public function testDecimalToFractional() {
        $this->assertEquals('3/4', \OddsCompare\Helpers\OddsConverter::decimalToFractional(1.75));
    }
}