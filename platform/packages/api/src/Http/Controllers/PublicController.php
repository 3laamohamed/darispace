<?php

namespace Botble\Api\Http\Controllers;

use Botble\Api\Http\Requests\ContactRequest;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Contact\Events\SentContactEvent;
use Botble\Contact\Repositories\Interfaces\ContactInterface;
use Botble\RealEstate\Models\Account;
use Botble\Testimonial\Models\Testimonial;
use EmailHandler;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class PublicController extends Controller
{
    public function __construct(protected ContactInterface $contactRepository)
    {
    }

    public function postSendContact(ContactRequest $request, BaseHttpResponse $response)
    {
        $blacklistDomains = setting('blacklist_email_domains');

        if ($blacklistDomains) {
            $emailDomain = Str::after(strtolower($request->input('email')), '@');

            $blacklistDomains = collect(json_decode($blacklistDomains, true))->pluck('value')->all();

            if (in_array($emailDomain, $blacklistDomains)) {
                return $response
                    ->setError()
                    ->setMessage(__('Your email is in blacklist. Please use another email address.'));
            }
        }

        $blacklistWords = trim(setting('blacklist_keywords', ''));

        if ($blacklistWords) {
            $content = strtolower($request->input('content'));

            $badWords = collect(json_decode($blacklistWords, true))
                ->filter(function ($item) use ($content) {
                    $matches = [];
                    $pattern = '/\b' . $item['value'] . '\b/iu';

                    return preg_match($pattern, $content, $matches, PREG_UNMATCHED_AS_NULL);
                })
                ->pluck('value')
                ->all();

            if (count($badWords)) {
                return $response
                    ->setError()
                    ->setMessage(__('Your message contains blacklist words: ":words".', ['words' => implode(', ', $badWords)]));
            }
        }

        try {
            $contact = $this->contactRepository->getModel();
            // dd($request->all());

            $contact->fill($request->input());
            $this->contactRepository->createOrUpdate($contact);

            event(new SentContactEvent($contact));

            $args = [];

            if ($contact->name && $contact->email) {
                $args = ['replyTo' => [$contact->name => $contact->email]];
            }

            EmailHandler::setModule(CONTACT_MODULE_SCREEN_NAME)
                ->setVariableValues([
                    'contact_name' => $contact->name ?? 'N/A',
                    'contact_subject' => $contact->subject ?? 'N/A',
                    'contact_email' => $contact->email ?? 'N/A',
                    'contact_phone' => $contact->phone ?? 'N/A',
                    'contact_address' => $contact->address ?? 'N/A',
                    'contact_content' => $contact->content ?? 'N/A',
                ])
                ->sendUsingTemplate('notice', null, $args);

            return $response->setMessage(__('Send message successfully!'));
        } catch (Exception $exception) {
            info($exception->getMessage());
            dd($exception->getMessage());
            return $response
                ->setError()
                ->setMessage(__("Can't send message on this time, please try again later!"));
        }
    }

    public function about(BaseHttpResponse $response)
    {
        $data['about']=[
            'title'=>'شركة داري سبيس للاستشارات العقارية',
            'content'=>'شركة داري سبيس للاستشارات العقارية داري سبيس للاستشارات العقارية وتطبيق داري سبيس هي وحدة اعمال داخل شركة المبرمجون العرب لتقنية المعلومات وهي شركة عقارية متخصصة في تقديم الاستشارات العقارية وتوفير العقارات المناسبة للعملاء حسب الميزانية الخاص لكل عميل كما تحتوي الشركة علي أكبر قاعدة بيانات للمطورين العقاريين بالتعاقد مع كبري شركات التطوير العقاري بمصر مما يساهم في توفير الوحدات العقارية للسادة العملاء علي حسب رغباتهم ومتطلباتهم الشخصية وتحتوي الشركة علي فريق عمل من المستشارين العقاريين ذو خبرة عالية بمجال الاستشارات العقارية والتسويق العقاري ، كما توفر خدمات الإعلانات العقارية للمستخدمين للذين يرغبون في طرح وحداتهم العقارية للبيع أو للتأجير وذلك عبر موقع وتطبيق داري سبيس',
            'video'=>'https://youtu.be/TIiwys0p2ws'
        ];
        $data['team']=Account::with('avatar')->whereIn('id',[34,35,36])->select('id','avatar_id','first_name','last_name','company','description')->get();
        $data['testimonials']=Testimonial::get();
        return $response->setData($data);
    }
}
