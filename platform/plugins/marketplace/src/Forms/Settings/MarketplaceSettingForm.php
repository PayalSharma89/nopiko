<?php
namespace Botble\Marketplace\Forms\Settings;
use Botble\Base\Facades\Assets;
use Botble\Base\Forms\FieldOptions\CheckboxFieldOption;
use Botble\Base\Forms\FieldOptions\MultiChecklistFieldOption;
use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\Fields\MultiCheckListField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\OnOffCheckboxField;
use Botble\Marketplace\Facades\MarketplaceHelper;
use Botble\Marketplace\Http\Requests\MarketPlaceSettingFormRequest;
use Botble\Marketplace\Models\Store;
use Botble\Media\Facades\RvMedia;
use Botble\Setting\Forms\SettingForm;
class MarketplaceSettingForm extends SettingForm
{
    public function setup(): void
    {
        parent::setup();
        Assets::addStylesDirectly('vendor/core/core/base/libraries/tagify/tagify.css')
            ->addScriptsDirectly([
                'vendor/core/core/base/libraries/tagify/tagify.js',
                'vendor/core/core/base/js/tags.js',
                'vendor/core/plugins/marketplace/js/marketplace-setting.js',
            ]);
        $commissionEachCategory = [];
        if (MarketplaceHelper::isCommissionCategoryFeeBasedEnabled()) {
            $commissionEachCategory = Store::getCommissionEachCategory();
        }
        $allowedMimeTypes = RvMedia::getConfig('allowed_mime_types');
        $allowedMimeTypes = explode(',', $allowedMimeTypes);
        $this
            ->setSectionTitle('Marketplace Settings')
            ->setSectionDescription('Settings for configuring marketplace features and functionality.')
            ->setValidatorClass(MarketPlaceSettingFormRequest::class)
            ->contentOnly()
            ->add('fee_per_order', 'number', [
                'label' => 'Default Commission Fee',
                'value' => MarketplaceHelper::getSetting('fee_per_order', 40),
                'attr' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ])
            ->add('enable_commission_fee_for_each_category', OnOffCheckboxField::class, [
                'label' => 'Enable Commission Fee for Each Category',
                'value' => MarketplaceHelper::isCommissionCategoryFeeBasedEnabled(),
                'attr' => [
                    'data-bb-toggle' => 'collapse',
                    'data-bb-target' => '.category-commission-fee-settings',
                ],
            ])
            ->add('category_commission_fee_fields', 'html', [
                'html' => view(
                    'plugins/marketplace::settings.partials.category-commission-fee-fields',
                    compact('commissionEachCategory')
                )->render(),
            ])
            ->add('fee_withdrawal', 'number', [
                'label' => 'Withdrawal Fee',
                'value' => MarketplaceHelper::getSetting('fee_withdrawal', 0),
            ])
            ->add('check_valid_signature', OnOffCheckboxField::class, [
                'label' => 'Check Valid Signature',
                'value' => MarketplaceHelper::getSetting('check_valid_signature', true),
            ])
            ->add(
                'enable_product_approval',
                OnOffCheckboxField::class,
                CheckboxFieldOption::make()
                    ->label('Enable Product Approval')
                    ->value(MarketplaceHelper::getSetting('enable_product_approval', true))
                    ->helperText('Enable product approval feature for vendors.')
            )
            ->add('max_filesize_upload_by_vendor', 'number', [
                'label' => 'Max Upload Filesize',
                'value' => $maxSize = MarketplaceHelper::maxFilesizeUploadByVendor(),
                'attr' => [
                    'placeholder' => 'Max upload filesize: ' . $maxSize . 'MB',
                    'step' => 1,
                ],
            ])
            ->add('max_product_images_upload_by_vendor', 'number', [
                'label' => 'Max Product Images Upload by Vendor',
                'value' => MarketplaceHelper::maxProductImagesUploadByVendor(),
                'attr' => [
                    'step' => 1,
                ],
            ])
            ->add(
                'media_mime_types_allowed[]',
                MultiCheckListField::class,
                MultiChecklistFieldOption::make()
                    ->label('Allowed Media File Types for Upload')
                    ->choices(array_combine($allowedMimeTypes, $allowedMimeTypes))
                    ->selected(MarketplaceHelper::mediaMimeTypesAllowed())
            )
            ->add(
                'enabled_vendor_registration',
                OnOffCheckboxField::class,
                OnOffFieldOption::make()
                    ->label('Enable Vendor Registration')
                    ->helperText('Allow customers to register as vendors on your marketplace.')
                    ->value(MarketplaceHelper::isVendorRegistrationEnabled())
            )
            ->addOpenFieldset('vendor_registration_settings', [
                'data-bb-collapse' => 'true',
                'data-bb-trigger' => "[name='enabled_vendor_registration']",
                'data-bb-value' => '1',
                'style' => MarketplaceHelper::isVendorRegistrationEnabled() ? '' : 'display: none;',
            ])
            ->add(
                'hide_become_vendor_menu_in_customer_dashboard',
                OnOffCheckboxField::class,
                OnOffFieldOption::make()
                    ->label('Hide Become Vendor Menu in Customer Dashboard')
                    ->helperText('Hide the option for customers to become a vendor in the customer dashboard.')
                    ->value(MarketplaceHelper::getSetting('hide_become_vendor_menu_in_customer_dashboard', false))
            )
            ->add(
                'show_vendor_registration_form_at_registration_page',
                OnOffCheckboxField::class,
                OnOffFieldOption::make()
                    ->label('Show Vendor Registration Form on Registration Page')
                    ->helperText('Show the vendor registration form on the customer registration page.')
                    ->value(MarketplaceHelper::getSetting('show_vendor_registration_form_at_registration_page', true))
            )
            ->add(
                'verify_vendor',
                OnOffCheckboxField::class,
                OnOffFieldOption::make()
                    ->label('Verify Vendor')
                    ->helperText('Enable vendor verification before they can start selling.')
                    ->value(MarketplaceHelper::getSetting('verify_vendor', true))
            )
            ->add(
                'requires_vendor_documentations_verification',
                OnOffCheckboxField::class,
                OnOffFieldOption::make()
                    ->label('Require Vendor Documentation Verification')
                    ->helperText('Require vendors to upload documentation for verification.')
                    ->value(MarketplaceHelper::getSetting('requires_vendor_documentations_verification', true))
            )
            ->addCloseFieldset('vendor_registration_settings')
            // Vendor Pro Field (Independent dropdown)
            ->add(
                'enable_vendor_pro',
                OnOffCheckboxField::class,
                OnOffFieldOption::make()
                    ->label('Enable Vendor Pro')
                    ->helperText('Enable the Vendor Pro feature for vendors.')
                    ->value(MarketplaceHelper::getSetting('enable_vendor_pro', true))
            )
            ->addOpenFieldset('vendor_pro_settings', [
                'data-bb-collapse' => 'true',

                'data-bb-trigger'  => "[name='enable_vendor_pro']",
                'data-bb-value'    => '1',
                'style'             => MarketplaceHelper::getSetting('enable_vendor_pro') ? '' : 'display: none;',
            ])
            ->add(
                'hide_vendor_pro_option',
                OnOffCheckboxField::class,
                OnOffFieldOption::make()
                    ->label('Hide Vendor Pro Option')
                    ->value(MarketplaceHelper::getSetting('hide_vendor_pro_option', false))
            )
            ->addCloseFieldset('vendor_pro_settings')
            // Association Field (Independent dropdown)
            ->add(
                'enable_association',
                OnOffCheckboxField::class,
                OnOffFieldOption::make()
                    ->label('Enable Association')
                    ->helperText('Enable the Association feature for vendors.')
                    ->value(MarketplaceHelper::getSetting('enable_association', true))
            )
            ->addOpenFieldset('association_settings', [
                'data-bb-collapse' => 'true',
                'data-bb-trigger'  => "[name='enable_association']",
                'data-bb-value'    => '1',
                'style'             => MarketplaceHelper::getSetting('enable_association') ? '' : 'display: none;',
            ])
            ->add(
                'hide_association_option',
                OnOffCheckboxField::class,
                OnOffFieldOption::make()
                    ->label('Hide Association Option')
                    ->value(MarketplaceHelper::getSetting('hide_association_option', false))
            )
            ->addCloseFieldset('association_settings')
            // Other settings...
            ->add('hide_store_phone_number', OnOffCheckboxField::class, [
                'label' => 'Hide Store Phone Number',
                'value' => MarketplaceHelper::hideStorePhoneNumber(),
            ])
            ->add('hide_store_email', OnOffCheckboxField::class, [
                'label' => 'Hide Store Email',
                'value' => MarketplaceHelper::hideStoreEmail(),
            ])
            ->add('hide_store_address', OnOffCheckboxField::class, [
                'label' => 'Hide Store Address',
                'value' => MarketplaceHelper::hideStoreAddress(),
            ])
            ->add(
                'hide_store_social_links',
                OnOffCheckboxField::class,
                OnOffFieldOption::make()
                    ->label('Hide Store Social Links')
                    ->value(MarketplaceHelper::hideStoreSocialLinks())
            )
            ->add(
                'allow_vendor_manage_shipping',
                OnOffCheckboxField::class,
                OnOffFieldOption::make()
                    ->label('Allow Vendor to Manage Shipping')
                    ->value(MarketplaceHelper::allowVendorManageShipping())
                    ->helperText('Allow vendors to manage their own shipping options.')
            )
            ->add(
                'enabled_messaging_system',
                OnOffCheckboxField::class,
                OnOffFieldOption::make()
                    ->label('Enable Messaging System')
                    ->value(MarketplaceHelper::isEnabledMessagingSystem())
                    ->helperText('Allow messaging between customers and vendors.')
            )
            ->add('payment_method_fields', 'html', [
                'html' => view('plugins/marketplace::settings.partials.payment-method-fields')->render(),
            ])
            ->add(
                'minimum_withdrawal_amount',
                NumberField::class,
                NumberFieldOption::make()
                    ->label('Minimum Withdrawal Amount')
                    ->helperText('Set the minimum amount required for vendors to withdraw their earnings.')
                    ->value(MarketplaceHelper::getMinimumWithdrawalAmount())
            )
            ->add(
                'allow_vendor_delete_their_orders',
                OnOffCheckboxField::class,
                CheckboxFieldOption::make()
                    ->label('Allow Vendor to Delete Orders')
                    ->helperText(
                        'Allow vendors to delete their orders from their store management panel.'
                    )
                    ->value(MarketplaceHelper::allowVendorDeleteTheirOrders())
            )
            ->add(
                'single_vendor_checkout',
                OnOffCheckboxField::class,
                OnOffFieldOption::make()
                    ->label('Enable Single Vendor Checkout')
                    ->value(MarketplaceHelper::isSingleVendorCheckout())
                    ->helperText('Allow checkout from a single vendor only.')
            )
            ->add(
                'display_order_total_info_for_each_store',
                OnOffCheckboxField::class,
                OnOffFieldOption::make()
                    ->label('Display Order Total Information for Each Store')
                    ->value(MarketplaceHelper::getSetting('display_order_total_info_for_each_store', false))
                    ->helperText('Show detailed order total information for each store during checkout.')
            );
    }
}