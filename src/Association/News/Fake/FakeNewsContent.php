<?php

declare(strict_types=1);

namespace Francken\Association\News\Fake;

use Faker\Generator;

final class FakeNewsContent
{
    private Generator $faker;

    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    public function generate() : string
    {
        $header = function () : string {
            if ($this->faker->boolean(20)) {
                return '<h3>' . $this->faker->sentence() . '</h3>';
            }

            return '';
        };

        $smallHeader = function () : string {
            if ($this->faker->boolean(30)) {
                return '<h4>' . $this->faker->sentence() . '</h4>';
            }

            return '';
        };

        $paragraph = fn () : string => '<p>' . $this->faker->paragraph(
            $this->faker->numberBetween(5, 11)
        ) . '</p>';

        $equations = function () : string {
            $equations = [
                '
                \[
                H(x, y) = \frac{1}{2} y^2 + V(x).
                \]
',
                '
                \(
                    \frac{df}{dt} = (\frac{\partial}{\partial t} + \nabla_x + \nabla_\xi) f(x, \xi, t) = \Omega(f)
                \)
',
                '
                $$
                f(x) = \int_{-\infty}^\infty
                \hat f(\xi)\,e^{2 \pi i \xi x}
                \,d\xi
                $$
'
            ];

            return $this->faker->randomElement($equations);
        };

        $image = function () : string {
            if ($this->faker->boolean(30)) {
                return '<img class="img-fluid my-3" src="http://pipsum.com/' . $this->faker->numberBetween(800, 1200) . 'x' . $this->faker->numberBetween(100, 600) . '.jpg">';
            }

            return '';
        };

        return array_reduce(
            array_map(
                fn (int $paragraphNumber) : string => $header() . $smallHeader() . $paragraph() . $equations() . $image(),
                range(0, (int)$this->faker->numberBetween(3, 8))
            ),
            fn ($content, $current) : string => $content .= $current,
            ''
        );
    }
}
