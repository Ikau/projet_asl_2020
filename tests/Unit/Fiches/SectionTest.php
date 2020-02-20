<?php

namespace Tests\Unit\Modeles;


use App\Modeles\Fiches\Section;
use App\Utils\Constantes;
use Faker\Factory as Faker;
use Tests\TestCase;

class SectionTest extends TestCase
{
    /**
     * Test du constructeur du modele Eloquent
     */
    public function testConstructeurEloquent()
    {
        $section = new Section;

        $attributsTests = [
            Section::COL_CHOIX     => Constantes::STRING_VIDE,
            Section::COL_CRITERES  => Constantes::STRING_VIDE,
            Section::COL_INTITULE  => Constantes::STRING_VIDE,
            Section::COL_MODELE_ID => Constantes::ID_VIDE,
            Section::COL_ORDRE     => Constantes::INT_VIDE,
        ];

        $this->verifieIntegriteConstructeurEloquent($attributsTests, $section, Section::NOM_TABLE);
    }

    /**
     * @dataProvider getPointsProvider
     * @param float $attendu La valeur du choix attendu
     * @param array $choix Array decrivant un contenu aleatoire de choix
     * @param int $index L'index sur lequel le choix est present
     */
    public function testGetPoints(float $attendu, array $choix, int $index)
    {
        // Creation d'une section
        $section = factory(Section::class)->make([
            Section::COL_CHOIX => $choix
        ]);

        // Test
        $this->assertEquals($attendu, $section->getPoints($index));
    }

    public function getPointsProvider()
    {
        $faker = Faker::create();

        $attendu1 = $faker->randomFloat(1, 0, 3);
        $attendu2 = $faker->randomFloat(1, 0, 3);
        $attendu3 = $faker->randomFloat(1, 0, 3);

        $choix1 = [
            0 => [$faker->randomFloat(1, 0, 3), 'intitule'],
            1 => [$attendu1, 'intitule'],
        ];

        $choix2 = [
            0 => [$faker->randomFloat(1, 0, 3), 'intitule'],
            1 => [$faker->randomFloat(1, 0, 3), 'intitule'],
            2 => [$attendu2, 'intitule'],
        ];

        $choix3 = [
            0 => [$faker->randomFloat(1, 0, 3), 'intitule'],
            1 => [$faker->randomFloat(1, 0, 3), 'intitule'],
            2 => [$faker->randomFloat(1, 0, 3), 'intitule'],
            3 => [$attendu3, 'intitule'],
        ];

        return [
            'Test manuel 1' => [$attendu1, $choix1, 1],
            'Test manuel 2' => [$attendu2, $choix2, 2],
            'Test manuel 3' => [$attendu3, $choix3, 3],
        ];
    }


    /**
     * @dataProvider getBaremeProvider
     * @param array $array Array decrivant un contenu aleatoire de choix
     * @param float $attendu La valeur du choix attendu
     */
    public function testGetBareme(float $attendu, array $choix, array $criteres)
    {
        $faker = Faker::create();

        // Creation d'une section
        $section = factory(Section::class)->make([
            Section::COL_CHOIX    => $choix,
            Section::COL_CRITERES => $criteres
        ]);

        // Test
        $this->assertEquals($attendu, $section->getBareme());
    }

    public function getBaremeProvider()
    {
        $faker = Faker::create();

        // Set des criteres
        $nbCriteres = 5;
        $criteres   = [];
        for($i=0; $i<5; $i++)
        {
            $criteres[] = $faker->word;
        }

        // Creation de choix
        $attendu1 = 4.0;
        $attendu2 = 5.0;
        $attendu3 = 6.0;

        $choix1 = [
            0 => [$faker->randomFloat(1, 0, 3), 'intitule'],
            1 => [$faker->randomFloat(1, 0, 3), 'intitule'],
            2 => [$faker->randomFloat(1, 0, 3), 'intitule'],
            3 => [$attendu1, 'intitule'],
        ];

        $choix2 = [
            0 => [$faker->randomFloat(1, 0, 3), 'intitule'],
            1 => [$faker->randomFloat(1, 0, 3), 'intitule'],
            2 => [$faker->randomFloat(1, 0, 3), 'intitule'],
            3 => [$attendu2, 'intitule'],
        ];

        $choix3 = [
            0 => [$faker->randomFloat(1, 0, 3), 'intitule'],
            1 => [$faker->randomFloat(1, 0, 3), 'intitule'],
            2 => [$faker->randomFloat(1, 0, 3), 'intitule'],
            3 => [$attendu3, 'intitule'],
        ];

        return [
            'Test manuel 1' => [$attendu1 * $nbCriteres, $choix1, $criteres],
            'Test manuel 2' => [$attendu2 * $nbCriteres, $choix2, $criteres],
            'Test manuel 3' => [$attendu3 * $nbCriteres, $choix3, $criteres],
        ];
    }

    /**
     * @dataProvider getNoteSectionProvider
     */
    public function testGetNoteSection(float $attendu, array $notation, array $criteres, array $choix)
    {
        // Creation d'une section
        $section = factory(Section::class)->make([
            Section::COL_CRITERES => $criteres,
            Section::COL_CHOIX    => $choix
        ]);

        // Test
        $this->assertEquals($attendu, $section->getNoteSection($notation));
    }

    public function getNoteSectionProvider()
    {
        $faker = Faker::create();

        // Set des criteres
        $nbCriteres = 5;
        $criteres   = [];
        for($i=0; $i<5; $i++)
        {
            $criteres[] = $faker->word;
        }

        // Creation de choix
        $choix1 = [
            0 => [0, 'intitule'],
            1 => [1, 'intitule'],
            2 => [2, 'intitule'],
            3 => [3, 'intitule'],
        ];

        $choix2 = [
            0 => [1, 'intitule'],
            1 => [2, 'intitule'],
            2 => [4, 'intitule'],
            3 => [8, 'intitule'],
        ];

        // Creation de la notation
        $notation = [0, 1, 2, 3, 3];
        // Pour choix1 === 0+1+2+3+3 = 9
        // Pour choix2 === 1+2+4+8+8 = 23

        // [float $attendu, array $notation, array $criteres, array $choix]
        return [
            'Test manuel 1' => [9.0, $notation, $criteres, $choix1],
            'Test manuel 2' => [23.0, $notation, $criteres, $choix2]
        ];
    }
}
