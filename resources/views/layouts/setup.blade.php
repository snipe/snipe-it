<!DOCTYPE html>
<html>
    <head>
      <title>
        @section('title')
         Snipe-IT Setup
        @show
      </title>

         <!-- CSS -->
          <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
          <!-- Font Awesome -->
          <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
          <!-- Theme style -->
          <link rel="stylesheet" href="{{ asset('assets/css/AdminLTE.min.css') }}">
          <link rel="stylesheet" href="{{ asset('assets/css/skins/skin-blue.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/select2.min.css') }}">
          <link rel="stylesheet" href="{{ elixir('assets/css/app.css') }}">





        <script>
            window.snipeit = {
                settings: {
                    "per_page": 20
                }
            };
        </script>



        <style>
          td, th {
            font-size: 14px;
          }

          .preflight-success {
            color: green;
          }

          .preflight-error {
            color: red;
          }

          .preflight-warning {
            color: orange;
          }

          .page-header {
            font-size: 280%;
          }

          h3 {
            font-size: 250%;
          }

          .alert {
            font-size: 16px;
          }


        </style>

    </head>
    <body>
          <div class="container">
              <div class="row">
                  <div class="col-lg-10 col-lg-offset-1">
                    <h1 class="page-header">Snipe-IT Pre-Flight</h1>
                  </div>
                  <div class="col-lg-11 col-lg-offset-1">

                    <div class="row bs-wizard" style="border-bottom:0;">

                      <div class="col-xs-3 bs-wizard-step {{ ($step > 1) ? 'complete':'active' }}">
                        <div class="text-center bs-wizard-stepnum">Step 1</div>
                        <div class="progress"><div class="progress-bar"></div></div>
                        <a href="{{ route('setup') }}" class="bs-wizard-dot"></a>
                        <div class="bs-wizard-info text-center">Configuration Check</div>
                      </div>

                      <div class="col-xs-3 bs-wizard-step {{ ($step == 2) ? 'active': (($step < 2) ? 'disabled' : 'complete')  }}"><!-- complete -->
                        <div class="text-center bs-wizard-stepnum">Step 2</div>
                        <div class="progress"><div class="progress-bar"></div></div>
                        <a href="{{ route('setup.migrate') }}" class="bs-wizard-dot"></a>
                        <div class="bs-wizard-info text-center">Create Database Tables</div>
                      </div>

                      <div class="col-xs-3 bs-wizard-step {{ ($step == 3) ? 'active': (($step < 3) ? 'disabled' : 'complete')  }}"><!-- complete -->
                        <div class="text-center bs-wizard-stepnum">Step 3</div>
                        <div class="progress"><div class="progress-bar"></div></div>
                        <a href="{{ route('setup.user') }}" class="bs-wizard-dot"></a>
                        <div class="bs-wizard-info text-center">Create Admin User</div>
                      </div>

                      <div class="col-xs-3 bs-wizard-step {{ ($step == 4) ? 'active': (($step < 4) ? 'disabled' : 'complete')  }}"><!-- active -->
                        <div class="text-center bs-wizard-stepnum">Step 4</div>
                        <div class="progress"><div class="progress-bar"></div></div>
                        <a href="#" class="bs-wizard-dot"></a>
                        <div class="bs-wizard-info text-center"> Finished!</div>
                      </div>
                  </div>
                </div>

                  <div class="col-lg-10 col-lg-offset-1" style="padding-top: 50px;">


                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{ $section }}
                        </div>
                        <div class="panel-body">
                          <!-- Content -->
                          @yield('content')
                        </div>
                        <div class="panel-footer text-right">
                            @section('button')
                            @show


                        </div>
                    </div>

                  </div>
              </div>
          </div>
          <script src="{{ asset(elixir('assets/js/all.js')) }}"></script>

        <script>
            $(function () {
                $(".select2").select2();
            });
        </script>
          @section('moar_scripts')
          @show

    </body>
</html>
