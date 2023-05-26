<?php

namespace Botble\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    public function toArray($request): array
    {
        $data= [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'price_text' => $this->price_format,
            'price_per_post_text' => $this->price_per_listing_format . ' / ' . trans('plugins/real-estate::dashboard.per_post'),
            'percent_save' => $this->percent_save,
            'number_of_listings' => $this->number_of_listings,
            'number_posts_free' => trans('plugins/real-estate::dashboard.free') . ' ' . $this->number_of_listings . ' ' . trans('plugins/real-estate::dashboard.posts'),
            'price_text_with_sale_off' => $this->price_format . ' ' . trans('plugins/real-estate::dashboard.total') . ' (' . trans('plugins/real-estate::dashboard.save') . ' ' . $this->percent_save . '%)',
        ];

        if ((float)$this->price){
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

            $data['paymentDetails']=$paymentDetails;
        }
        return $data;
    }
}
