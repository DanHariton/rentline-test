<?php

declare(strict_types=1);

namespace App\Entity\Enum;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum StatusCode: string implements TranslatableInterface
{
    case NEW = 'NEW';
    case ACT = 'ACT';
    case END = 'END';

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return match ($this) {
            self::NEW => $translator->trans('status_code.new.label', [], 'enums', $locale),
            self::ACT => $translator->trans('status_code.act.label', [], 'enums', $locale),
            self::END => $translator->trans('status_code.end.label', [], 'enums', $locale),
        };
    }
}
