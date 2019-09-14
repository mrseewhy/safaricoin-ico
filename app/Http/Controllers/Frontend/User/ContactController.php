<?php

namespace App\Http\Controllers\Frontend\User;


use App\Http\Controllers\Controller;
use App\Repositories\Frontend\SupportRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Frontend\Contact\SendContact;
use App\Http\Requests\Frontend\Contact\SendContactRequest;
use App\Notifications\frontend\SupportConfirmation;

/**
 * Class ContactController.
 */
class ContactController extends Controller
{
    protected $supportRepository;

    public function __construct(SupportRepository $supportRepository)
    {
        $this->supportRepository = $supportRepository;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.user.contact');
    }

    /**
     * @param SendContactRequest $request
     *
     * @return mixed
     */
    public function send(SendContactRequest $request)
    {
        $supportId = $this->supportRepository->create([
            'user_id' => Auth::id(),
            'transaction_id' => $request->input('transaction_id'),
            'transaction_hash' => $request->input('transaction_hash'),
            'message' => $request->input('message')
        ]);

        Mail::send(new SendContact($request));
        Auth::user()->notify(new SupportConfirmation($request));

        return redirect()->back()->withFlashSuccess(__('alerts.frontend.contact.sent'));
    }
}
