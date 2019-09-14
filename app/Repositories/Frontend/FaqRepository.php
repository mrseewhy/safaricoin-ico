<?php

namespace App\Repositories\Frontend;

use App\Repositories\BaseRepository;
use App\Entities\Faq;

/**
 * Class UserRepository.
 */
class FaqRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Faq::class;
    }

}
