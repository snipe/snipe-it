<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SendExpirationAlerts extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'alerts:expiring';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'This command checks for expiring warrantees and service agreements, and sends out an alert email.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{

		// Expiring Assets
		$expiring_assets = Asset::getExpiringWarrantee(60);
		$this->info(count($expiring_assets).' expiring assets');

		$asset_data['count'] =  count($expiring_assets);
		$asset_data['email_content'] ='';
		$now = date("Y-m-d");


		foreach ($expiring_assets as $asset) {

			$expires = $asset->warrantee_expires();
			$difference =  round(abs(strtotime($expires) - strtotime($now))/86400);

			if ($difference > 30) {
				$asset_data['email_content'] .= '<tr style="background-color: #fcffa3;">';
			} else {
				$asset_data['email_content'] .= '<tr style="background-color:#d9534f;">';
			}
				$asset_data['email_content'] .= '<td><a href="'.Config::get('app.url').'/hardware/'.$asset->id.'/view">';
				$asset_data['email_content'] .= $asset->showAssetName().'</a></td><td>'.$asset->asset_tag.'</td>';
				$asset_data['email_content'] .= '<td>'.$asset->warrantee_expires().'</td>';
				$asset_data['email_content'] .= '<td>'.$difference.' days</td>';
				$asset_data['email_content'] .= '</tr>';
		}

		// Expiring licenses
		$expiring_licenses = License::getExpiringLicenses(60);
		$this->info(count($expiring_licenses).' expiring licenses');


		$license_data['count'] =  count($expiring_licenses);
		$license_data['email_content'] = '';

		foreach ($expiring_licenses as $license) {
			$expires = $license->expiration_date;
			$difference =  round(abs(strtotime($expires) - strtotime($now))/86400);

			if ($difference > 30) {
				$license_data['email_content'] .= '<tr style="background-color: #fcffa3;">';
			} else {
				$license_data['email_content'] .= '<tr style="background-color:#d9534f;">';
			}
				$license_data['email_content'] .= '<td><a href="'.Config::get('app.url').'/admin/licenses/'.$license->id.'/view">';
				$license_data['email_content'] .= $license->name.'</a></td>';
				$license_data['email_content'] .= '<td>'.$license->expiration_date.'</td>';
				$license_data['email_content'] .= '<td>'.$difference.' days</td>';
				$license_data['email_content'] .= '</tr>';
		}

		if ((Setting::getSettings()->alert_email!='')  && (Setting::getSettings()->alerts_enabled==1)) {


			if (count($expiring_assets) > 0) {
				Mail::send('emails.expiring-assets-report', $asset_data, function ($m)  {
	                $m->to(Setting::getSettings()->alert_email, Setting::getSettings()->site_name);
	                $m->subject('Expiring Assets Report');
	        	});

			}

			if (count($expiring_licenses) > 0) {
				Mail::send('emails.expiring-licenses-report', $license_data, function ($m)  {
	                $m->to(Setting::getSettings()->alert_email, Setting::getSettings()->site_name);
	                $m->subject('Expiring Licenses Report');
	        	});

			}


		} else {

			if (Setting::getSettings()->alert_email=='') {
				echo "Could not send email. No alert email configured in settings. \n";
			} elseif (Setting::getSettings()->alerts_enabled!=1) {
				echo "Alerts are disabled in the settings. No mail will be sent. \n";
			}

		}




	}





}
