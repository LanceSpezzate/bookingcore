<?php
namespace Modules\Booking\Gateways;

use Illuminate\Http\Request;
use Mockery\Exception;
use Modules\Booking\Events\BookingCreatedEvent;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\Payment;
use Omnipay\Omnipay;
use Omnipay\Stripe\Gateway;
use PHPUnit\Framework\Error\Warning;
use Validator;
use Omnipay\Common\Exception\InvalidCreditCardException;
use Illuminate\Support\Facades\Log;

use App\Helpers\Assets;

class StripeGateway extends BaseGateway
{
    protected $id = 'stripe';

    public $name = 'Stripe Checkout';

    protected $gateway;

    public function getOptionsConfigs()
    {
        return [
            [
                'type'  => 'checkbox',
                'id'    => 'enable',
                'label' => __('Enable Stripe Standard?')
            ],
            [
                'type'  => 'input',
                'id'    => 'name',
                'label' => __('Custom Name'),
                'std'   => __("Stripe")
            ],
            [
                'type'  => 'upload',
                'id'    => 'logo_id',
                'label' => __('Custom Logo'),
            ],
            [
                'type'  => 'editor',
                'id'    => 'html',
                'label' => __('Custom HTML Description')
            ],
            [
                'type'       => 'input',
                'id'        => 'stripe_secret_key',
                'label'     => __('Secret Key'),
            ],
            [
                'type'       => 'input',
                'id'        => 'stripe_publishable_key',
                'label'     => __('Publishable Key'),
            ],
            [
                'type'       => 'checkbox',
                'id'        => 'stripe_enable_sandbox',
                'label'     => __('Enable Sandbox Mode'),
            ],
            [
                'type'       => 'input',
                'id'        => 'stripe_test_secret_key',
                'label'     => __('Test Secret Key'),
            ],
            [
                'type'       => 'input',
                'id'        => 'stripe_test_publishable_key',
                'label'     => __('Test Publishable Key'),
            ]
        ];
    }

    public function process(Request $request, $booking, $service)
    {
        if (in_array($booking->status, [
            $booking::PAID,
            $booking::COMPLETED,
            $booking::CANCELLED
        ])) {

            throw new Exception(__("Booking status does need to be paid"));
        }
        if (!$booking->total) {
            throw new Exception(__("Booking total is zero. Can not process payment gateway!"));
        }
        $rules = [
            'card_name'    => ['required'],
            'token'  => ['required'],
        ];
        $messages = [
            'card_name.required'    => __('Card Name is required field'),
            'token.required'  => __('Card invalid!'),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['errors'   => $validator->errors() ], 200)->send();
        }
        $this->getGateway();
        $payment = new Payment();
        $payment->booking_id = $booking->id;
        $payment->payment_gateway = $this->id;
        $data = $this->handlePurchaseData([
            'amount'        => (float)$booking->total,
            'transactionId' => $booking->code . '.' . time()
        ], $booking, $request);
        try{
            $response = $this->gateway->purchase($data)->send();
            if ($response->isSuccessful()) {
                $payment->status = 'completed';
                $payment->logs = \GuzzleHttp\json_encode($response->getData());
                $payment->save();
                $booking->payment_id = $payment->id;
                $booking->status = $booking::PAID;
                $booking->save();
                try{
                    $booking->sendNewBookingEmails();
                    event(new BookingCreatedEvent($booking));

                } catch(\Swift_TransportException $e){
                    Log::warning($e->getMessage());
                }
                response()->json([
                    'url' => $booking->getDetailUrl()
                ])->send();
            } else {
                $payment->status = 'fail';
                $payment->logs = \GuzzleHttp\json_encode($response->getData());
                $payment->save();
                throw new Exception($response->getMessage());
            }
        }
        catch(Exception | InvalidCreditCardException $e){
            $payment->status = 'fail';
            $payment->save();
            throw new Exception('Stripe Gateway: ' . $e->getMessage());
        }
    }

    public function getGateway()
    {
        $this->gateway = Omnipay::create('Stripe');
        $this->gateway->setApiKey($this->getOption('stripe_secret_key'));
        if ($this->getOption('stripe_enable_sandbox')) {
            $this->gateway->setApiKey($this->getOption('stripe_test_secret_key'));
        }
    }

    public function handlePurchaseData($data, $booking, $request)
    {
        $data['currency'] = setting_item('currency_main');
        $data['token'] = $request->input("token");
        $data['description'] = setting_item("site_title")." - #".$booking->id;
        return $data;
    }

    public function getDisplayHtml()
    {

        $script_inline = "
        var bookingCore_gateways_stripe = {
                stripe_publishable_key:'{$this->getOption('stripe_publishable_key')}',
                stripe_test_publishable_key:'{$this->getOption('stripe_test_publishable_key')}',
                stripe_enable_sandbox:'{$this->getOption('stripe_enable_sandbox')}',
            };";
        Assets::registerJs("https://js.stripe.com/v3/",true);
        Assets::registerJs($script_inline,true,10,false,true);
        Assets::registerJs( asset('module/booking/gateways/stripe.js') ,true);
        $data = [
            'html' => $this->getOption('html', ''),
        ];
        return view("Booking::frontend.gateways.stripe",$data);
    }
}