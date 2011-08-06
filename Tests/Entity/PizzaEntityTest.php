<?php

namespace Acme\PizzaBundle\Tests\Entity;

use
    Acme\PizzaBundle\Entity\Pizza
;

class PizzaEntityTest extends AbstractEntityTest
{
    public static function provider()
    {
        $data = array();

        $data[] = array(
            'properties' => array(
                'name'  => 'Big Sicilian',
                'price' => 13.40,
            ),
            'errors' => array(),
        );

        $data[] = array(
            'properties' => array(
                'name'  => 'Big Sicilian',
                'price' => '13.40',
            ),
            'errors' => array(),
        );

        $data[] = array(
            'properties' => array(),
            'errors' => array(
                'name'  => 'This value should not be blank',
                'price' => 'This value should not be blank',
            ),
        );

        $data[] = array(
            'properties' => array(
                'name'  => 'Big',
                'price' => 'azerty',
            ),
            'errors' => array(
                'name'  => 'This value is too short. It should have 5 characters or more',
                'price' => 'This value should be a valid number',
            ),
        );

        $data[] = array(
            'properties' => array(
                'name'  => 'Big Sicilian',
                'price' => -13.40,
            ),
            'errors' => array(
                'price' => 'This value should be 2 or more',
            ),
        );

        return $data;
    }

    /**
     * @dataProvider provider
     */
    public function testValidation(array $properties, array $errors)
    {
        $pizza = new Pizza();

        foreach ($properties as $property => $value) {
            $pizza->set($property, $value);
        }

        $violations = self::$validator->validate($pizza);
        /* @var $violations \Symfony\Component\Validator\ConstraintViolationList */

        $this->assertEquals(count($errors), count($violations), (string) $violations);

        foreach ($errors as $property => $message) {
            $pattern = sprintf('/\.%s:\s+%s$/m', $property, $message);
            $this->assertRegExp($pattern, (string) $violations, $violations);
        }
    }
}
