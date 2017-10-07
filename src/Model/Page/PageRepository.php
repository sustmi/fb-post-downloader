<?php
declare(strict_types=1);

namespace App\Model\Page;

class PageRepository
{
    /**
     * @return Page[]
     */
    public function getAllPages(): array
    {
        return [
            new Page('o2cz'),
            new Page('TMobileCZ'),
            new Page('vodafoneCZ'),
        ];
    }
}