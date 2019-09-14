<p>{{ __('strings.emails.contact.email_body_title') }}</p>

<p><strong>{{ __('validation.attributes.frontend.name') }}:</strong> {{ Auth::user()->first_name }}</p>
<p><strong>{{ __('validation.attributes.frontend.email') }}:</strong> {{ Auth::user()->email }}</p>
<p><strong>{{ __('Transaction ID') }}:</strong> {{ $request->transaction_id }}</p>
<p><strong>{{ __('Transaction Hash') }}:</strong> {{ $request->transaction_hash }}</p>
<p><strong>{{ __('validation.attributes.frontend.message') }}:</strong> {{ $request->message }}</p>