<?php

namespace Acme\PizzaBundle\Tests\Entity;

use
    Acme\PizzaBundle\Entity\Customer
;

class CustomerEntityTest extends AbstractEntityTest
{
    public static function provider()
    {
        $data = array();

        $data[] = array(
            'properties' => array(
                'name'   => 'Patricia S. Kemp',
                'street' => '3347 Duck Creek Road',
                'city'   => 'Palo Alto, CA 94306',
                'phone'  => '650-813-0200',
            ),
            'errors' => array(),
        );

        $data[] = array(
            'properties' => array(),
            'errors' => array(
                'name'   => 'This value should not be blank',
                'street' => 'This value should not be blank',
                'city'   => 'This value should not be blank',
                'phone'  => 'This value should not be blank',
            ),
        );

        return $data;
    }

    /**
     * @dataProvider provider
     */
    public function testValidation(array $properties, array $errors)
    {
        $customer = new Customer();

        foreach ($properties as $property => $value) {
            $customer->set($property, $value);
        }

        $violations = self::$validator->validate($customer, array('Customer'));
        /* @var $violations \Symfony\Component\Validator\ConstraintViolationList */

        $this->assertEquals(count($errors), count($violations), (string) $violations);

        foreach ($errors as $property => $message) {
            $pattern = sprintf('/\.%s:\s+%s$/m', $property, $message);
            $this->assertRegExp($pattern, (string) $violations, $violations);
        }
    }
}
