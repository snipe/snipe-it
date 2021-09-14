<?php
namespace App\Notifications;
use App\Helpers\Helper;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
class BulkCheckoutAssetNotification extends Notification
{
    use Queueable;
    /**
     * @var
     */
    private $params;
    private $target;
    private $admin;
    private $note;
    private $last_checkout;
    private $expected_checkin;
    private $target_type;
    private $settings;
    private $assets;
    /**
     * Create a new notification instance.
     *
     * @param $params
     */
    public function __construct($assets, $checkedOutTo, User $checkedOutBy, $acceptance, $note, $lastCheckout, $lastCheckin)
    {
        $this->target = $checkedOutTo;
        $this->admin = $checkedOutBy;
        $this->last_checkout = $lastCheckout;
        $this->expected_checkin = $lastCheckin;
        $this->assets = $assets;
        $this->note = $note;

        $this->last_checkout = Helper::getFormattedDateObject($this->last_checkout, 'date',false);
        $this->expected_checkin = Helper::getFormattedDateObject($this->expected_checkin, 'date',false);
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via()
    {
        $notifyBy = [];
        /**
         * Only send notifications to users that have email addresses
         */
        if ($this->target instanceof User && $this->target->email != '') {
            foreach ($this->assets as $asset) {
                /**
                 * Send an email if the asset requires acceptance, has a EULA or if an email should be sent at checking/checkout
                 * so the user can accept or decline the assets
                 */
                if ($asset->requireAcceptance() || $asset->getEula() || $asset->checkin_email()) {
                    $notifyBy[0] = 'mail';
                    breaK;
                }
            }
        }
        return $notifyBy;
    }
    /**
     * Get the mail representation of the notification.
     *
     * @return MailMessage
     */
    public function toMail()
    {
        $assetsFields = [];
        $assetsToAccept = [];
        $eulaList = [];
        foreach ($this->assets as $key => $asset) {
            // Check if the asset has custom fields associated with it
            if (($asset->model) && ($asset->model->fieldset)) {
                $assetsFields[$asset['log_id']] = $asset->model->fieldset->fields;
            }
            if (method_exists($asset, 'getEula')) {
                $eulaList[] = $asset->getEula();
            }
            if (method_exists($asset, 'requireAcceptance') && $asset->requireAcceptance()) {
                $assetsToAccept[] = $asset['log_id'];
            }
        }
        $req_accept = sizeof($assetsToAccept) > 0 ? 1 : 0;
        $params = [
            'admin'         => $this->admin,
            'note'          => $this->note,
            'target'        => $this->target,
            'fields'        => $assetsFields,
            'eulaList'      => $eulaList,
            'req_accept'    => $req_accept,
            'accept_url'    =>  url('/').'/account/bulk-accept-assets/'.urlencode(base64_encode(json_encode($assetsToAccept))),
            'last_checkout' => $this->last_checkout,
            'expected_checkin'  => $this->expected_checkin,
            'assets'        => $this->assets
        ];
        $message = (new MailMessage)->markdown('notifications.markdown.bulk-checkout-asset', $params)
            ->subject(trans('mail.Confirm_asset_delivery'));
        return $message;
    }
}