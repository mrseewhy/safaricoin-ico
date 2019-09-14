<?php

namespace App\Repositories\Frontend;

use App\Repositories\BaseRepository;
use App\Entities\Support;

/**
 * Class UserRepository.
 */
class SupportRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Support::class;
    }

}
