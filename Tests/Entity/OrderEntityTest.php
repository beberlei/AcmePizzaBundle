<?php

namespace Acme\PizzaBundle\Tests\Entity;

use
    Acme\PizzaBundle\Entity\Order,
    Acme\PizzaBundle\Entity\Customer,
    Doctrine\Common\Collections\ArrayCollection
;

class OrderEntityTest extends AbstractEntityTest
{
    public static function provider()
    {
        $data = array();

        $data[] = array(
            'properties' => array(
                'date'     => new \DateTime(),
                'customer' => new Customer(),
                'items'    => new ArrayCollection(),
            ),
            'errors' => array(),
        );

        $data[] = array(
            'properties' => array(),
            'errors' => array(
                'customer' => 'This value should not be blank',
            ),
        );

        return $data;
    }

    /**
     * @dataProvider provider
     */
    public function testValidation(array $properties, array $errors)
    {
        $order = new Order();

        foreach ($properties as $property => $value) {
            $order->set($property, $value);
        }

        $violations = self::$validator->validate($order);
        /* @var $violations \Symfony\Component\Validator\ConstraintViolationList */

        $this->assertEquals(count($errors), count($violations), (string) $violations);

        foreach ($errors as $property => $message) {
            $pattern = sprintf('/\.%s:\s+%s$/m', $property, $message);
            $this->assertRegExp($pattern, (string) $violations, $violations);
        }
    }
}
