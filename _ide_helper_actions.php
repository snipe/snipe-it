<?php

namespace App\Actions\CheckoutRequests;

/**
 * @method static \Lorisleiva\Actions\Decorators\JobDecorator|\Lorisleiva\Actions\Decorators\UniqueJobDecorator makeJob(mixed $assetId)
 * @method static \Lorisleiva\Actions\Decorators\UniqueJobDecorator makeUniqueJob(mixed $assetId)
 * @method static \Illuminate\Foundation\Bus\PendingDispatch dispatch(mixed $assetId)
 * @method static \Illuminate\Foundation\Bus\PendingDispatch|\Illuminate\Support\Fluent dispatchIf(bool $boolean, mixed $assetId)
 * @method static \Illuminate\Foundation\Bus\PendingDispatch|\Illuminate\Support\Fluent dispatchUnless(bool $boolean, mixed $assetId)
 * @method static dispatchSync(mixed $assetId)
 * @method static dispatchNow(mixed $assetId)
 * @method static dispatchAfterResponse(mixed $assetId)
 * @method static mixed run(mixed $assetId)
 */
class CreateCheckoutRequest
{
}
namespace Lorisleiva\Actions\Concerns;

/**
 * @method void asController()
 */
trait AsController
{
}
/**
 * @method void asListener()
 */
trait AsListener
{
}
/**
 * @method void asJob()
 */
trait AsJob
{
}
/**
 * @method void asCommand(\Illuminate\Console\Command $command)
 */
trait AsCommand
{
}