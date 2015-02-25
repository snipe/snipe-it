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
		$expiring_assets = Asset::getExpiringWarrantee(60);
				
		$data['count'] =  count($expiring_assets);
		$data['email_content'] ='';

		
		
		foreach ($expiring_assets as $asset) {
			$now = date("Y-m-d");
			$expires = $asset->warrantee_expires();
			$difference =  round(abs(strtotime($expires) - strtotime($now))/86400);
			
			if ($difference > 30) {
				$data['email_content'] .= '<tr style="background-color: #fcffa3;">';
			} else {
				$data['email_content'] .= '<tr style="background-color:#d9534f;">';
			}
				$data['email_content'] .= '<td><a href="'.Config::get('app.url').'/hardware/'.$asset->id.'/view">';
				$data['email_content'] .= $asset->name.'</a></td><td>'.$asset->asset_tag.'</td>';
				$data['email_content'] .= '<td>'.$asset->warrantee_expires().'</td>';
				$data['email_content'] .= '<td>'.$difference.' days</td>';
				$data['email_content'] .= '</tr>';			
		}

		if ((Setting::getSettings()->alert_email!='')  && (Setting::getSettings()->alerts_enabled==1)){
						
			if (count($expiring_assets) > 0) {
				
				Mail::send('emails.expiring-report', $data, function ($m)  {
	                $m->to(Setting::getSettings()->alert_email, Setting::getSettings()->site_name);
	                $m->subject('Expiring Assets Report');
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
