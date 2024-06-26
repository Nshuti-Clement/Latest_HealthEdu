@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    <div class="page-content">
        {{-- breadecrumb Area S t a r t --}}
        @include('backend.ui-components.breadcrumb', [
            'title' => @$data['title'],
            'routes' => [
                route('dashboard') => ___('common.Dashboard'),
                route('course.index') => ___('common.Courses'),
                '#' => @$data['title'],
            ],
            'buttons' => 0,
        ])
        {{-- breadecrumb Area E n d --}}
        <input type="hidden" id="course_id" value="{{ @$data['course']->id }}">
        <!-- Form with multiStep S t a r t-->
        <div class="table-content table-basic ecommerce-components product-list ">
            <div class="card">
                <div class="card-body">
                    <!--  toolbar table start  -->
                    <div class="table-toolbar d-flex flex-wrap gap-2 flex-column flex-xl-row justify-content-center justify-content-xxl-between align-content-center pb-3">
                        <form action="" method="get" class="align-self-center">
                            <div class="d-flex flex-wrap gap-2 flex-column flex-lg-row justify-content-center align-content-center">
                                <!-- show per page -->
                                <!-- show per page end -->
                                
                                <div class="align-self-center d-flex gap-2">
                                    <!-- search start -->
                                    <div class="align-self-center">
                                        <div class="search-box d-flex">
                                            <input class="form-control" placeholder="{{ ___('common.search') }}" name="search" 
                                                value="{{ @$_GET['search'] }}" autocomplete="off" />
                                            <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                                        </div>
                                    </div>
                                    <!-- search end -->

                                    <!-- dropdown action -->
                                    <div class="align-self-center">
                                        <div class="dropdown dropdown-action" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Filter">
                                            <button type="submit" class="btn-add">
                                                <span class="icon">{{ ___('common.Filter') }}
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- add btn start -->
                        @if (hasPermission('course_assignment_create'))
                            <div class="align-self-center d-flex gap-2">
                                <!-- add btn -->
                                <div class="align-self-center">
                                    <a href="{{ route('course.assignment.create', [$data['course']->id]) }}" role="button"
                                        class="btn-add" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="{{ ___('course.Add') }}">
                                        <span><i class="fa-solid fa-plus"></i>
                                        </span>
                                        <span class="d-none d-xl-inline">{{ ___('common.add') }}</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        <!-- add btn end -->
                    </div>
                    <!--toolbar table end -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead">
                                <!-- start table header from ui-helper function -->
                                {{ table_header('', $data['tableHeader']) }}
                                <!-- end table header from ui-helper function -->
                            </thead>
                            <tbody class="tbody">
                                @forelse ($data['assignments'] as $key => $assignment)
                                    <tr>
                                        <td>{{ @$key + 1 }}</td>
                                        <td> {{Str::limit(@$assignment->title, 20)}}</td>
                                        <td> {{ @$assignment->marks }}</td>
                                        <td> {{ @$assignment->pass_marks }}</td>
                                        <td> {{ @$assignment->deadline }}</td>
                                        <td>
                                            {{ statusBackend(@$assignment->status->class, $assignment->status->name) }}
                                        </td>
                                        <td class="action">
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @if (hasPermission('course_update'))
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('course.assignment.edit', [$assignment->id]) }}"><span
                                                                    class="icon mr-12"><i
                                                                        class="fa-solid fa-pen-to-square"></i></span>
                                                                {{ ___('common.edit') }}</a>
                                                        </li>
                                                    @endif
                                                    @if (hasPermission('course_delete'))
                                                        <li>
                                                            <a class="dropdown-item delete_data" href="javascript:void(0);"
                                                                data-href="{{ route('course.assignment.destroy', $assignment->id) }}">
                                                                <span class="icon mr-8"><i
                                                                        class="fa-solid fa-trash-can"></i></span>
                                                                <span>{{ ___('common.delete') }}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <!-- empty table -->
                                    @include('backend.ui-components.empty_table', [
                                        'colspan' => '10',
                                        'message' => ___(
                                            'message.Please add a new entity or manage the data table to see the content here'),
                                    ])
                                    <!-- empty table -->
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!--  table end -->
                    <!--  pagination start -->
                    @include('backend.ui-components.pagination', ['data' => $data['assignments']])
                    <!--  pagination end -->


                    {{-- <div class="course-assignment-lod"
                        data-href="{{ route('course.get-assignment', $data['course']->id) }}">
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('backend/assets/js/data-table/data-table.js') }}"></script>
@endpush
