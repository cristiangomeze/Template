<?php

namespace Cristiangomeze\Template\Tests\Unit;

use Cristiangomeze\Template\Transforms\Transform;
use Cristiangomeze\Template\Tests\TestCase;
use Illuminate\Contracts\Support\Arrayable;

class TransformTest extends TestCase
{
    /** @test */
    public function if_the_transform_does_not_exist_the_previous_value_will_be_returned()
    {
        $values = [
            [
                'key' => 'FECHA',
                'value' => '2020-03-01',
                'transforms' => ['dont-exist', 'DateWords'],
            ],
        ];

        $this->assertTrue('2020-03-01' === Transform::make($values)->toArray()['FECHA']);
    }

    /** @test */
    public function if_collection_key_not_exist_throw_exception()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Some of the following indexes were not found: key, value, transform.');

        $values = [
            [
                'value1' => 'FECHA',
                'value2' => '2020-03-01',
                'transforms3' => ['DateWords', 'dont-exist'],
            ],
        ];

        Transform::make($values)->toArray();
    }

    /** @test */
    public function it_return_collection()
    {
        $values = [
            [
                'key' => 'FECHA',
                'value' => '2020-03-01',
                'transforms' => ['DateWords'],
            ],
        ];

        $this->assertTrue(Transform::make($values) instanceof Arrayable);
    }

    /** @test */
    public function it_can_apply_the_transform_date_letter()
    {
        \Illuminate\Support\Carbon::setLocale('es');

        $values = [
            [
                'key' => 'FECHA',
                'value' => '2019-08-08',
                'transforms' => ['DateWords'],
            ],
        ];

        $this->assertTrue(
            'Ocho (8) Días del mes de Agosto del año Dos Mil Diecinueve (2019)'
            == Transform::make($values)->toArray()['FECHA']
        );
    }

    /** @test */
    public function it_can_apply_the_transform_number_letter()
    {
        $values = [
            [
                'key' => 'MONTO',
                'value' => 105.10,
                'transforms' => ['NumberWords'],
            ],
            [
                'key' => 'MONTO_DECIMAL',
                'value' => '15000.91',
                'transforms' => ['NumberWords'],
            ],
        ];

        $this->assertTrue('RD$ 105.10, (Ciento cinco pesos dominicanos con diez centavos)' == Transform::make($values)->toArray()['MONTO']);

        $this->assertTrue('RD$ 15,000.91, (Quince mil pesos dominicanos con noventa y un centavos)' == Transform::make($values)->toArray()['MONTO_DECIMAL']);
    }

    /** @test */
    public function it_can_apply_transform_number_format()
    {
        $values = [
            [
                'key' => 'MONTO',
                'value' => 1000,
                'transforms' => ['NumberFormat:2'],
            ],
        ];

        $this->assertTrue('1,000.00' === Transform::make($values)->toArray()['MONTO']);
    }

    /** @test */
    public function it_can_apply_transform_date_format()
    {
        $values = [
            [
                'key' => 'FECHA',
                'value' => '2020-02-30',
                'transforms' => ['DateFormat:LLLL'],
            ],
        ];

        $this->assertTrue('domingo, 1 de marzo de 2020 0:00' === Transform::make($values)->toArray()['FECHA']);
    }

    /** @test */
    public function it_can_apply_transform_lowercase()
    {
        $values = [
             [
                 'key' => 'NOMBRE',
                 'value' => 'CRISTIAN GOMEZ',
                 'transforms' => ['Lowercase'],
             ],
         ];

        $this->assertTrue('cristian gomez' === Transform::make($values)->toArray()['NOMBRE']);
    }

    /** @test */
    public function it_can_apply_transform_uppercase()
    {
        $values = [
              [
                  'key' => 'NOMBRE',
                  'value' => 'cristian gomez',
                  'transforms' => ['Uppercase'],
              ],
          ];

        $this->assertTrue('CRISTIAN GOMEZ' === Transform::make($values)->toArray()['NOMBRE']);
    }

    /** @test */
    public function it_can_apply_transform_capitalize()
    {
        $values = [
               [
                   'key' => 'NOMBRE',
                   'value' => 'cristian gomez',
                   'transforms' => ['Capitalize'],
               ],
           ];

        $this->assertTrue('Cristian Gomez' === Transform::make($values)->toArray()['NOMBRE']);
    }

    /** @test */
    public function it_can_apply_transforms_lowercase_and_capitalize()
    {
        $values = [
                [
                    'key' => 'NOMBRE',
                    'value' => 'CRISTIAN GOMEZ',
                    'transforms' => ['Lowercase', 'Capitalize'],
                ],
            ];

        $this->assertTrue('Cristian Gomez' === Transform::make($values)->toArray()['NOMBRE']);
    }
}
