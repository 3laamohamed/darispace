@if ($contact)
    <p>{{ trans('plugins/contact::contact.tables.time') }}: <i>{{ $contact->created_at }}</i></p>
    <p>{{ trans('plugins/contact::contact.tables.full_name') }}: <i>{{ $contact->name }}</i></p>
    <p>{{ trans('plugins/contact::contact.tables.email') }}: <i><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></i></p>
    <p>{{ trans('plugins/contact::contact.tables.phone') }}: <i>@if ($contact->phone) <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a> @else N/A @endif</i></p>
    <p>{{ trans('plugins/contact::contact.tables.address') }}: <i>{{ $contact->address ?: 'N/A' }}</i></p>
    <p>{{ __('Unit Type') }}: <i>{{ $contact->unit_type ?: 'N/A' }}</i></p>
    <p>{{ __('Purpose Of Purchase') }}: <i>{{ $contact->purpose_of_purchase ?: 'N/A' }}</i></p>
    <p>{{ __('Purchase Place') }}: <i>{{ $contact->purchase_place ?: 'N/A' }}</i></p>
    <p>{{ __('square') }}: <i>{{ $contact->square ?: 'N/A' }} M<sup>2</sup></i></p>
    <p>{{ __('budget') }}: <i>{{ $contact->budget ?: 'N/A' }}</i></p>
    <p>{{ trans('plugins/contact::contact.tables.subject') }}: <i>{{ $contact->subject ?: 'N/A' }}</i></p>
    <p>{{ trans('plugins/contact::contact.tables.content') }}:</p>
    <pre class="message-content">{{ $contact->content ?: '...' }}</pre>
@endif
