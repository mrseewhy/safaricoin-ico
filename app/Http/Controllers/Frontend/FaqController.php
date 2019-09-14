<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\FaqRepository;

/**
 * Class FaqController.
 */
class FaqController extends Controller
{
    protected $faqRepository;

    public function __construct(FaqRepository $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $faqList = $this->faqRepository->get();
        return view('frontend.faq.index', [
            'faq' => $faqList
        ]);
    }
}
