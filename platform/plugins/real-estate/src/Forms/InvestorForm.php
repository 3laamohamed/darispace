<?php

namespace Botble\RealEstate\Forms;

use Botble\Base\Forms\FormAbstract;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\RealEstate\Http\Requests\InvestorRequest;
use Botble\RealEstate\Models\Investor;

class InvestorForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new Investor())
            ->setValidatorClass(InvestorRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('disc', 'editor', [
                'label' => trans('core/base::forms.content'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'rows' => 4,
                    'with-short-code' => true,
                ],
            ])
            ->add('image[]', 'mediaImages', [
                'label' => trans('plugins/real-estate::property.form.images'),
                'label_attr' => ['class' => 'control-label required'],
                'values' => $this->getModel()->id ? $this->getModel()->image : [],
            ])
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'class' => 'form-control select-full',
                ],
                'choices' => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
