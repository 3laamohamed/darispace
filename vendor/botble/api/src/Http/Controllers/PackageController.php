<?php

namespace Botble\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use Botble\Api\Http\Resources\AccountResource;
use Botble\Api\Http\Resources\PackageResource;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Http\Responses\BaseHttpResponse;

use Botble\Media\Repositories\Interfaces\MediaFileInterface;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Payment\Repositories\Interfaces\PaymentInterface;
use Botble\RealEstate\Models\Package;
use Botble\RealEstate\Repositories\Interfaces\AccountActivityLogInterface;
use Botble\RealEstate\Repositories\Interfaces\AccountInterface;
use Botble\RealEstate\Repositories\Interfaces\PackageInterface;
use Botble\RealEstate\Repositories\Interfaces\TransactionInterface;
use EmailHandler;
use RealEstateHelper;
use Illuminate\Cache\Repository;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function __construct(
        Repository $config,
        protected AccountInterface $accountRepository,
        protected AccountActivityLogInterface $activityLogRepository,
        protected MediaFileInterface $fileRepository
    ) {

    }

    /**
     * Update Avatar
     *
     * @bodyParam avatar file required Avatar file.
     *
     * @group Package
     * @authenticated
     */

     public function getPackages(PackageInterface $packageRepository, BaseHttpResponse $response)
    {

        if (! RealEstateHelper::isEnabledCreditsSystem()) {
            abort(404);
        }


        $account = $this->accountRepository->findOrFail(
            auth()->id(),
            ['packages']
        );

        $packages = $packageRepository->advancedGet([
            'condition' => ['status' => BaseStatusEnum::PUBLISHED],
        ]);

        $packages = $packages->filter(function ($package) use ($account) {
            return $package->account_limit === null || $account->packages->where(
                'id',
                $package->id
            )->count() < $package->account_limit;
        });

        // dd($packages);
        return $response->setData([
            'packages' => PackageResource::collection($packages),
            'account' => new AccountResource($account),
        ]);
    }

    public function ajaxSubscribePackage(
        Request $request,
        PackageInterface $packageRepository,
        BaseHttpResponse $response,
        TransactionInterface $transactionRepository
    ) {
        if (! RealEstateHelper::isEnabledCreditsSystem()) {
            abort(404);
        }

        $package = $packageRepository->findOrFail($request->id);

        $account = $this->accountRepository->findOrFail(auth()->id());

        if ($package->account_limit && $account->packages()->where(
            'package_id',
            $package->id
        )->count() >= $package->account_limit) {
            abort(403);
        }

        if ((float)$package->price) {

            $paymentDetails=[];
            $paymentDetails['bank']=[
                'name'=>setting('payment_bank_transfer_name', \Botble\Payment\Enums\PaymentMethodEnum::BANK_TRANSFER()->label()),
                'status'=>setting('payment_bank_transfer_status'),
                'description'=>setting('payment_bank_transfer_description'),
            ];
            $paymentDetails['cod']=[
                'name'=>setting('payment_cod_name', \Botble\Payment\Enums\PaymentMethodEnum::COD()->label()),
                'status'=>setting('payment_cod_status'),
                'description'=>setting('payment_cod_description'),
            ];
            return $response->setData(['paymentDetails' => $paymentDetails])
            ->setMessage(__("This is paid Package please pay and call Admin to activate it"))
            ->setAdditional(['credits'=>$account->credits]);

            // session(['subscribed_packaged_id' => $package->id]);

            // return $response->setData(['next_page' => route('public.account.package.subscribe', $package->id)]);
        }

        $this->savePayment($package, null, $transactionRepository, true);

        return $response
            ->setData(new AccountResource($account->refresh()))
            ->setMessage(trans('plugins/real-estate::package.add_credit_success'));
    }

    protected function savePayment(Package $package, ?string $chargeId, TransactionInterface $transactionRepository, bool $force = false)
    {
        if (! RealEstateHelper::isEnabledCreditsSystem()) {
            abort(404);
        }

        $payment = app(PaymentInterface::class)->getFirstBy(['charge_id' => $chargeId]);

        if (! $payment && ! $force) {
            return false;
        }

        $account = auth()->user();

        if (($payment && $payment->status == PaymentStatusEnum::COMPLETED) || $force) {
            $account->credits += $package->number_of_listings;
            $account->save();

            $account->packages()->attach($package);
        }

        $transactionRepository->createOrUpdate([
            'user_id' => 0,
            'account_id' => auth()->id(),
            'credits' => $package->number_of_listings,
            'payment_id' => $payment ? $payment->id : null,
        ]);

        if (! $package->total_price) {
            EmailHandler::setModule(REAL_ESTATE_MODULE_SCREEN_NAME)
                ->setVariableValues([
                    'account_name' => $account->name,
                    'account_email' => $account->email,
                ])
                ->sendUsingTemplate('free-credit-claimed');
        } else {
            EmailHandler::setModule(REAL_ESTATE_MODULE_SCREEN_NAME)
                ->setVariableValues([
                    'account_name' => $account->name,
                    'account_email' => $account->email,
                    'package_name' => $package->name,
                    'package_price' => format_price($package->total_price / $package->number_of_listings) . '/credit',
                    'package_discount' => ($package->percent_discount ?: 0) . '%' . ($package->percent_discount > 0 ? ' (Save ' . format_price($package->price - $package->total_price) . ')' : ''),
                    'package_total' => format_price($package->total_price) . ' for ' . $package->number_of_listings . ' credits',
                ])
                ->sendUsingTemplate('payment-received');
        }

        EmailHandler::setModule(REAL_ESTATE_MODULE_SCREEN_NAME)
            ->setVariableValues([
                'account_name' => $account->name,
                'package_name' => $package->name,
                'package_price' => format_price($package->total_price / $package->number_of_listings) . '/credit',
                'package_discount' => ($package->percent_discount ?: 0) . '%' . ($package->percent_discount > 0 ? ' (Save ' . format_price($package->price - $package->total_price) . ')' : ''),
                'package_total' => format_price($package->total_price) . ' for ' . $package->number_of_listings . ' credits',
            ])
            ->sendUsingTemplate('payment-receipt', auth()->user()->email);

        return true;
    }
}
