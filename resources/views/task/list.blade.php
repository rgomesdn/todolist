@extends('layouts.app')

@section('content')
    <br>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">{{ __('task.title') }}</h2>

                <div class="card-tools">
                    <a href="{{ route('task_create') }}">
                    <span class="badge badge-success p-2">
                        <span class="fas fa-fw fa-plus"></span>
                        {{ __('common.Register') }}
                    </span>
                    </a>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                {{-- Setup data for datatables --}}
                @php
                    $data['task'] = [];

                    {{
                        foreach(json_decode($tasks) as $key => $row)
                        {
                            $delElement = '';

                            if($row->user_id == Auth::user()->id)
                            {
                                $delElement = '
                                <a href="'.route('task_edit', ['id' => $row->id]).'" class="fa fa-lg fa-fw fa-pen" data-toggle="tooltip" data-placement="top" title="'.__('common.Edit').'"></a>
                                <a href="'.route('task_delete',['id' => $row->id]).'" class="fa fa-lg fa-fw fa-trash" data-toggle="tooltip" data-placement="top" title="'.__('common.Delete').'"></a>';
                            }

                            array_push($data['task'], [
                                $row->title,
                                $row->description,
                                $row->status,
                                $row->user_id,
                                $delElement
                            ]);
                        }
                    }}            @endphp

                <div class="table-responsive">
                    <table id="table" class="table table-bordered table-hover table-striped table-dark dataTable">
                        <thead class="thead-dark">
                        <tr>
                            <th width="300">{{ __('common.Title') }}</th>
                            <th>{{ __('common.Description') }}</th>
                            <th width="100">{{ __('common.Status') }}</th>
                            <th width="150">{{ __('common.Owner') }}</th>
                            <th width="100"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['task'] as $row)
                            <tr>
                                @foreach($row as $key => $cell)
                                    <td {{ $key == 2 || $key == 3 ? 'style=text-align:center' : '' }}>{!! $cell !!}</td>
                                @endforeach
                            </tr>
                            @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->

            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>



@endsection


@section('js')
    <script>
        $(function () {
            $('#table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            $('[data-toggle="tooltip"]').tooltip({});
        });


    </script>
@stop

