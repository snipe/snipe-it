<?php

    use Illuminate\Console\Command;
    use Symfony\Component\Console\Input\InputOption;
    use Symfony\Component\Console\Input\InputArgument;

    class ThreadAssetLogsCommand extends Command
    {

        /**
         * The console command name.
         *
         * @var    string
         */
        protected $name = 'app:thread_asset_log';

        /**
         * The console command description.
         *
         * @var    string
         */
        protected $description = 'This command will update your thread_id for asset logs to ensure that they are properly parented.';

        /**
         * currentAssetId
         *
         * @var int
         */
        protected $currentAssetId = null;

        /**
         * currentAssetLogId
         *
         * @var int
         */
        protected $currentAssetLogId = null;

        /**
         * assetLogs
         *
         * @var array
         */
        protected $assetLogs = null;

        /**
         * startOfCurrentThread
         *
         * @var bool
         */
        protected $startOfCurrentThread = true;

        /**
         * threadStartingActionTypes
         *
         * @var array
         */
        protected $threadStartingActionTypes = [ 'checkout', 'requested' ];

        /**
         * threadFinalActionTypes
         *
         * @var array
         */
        protected $threadFinalActionTypes = [ 'checkin from' ];

        /**
         * actionlog
         *
         * @var \Actionlog
         */
        private $actionlog;

        /**
         * Create a new command instance.
         *
         */
        public function __construct()
        {

            parent::__construct();
            $this->actionlog = new Actionlog();
            $this->assetLogs = $this->actionlog->getListingOfActionLogsChronologicalOrder();
        }

        /**
         * Execute the console command.
         *
         * @return void
         */
        public function fire()
        {

            if (!$this->confirm( "Do you want to update your asset logs to be properly threaded? [yes|no]" )) {
                return;
            }

            foreach ($this->assetLogs as $assetLog) {

                if ($this->hasAssetChanged( $assetLog )) {
                    $this->resetCurrentAssetInformation( $assetLog );
                }

                if ($this->hasBegunNewChain( $assetLog )) {
                    $this->startOfCurrentThread = false;
                    continue;
                }

                $this->updateAssetLogWithThreadInformation( $assetLog );

                if ($this->hasReachedEndOfChain( $assetLog )
                ) {
                    $this->clearCurrentAssetInformation();
                }

            }
        }

        /**
         * hasAssetChanged
         *
         * @param $assetLog
         *
         * @return bool
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        protected function hasAssetChanged( $assetLog )
        {

            return $assetLog->asset_id !== $this->currentAssetId;
        }

        /**
         * resetCurrentAssetInformation
         *
         * @param $assetLog
         *
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        protected function resetCurrentAssetInformation( $assetLog )
        {

            $this->currentAssetId       = $assetLog->asset_id;
            $this->currentAssetLogId    = $assetLog->id;
            $this->startOfCurrentThread = true;
        }

        /**
         * hasReachedEndOfChain
         *
         * @param $assetLog
         *
         * @return bool
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        protected function hasReachedEndOfChain( $assetLog )
        {

            return in_array( $assetLog->action_type, $this->threadFinalActionTypes )
                   && $this->startOfCurrentThread == false;
        }

        /**
         * clearCurrentAssetInformation
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        protected function clearCurrentAssetInformation()
        {

            $this->startOfCurrentThread = true;
            $this->currentAssetLogId    = null;
            $this->currentAssetId       = null;
        }

        /**
         * updateAssetLogWithThreadInformation
         *
         * @param $assetLog
         *
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        protected function updateAssetLogWithThreadInformation( $assetLog )
        {

            $loadedAssetLog = Actionlog::find( $assetLog->id );

            $loadedAssetLog->thread_id = $this->currentAssetLogId;

            $loadedAssetLog->update();

            unset( $loadedAssetLog );
        }

        /**
         * hasBegunNewChain
         *
         * @param $assetLog
         *
         * @return bool
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        protected function hasBegunNewChain( $assetLog )
        {

            return in_array( $assetLog->action_type, $this->threadStartingActionTypes )
                   && $this->startOfCurrentThread == true;
        }

    }
