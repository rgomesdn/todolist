@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <br>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">{{ __('common.Register'). ' ' . __('task.title') }}</h2>

                    @if($errors->any())
                        {{ implode('', $errors->all('<div>:message</div>')) }}
                    @endif
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if ($errors->any())
                                <br>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>

                                    @foreach ($errors->all() as $error)
                                        {{$error}}<br>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('task_store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="title">{{ __('common.Title') }}</label>
                                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter title" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">{{ __('common.Status') }}</label>
                                    <select class="custom-select form-control-border" id="status" name="status">
                                        <option value="concluída">{{ __('task.Completed') }}</option>
                                        <option value="pendente">{{ __('task.Pending') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- textarea -->
                                <div class="form-group">
                                    <label for="description">{{ __('common.Description') }}</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Enter description..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-block btn-success">{{ __('common.Send') }}</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <!-- /.card-body -->

                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>


    </div>
@stop

