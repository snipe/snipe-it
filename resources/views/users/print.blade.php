<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>分配给{{ $show_user->present()->fullName() }}</title>
    <style>
        body {
            font-family: "Arial, Helvetica", sans-serif;
        }
        table.inventory {
            border: solid #000;
            border-width: 1px 1px 1px 1px;
            width: 100%;
        }

        @page {
            size: A4;
        }
        table.inventory th, table.inventory td {
            border: solid #000;
            border-width: 0 1px 1px 0;
            padding: 3px;
            font-size: 12px;
        }
    </style>
</head>
<body>
<h3>分配给{{ $show_user->present()->fullName() }}</h3>

@if ($assets->count() > 0)
    @php
        $counter = 1;
    @endphp
    <table class="inventory">
        <thead>
        <tr>
            <th colspan="7">{{ trans('general.assets') }}</th>
        </tr>
        </thead>
        <thead>
            <tr>
                <th style="width: 20px;"></th>
                <th style="width: 20%;">资产标签</th>
                <th style="width: 20%;">名称</th>
                <th style="width: 10%;">种类</th>
                <th style="width: 20%;">模型</th>
                <th style="width: 20%;">连载</th>
                <th style="width: 10%;">登出</th>
            </tr>
        </thead>

    @foreach ($assets as $asset)

        <tr>
            <td>{{ $counter }}</td>
            <td>{{ $asset->asset_tag }}</td>
            <td>{{ $asset->name }}</td>
            <td>{{ $asset->model->category->name }}</td>
            <td>{{ $asset->model->name }}</td>
            <td>{{ $asset->serial }}</td>
            <td>
                {{ $asset->last_checkout }}</td>
        </tr>
            @php
                $counter++
            @endphp
    @endforeach
    </table>
@endif

@if ($licenses->count() > 0)
    <br><br>
    <table class="inventory">
        <thead>
        <tr>
            <th colspan="4">{{ trans('general.licenses') }}</th>
        </tr>
        </thead>
        <thead>
            <tr>
                <th style="width: 20px;"></th>
                <th style="width: 40%;">名称</th>
                <th style="width: 50%;">连载/产品秘钥</th>
                <th style="width: 10%;">登出</th>
            </tr>
        </thead>
        @php
        $lcounter = 1;
        @endphp

        @foreach ($licenses as $license)

            <tr>
                <td>{{ $lcounter }}</td>
                <td>{{ $license->name }}</td>
                <td>{{ $license->serial }}</td>
                <td>{{  $license->assetlog->first()->created_at }}</td>
            </tr>
            @php
                $lcounter++
            @endphp
        @endforeach
    </table>
@endif


@if ($accessories->count() > 0)
    <br><br>
    <table class="inventory">
        <thead>
        <tr>
            <th colspan="4">{{ trans('general.accessories') }}</th>
        </tr>
        </thead>
        <thead>
            <tr>
                <th style="width: 20px;"></th>
                <th style="width: 40%;">姓名</th>
                <th style="width: 50%;">种类</th>
                <th style="width: 10%;">登出</th>
            </tr>
        </thead>
        @php
            $acounter = 1;
        @endphp

        @foreach ($accessories as $accessory)

            <tr>
                <td>{{ $acounter }}</td>
                <td>{{ ($accessory->manufacturer) ? $accessory->manufacturer->name : '' }} {{ $accessory->name }} {{ $accessory->model_number }}</td>
                <td>{{ $accessory->category->name }}</td>
                <td>{{  $accessory->assetlog->first()->created_at }}</td>
            </tr>
            @php
                $acounter++
            @endphp
        @endforeach
    </table>
@endif

@if ($consumables->count() > 0)
    <br><br>
    <table class="inventory">
        <thead>
        <tr>
            <th colspan="4">{{ trans('general.consumables') }}</th>
        </tr>
        </thead>
        <thead>
        <tr>
            <th style="width: 20px;"></th>
            <th style="width: 40%;">名称</th>
            <th style="width: 50%;">品种</th>
            <th style="width: 10%;">登出</th>
        </tr>
        </thead>
        @php
            $ccounter = 1;
        @endphp

        @foreach ($consumables as $consumable)

            <tr>
                <td>{{ $ccounter }}</td>
                <td>{{ ($consumable->manufacturer) ? $consumable->manufacturer->name : '' }}  {{ $consumable->name }} {{ $consumable->model_number }}</td>
                <td>{{ $consumable->category->name }}</td>
                <td>{{  $consumable->assetlog->first()->created_at }}</td>
            </tr>
            @php
                $ccounter++
            @endphp
        @endforeach
    </table>
@endif

<br>
<br>
<br>
<table>
    <tr>
        <td>签名：</td>
        <td>________________________________________________________</td>
        <td></td>
        <td>日期:</td>
        <td>________________________________________________________</td>
    </tr>
</table>


</body>
</html>
