<?php

namespace App\Nova;

use App\Domain\Shop\Models\License as EloquentLicense;
use App\Nova\Actions\RegenerateLicenseKeyAction;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class License extends Resource
{
    public static $group = "Sales";

    public static $model = EloquentLicense::class;

    public static $title = 'key';

    public static $tableStyle = 'tight';

    public static $search = [
        'id', 'key', 'domain', 'name',
    ];

    public static $with = ['assignment'];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Purchase Assignment', 'assignment', PurchaseAssignment::class)->searchable(),

            Text::make('Key'),
            Text::make('Domain'),
            Number::make('Satis Authentication Count'),

            DateTime::make('expires_at'),

            HasMany::make('Activations'),
        ];
    }

    public function actions(NovaRequest $request)
    {
        return [
            new RegenerateLicenseKeyAction(),
        ];
    }
}
