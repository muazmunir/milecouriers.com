<?php

namespace App\Providers;

use App\Interfaces\DeliveryStatusInterface;
use App\Interfaces\DeliveryTimeInterface;
use App\Interfaces\PaymentMethodInterface;
use App\Interfaces\RoleInterface;
use App\Interfaces\ServiceModeInterface;
use App\Interfaces\ShipmentInterface;
use App\Interfaces\ShippingModeInterface;
use App\Interfaces\TypesOfPackingInterface;
use App\Interfaces\UserInterface;
use App\Repositories\DeliveryStatusRepository;
use App\Repositories\DeliveryTimeRepository;
use App\Repositories\PaymentMethodRepository;
use App\Repositories\RoleRepository;
use App\Repositories\ServiceModeRepository;
use App\Repositories\ShipmentRepository;
use App\Repositories\ShippingModeRepository;
use App\Repositories\TypesOfPackingRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(RoleInterface::class, RoleRepository::class);
        $this->app->bind(DeliveryTimeInterface::class, DeliveryTimeRepository::class);
        $this->app->bind(PaymentMethodInterface::class, PaymentMethodRepository::class);
        $this->app->bind(ShippingModeInterface::class, ShippingModeRepository::class);
        $this->app->bind(TypesOfPackingInterface::class, TypesOfPackingRepository::class);
        $this->app->bind(ServiceModeInterface::class, ServiceModeRepository::class);
        $this->app->bind(ShipmentInterface::class, ShipmentRepository::class);
        $this->app->bind(DeliveryStatusInterface::class, DeliveryStatusRepository::class);
    }
}
