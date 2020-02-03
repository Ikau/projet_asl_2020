<?php

namespace Tests\Unit\Modeles;

use App\Modeles\Fiches\Question;
use App\Utils\Constantes;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    public function testConstructeur()
    {
        $question = new Question;

        $attributsTests = [
            Question::COL_CHOIX      => Constantes::STRING_VIDE,
            Question::COL_INTITULE   => Constantes::STRING_VIDE,
            Question::COL_SECTION_ID => Constantes::ID_VIDE
        ];

        $this->verifieIntegriteConstructeurEloquent($attributsTests, $question, Question::NOM_TABLE);
    }
}
