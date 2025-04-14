<?php

namespace App\Console\Commands;

use App\Services\PaymentGateway\Providers\Asaas\Customer\AsaasCustomer;
use App\Services\PaymentGateway\Providers\Asaas\Subscription\AsaasSubscription;
use App\Services\PaymentGateway\Providers\Asaas\Subscription\Concerns\AsaasSubscriptionInput;
use App\Services\PaymentGateway\Providers\Asaas\Subscription\Enums\AsaasBilingTypesEnum;
use App\Services\PaymentGateway\Providers\Asaas\Subscription\Enums\AsaasBillingCycleEnum;
use App\Services\PaymentGateway\Utils\Trial;
use Illuminate\Console\Command;

class Play extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'play';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $customer = AsaasCustomer::first();
        $subscription = new AsaasSubscriptionInput([
            'customer' => $customer->getId(),
            'billingType' => AsaasBilingTypesEnum::PIX,
            'value' => '100.00',
            'nextDueDate' => (new Trial)->oneMonth(),
            'cycle' => AsaasBillingCycleEnum::MONTHLY,
            // 'description' => 'Assinatura de teste',
            'externalReference' => 'assinatura-123',
        ]);

        // dd($subscription->toArray());
        // Act
        $subscription = AsaasSubscription::create($subscription->toArray());
    }
}
