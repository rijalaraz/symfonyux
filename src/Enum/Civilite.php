<?php

namespace App\Enum;

enum Civilite : string
{
    case MONSIEUR = 'monsieur';
    case MADAME = 'madame';
    case MADEMOISELLE = 'mademoiselle';

    public function label(): string
    {
        return match ($this) {
            self::MONSIEUR => 'M.',
            self::MADAME => 'Mme.',
            self::MADEMOISELLE => 'Mlle.',
        };
    }
}
