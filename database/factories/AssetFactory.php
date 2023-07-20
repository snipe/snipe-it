<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Location;
use App\Models\Statuslabel;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Asset::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => null,
            'model_id' => AssetModel::factory(),
            'rtd_location_id' => Location::factory(),
            'serial' => $this->faker->uuid(),
            'status_id' => function () {
                return Statuslabel::where('name', 'Ready to Deploy')->first() ?? Statuslabel::factory()->rtd()->create(['name' => 'Ready to Deploy']);
            },
            'user_id' => User::factory()->superuser(),
            'asset_tag' => $this->faker->unixTime('now'),
            'notes'   => 'Created by DB seeder',
            'purchase_date' => $this->faker->dateTimeBetween('-1 years', 'now', date_default_timezone_get())->format('Y-m-d'),
            'purchase_cost' => $this->faker->randomFloat(2, '299.99', '2999.99'),
            'order_number' => $this->faker->numberBetween(1000000, 50000000),
            'supplier_id' => Supplier::factory(),
            'requestable' => $this->faker->boolean(),
            'assigned_to' => null,
            'assigned_type' => null,
            'next_audit_date' => null,
            'last_checkout' => null,
        ];
    }

    public function laptopMbp()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'Macbook Pro 13"')->first() ?? AssetModel::factory()->mbp13Model();
                },
            ];
        });
    }

    public function laptopMbpPending()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'Macbook Pro 13"')->first() ?? AssetModel::factory()->mbp13Model();
                },
                'status_id' => function () {
                    return Statuslabel::where('name', 'Pending')->first() ?? Statuslabel::factory()->pending()->make(['name' => 'Pending']);
                },
            ];
        });
    }

    public function laptopMbpArchived()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'Macbook Pro 13"')->first() ?? AssetModel::factory()->mbp13Model();
                },
                'status_id' => function () {
                    return Statuslabel::where('name', 'Archived')->first() ?? Statuslabel::factory()->archived()->make(['name' => 'Archived']);
                },
            ];
        });
    }

    public function laptopAir()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'Macbook Air')->first() ?? AssetModel::factory()->mbpAirModel();
                },
            ];
        });
    }

    public function laptopSurface()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'Surface')->first() ?? AssetModel::factory()->surfaceModel();
                },
            ];
        });
    }

    public function laptopXps()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'XPS 13')->first() ?? AssetModel::factory()->xps13Model();
                },
            ];
        });
    }

    public function laptopSpectre()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'Spectre')->first() ?? AssetModel::factory()->spectreModel();
                },
            ];
        });
    }

    public function laptopZenbook()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'ZenBook UX310')->first() ?? AssetModel::factory()->zenbookModel();
                },
            ];
        });
    }

    public function laptopYoga()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'Yoga 910')->first() ?? AssetModel::factory()->yogaModel();
                },
            ];
        });
    }

    public function desktopMacpro()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'iMac Pro')->first() ?? AssetModel::factory()->macproModel();
                },
            ];
        });
    }

    public function desktopLenovoI5()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'Lenovo Intel Core i5')->first() ?? AssetModel::factory()->lenovoI5Model();
                },
            ];
        });
    }

    public function desktopOptiplex()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'OptiPlex')->first() ?? AssetModel::factory()->optiplexModel();
                },
            ];
        });
    }

    public function confPolycom()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'SoundStation 2')->first() ?? AssetModel::factory()->polycomModel();
                },
            ];
        });
    }

    public function confPolycomcx()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'Polycom CX3000 IP Conference Phone')->first() ?? AssetModel::factory()->polycomcxModel();
                },
            ];
        });
    }

    public function tabletIpad()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'iPad Pro')->first() ?? AssetModel::factory()->ipadModel();
                },
            ];
        });
    }

    public function tabletTab3()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'Tab3')->first() ?? AssetModel::factory()->tab3Model();
                },
            ];
        });
    }

    public function phoneIphone11()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'iPhone 11')->first() ?? AssetModel::factory()->iphone11Model();
                },
            ];
        });
    }

    public function phoneIphone12()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'iPhone 12')->first() ?? AssetModel::factory()->iphone12Model();
                },
            ];
        });
    }

    public function ultrafine()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'Ultrafine 4k')->first() ?? AssetModel::factory()->ultrafine();
                },
            ];
        });
    }

    public function ultrasharp()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'Ultrasharp U2415')->first() ?? AssetModel::factory()->ultrasharp();
                },
            ];
        });
    }

    public function assignedToUser()
    {
        return $this->state(function () {
            return [
                'assigned_to' => User::factory(),
                'assigned_type' => User::class,
            ];
        });
    }

    public function assignedToLocation()
    {
        return $this->state(function () {
            return [
                'assigned_to' => Location::factory(),
                'assigned_type' => Location::class,
            ];
        });
    }

    public function assignedToAsset()
    {
        return $this->state(function () {
            return [
                'model_id' => 1,
                'assigned_to' => Asset::factory(),
                'assigned_type' => Asset::class,
            ];
        });
    }

    public function requiresAcceptance()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'Macbook Pro 13')->first() ?? AssetModel::factory()->mbp13Model();
                },
            ];
        });
    }

    public function deleted()
    {
        return $this->state(function () {
            return [
                'model_id' => function () {
                    return AssetModel::where('name', 'Macbook Pro 13')->first() ?? AssetModel::factory()->mbp13Model();
                },
                'deleted_at' => $this->faker->dateTime(),
            ];
        });
    }

    public function requestable()
    {
        return $this->state(['requestable' => true]);
    }

    public function nonrequestable()
    {
        return $this->state(['requestable' => false]);
    }
}
