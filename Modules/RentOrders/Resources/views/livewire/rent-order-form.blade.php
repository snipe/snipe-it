<section class="content" id="main" tabindex="-1">

    <!-- Content -->
    <div id="webui">
        <!-- row -->
        <div class="row">
            <!-- col-md-8 -->
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">
                <form id="create-form" class="form-horizontal has-validation-callback" autocomplete="off" role="form">
                    <!-- box -->
                    <div class="box box-default">
                        <!-- box-header -->
                        <div class="box-header with-border text-right">

                            <div class="col-md-12 box-title text-right" style="padding: 0px; margin: 0px;">

                                <div class="col-md-12" style="padding: 0px; margin: 0px;">
                                    <div class="col-md-9 text-left">
                                    </div>
                                    <div class="col-md-3 text-right" style="padding-right: 10px;">
                                        <a class="btn btn-link text-left" href="/rentorders">
                                            Cancelar
                                        </a>
                                        <button class="btn btn-primary" wire:click.prevent="createRentOrder">
                                            <i class="fas fa-check icon-white" aria-hidden="true"></i>
                                            Guardar
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div><!-- /.box-header -->

                        <!-- box-body -->
                        <div class="box-body">


                            {{ csrf_field() }}

                            <livewire:rentorders::select-user />

                            <div class="col-sm-12">
                               <div style="margin-left: 25%; margin-bottom: 20px">
                                   @if($error['user'])
                                   <span style="color: darkred">Es necesario que seleccione un usuario. </span>
                                   @endIf
                               </div>
                            </div>

                            <livewire:rentorders::select-assets />

                            <livewire:rentorders::select-date />
                           
                            <div class="col-sm-12">
                               <div style="margin-left: 25%; margin-bottom: 20px">
                                   @if($error['returnDate'])
                                   <span style="color: darkred">Es necesario que seleccione una fecha estimada de devolución. </span>
                                   @endIf
                               </div>
                            </div>

                        </div> <!-- ./box-body -->
                    </div> <!-- box -->
                </form>
            </div> <!-- col-md-8 -->

        </div><!-- ./row -->


        <div class="row">
            <!-- col-md-8 -->
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">
                <form id="create-form" class="form-horizontal has-validation-callback" method="post"
                      action="http://localhost:8000/hardware" autocomplete="off" role="form"
                      enctype="multipart/form-data">
                    <!-- box -->
                    <div class="box box-default">
                        <!-- box-header -->
                        <div class="box-header with-border text-right">
                            <h4 class="title">Elementos seleccionados</h4>
                        </div><!-- /.box-header -->

                        <!-- box-body -->
                        <div class="box-body">
                            <div>
                                <table class="table">
                                    <tbody>
                                    @forEach($selected as $key => $asset)
                                    <tr style="cursor:pointer;">
                                        <td>
                                            <button wire:click.prevent="delete({{$key}})"
                                                    class="add_field_button btn btn-default btn-sm">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <img src="{{$asset['img']}}" alt="image"
                                                 style="max-height: 50px; width: auto;" class="img-responsive">
                                        </td>
                                        <td>{{$asset['name']}}</td>
                                        <td>{{$asset['model_number']}}</td>
                                        <td>{{$asset['asset_tag']}}</td>
                                        <td>{{$asset['serial']}}</td>
                                    </tr>
                                    @endForEach
                                    </tbody>
                                </table>
                                @if($error['assets'])
                                <span style="color: darkred">Es necesario que al menos seleccione un equipo... </span>
                                @endIf
                            </div>

                        </div> <!-- ./box-body -->
                    </div> <!-- box -->
                </form>
            </div> <!-- col-md-8 -->

        </div><!-- ./row -->
    </div>

</section>

