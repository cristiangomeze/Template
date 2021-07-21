<?php

namespace Cristiangomeze\Template\Tests\Unit;

use Illuminate\Contracts\Support\Arrayable;
use Cristiangomeze\Template\Filters\Filter;
use Cristiangomeze\Template\Tests\TestCase;

class FilterTest extends TestCase
{
    /** @test */
    function if_the_filter_does_not_exist_the_previous_value_will_be_returned()
    {
        $values = [
            [
                'key' => 'FECHA',
                'value' => '2020-03-01',
                'filters' => ['dont-exist', 'DateWords']
            ]
        ];

        $this->assertTrue('2020-03-01' === Filter::make($values)->toArray()['FECHA']);
    }

    /** @test */
    function if_collection_key_not_exist_throw_exception()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Some of the following indexes were not found: key, value, filter.');

        $values = [
            [
                'value1' => 'FECHA',
                'value2' => '2020-03-01',
                'filters3' => ['DateWords', 'dont-exist']
            ]
        ];

        Filter::make($values)->toArray();
    }

    /** @test */
    function it_return_collection()
    {
        $values = [
            [
                'key' => 'FECHA',
                'value' => '2020-03-01',
                'filters' => ['DateWords']
            ]
        ];

        $this->assertTrue(Filter::make($values) instanceof Arrayable);
    }

    /** @test */
    function it_can_apply_the_filter_date_letter()
    {
        \Illuminate\Support\Carbon::setLocale('es');

        $values = [
            [
                'key' => 'FECHA',
                'value' => '2019-08-08',
                'filters' => ['DateWords']
            ]
        ];

        $this->assertTrue(
            'Ocho (8) Días del mes de Agosto del año Dos Mil Diecinueve (2019)'
            == Filter::make($values)->toArray()['FECHA']
        );
    }

    /** @test */
    function it_can_apply_the_filter_number_letter()
    {
        $values = [
            [
                'key' => 'MONTO',
                'value' => 105.10,
                'filters' => ['NumberWords']
            ],
            [
                'key' => 'MONTO_DECIMAL',
                'value' => '15000.91',
                'filters' => ['NumberWords']
            ]
        ];

        $this->assertTrue('RD$ 105.10, (Ciento cinco pesos dominicanos con diez centavos)' == Filter::make($values)->toArray()['MONTO']);

        $this->assertTrue('RD$ 15,000.91, (Quince mil pesos dominicanos con noventa y un centavos)' == Filter::make($values)->toArray()['MONTO_DECIMAL']);
    }

    /** @test */
    function it_can_apply_filter_number_format()
    {
        $values = [
            [
                'key' => 'MONTO',
                'value' => 1000,
                'filters' => ['NumberFormat:2']
            ]
        ];

        $this->assertTrue('1,000.00' === Filter::make($values)->toArray()['MONTO']);
    }

    /** @test */
    function it_can_apply_filter_date_format()
    {
        $values = [
            [
                'key' => 'FECHA',
                'value' => '2020-02-30',
                'filters' => ['DateFormat:LLLL']
            ]
        ];

        $this->assertTrue('domingo, 1 de marzo de 2020 0:00' === Filter::make($values)->toArray()['FECHA']);
    }

     /** @test */
     function it_can_apply_filter_lowercase()
     {
         $values = [
             [
                 'key' => 'NOMBRE',
                 'value' => 'CRISTIAN GOMEZ',
                 'filters' => ['Lowercase']
             ]
         ];
 
         $this->assertTrue('cristian gomez' === Filter::make($values)->toArray()['NOMBRE']);
     }

      /** @test */
      function it_can_apply_filter_uppercase()
      {
          $values = [
              [
                  'key' => 'NOMBRE',
                  'value' => 'cristian gomez',
                  'filters' => ['Uppercase']
              ]
          ];
  
          $this->assertTrue('CRISTIAN GOMEZ' === Filter::make($values)->toArray()['NOMBRE']);
      }

       /** @test */
       function it_can_apply_filter_capitalize()
       {
           $values = [
               [
                   'key' => 'NOMBRE',
                   'value' => 'cristian gomez',
                   'filters' => ['Capitalize']
               ]
           ];
   
           $this->assertTrue('Cristian Gomez' === Filter::make($values)->toArray()['NOMBRE']);
       }

        /** @test */
        function it_can_apply_filters_lowercase_and_capitalize()
        {
            $values = [
                [
                    'key' => 'NOMBRE',
                    'value' => 'CRISTIAN GOMEZ',
                    'filters' => ['Lowercase', 'Capitalize']
                ]
            ];
    
            $this->assertTrue('Cristian Gomez' === Filter::make($values)->toArray()['NOMBRE']);
        }
}
