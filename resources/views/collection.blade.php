@extends('layouts.default')

@section('title', 'Collection')

@section('sidebar')
    <a href="{{ route('workspace.collections', ['workspace' => $selectedWorkspace->id]) }}"
        class="list-group-items hover-white btn-menu @if (request()->routeIs('workspace.collections')) focus @endif"
        style="text-decoration: none;">
        <span class="material-symbols-outlined" style="font-size: 36px;">folder</span>
        <label class="fw-normal cursor" style="color: white" for="">Collections</label>
    </a>
    <a href="{{ route('workspace.history', ['workspace' => $selectedWorkspace->id]) }}"
        class="list-group-items hover-white  btn-menu @if (request()->routeIs('workspace.history')) focus @endif"
        style="text-decoration: none;">
        <span class="material-symbols-outlined" style="font-size: 36px;">manage_history</span>
        <label class="fw-normal cursor" style="color: white" for="">History</label>
    </a>
    <a href="{{ route('workspace.trash', ['workspace' => $selectedWorkspace->id]) }}"
        class="list-group-items hover-white  btn-menu @if (request()->routeIs('workspace.trash')) focus @endif"
        style="text-decoration: none;">
        <span class="material-symbols-outlined" style="font-size: 36px;">delete</span>
        <label class="fw-normal cursor" style="color: white" for="">Trash</label>
    </a>
@endsection

@section('content')
    <section class="content d-flex flex-row" style="min-height: 1200px; overflow-y: auto;">
        <!-- Collection list -->
        <div style="width: 280px; border-right: #f2f2f2 solid 1px;">
            <div class="d-flex align-items-center justify-content-between p-3"
                style="height: 55px; border-bottom: #f2f2f2 solid 1px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16" width="18"
                    height="18">
                    <path
                        d="M10.561 8.073a6.005 6.005 0 0 1 3.432 5.142.75.75 0 1 1-1.498.07 4.5 4.5 0 0 0-8.99 0 .75.75 0 0 1-1.498-.07 6.004 6.004 0 0 1 3.431-5.142 3.999 3.999 0 1 1 5.123 0ZM10.5 5a2.5 2.5 0 1 0-5 0 2.5 2.5 0 0 0 5 0Z">
                    </path>
                </svg>
                <p class="mt-3 ms-2">{{ $selectedWorkspace->name }}</p>
                <div class="dropdown p-0 ms-4">
                    <button class="btn" type="button" id="workspace_option" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <span class="material-icons mt-2">more_horiz</span>
                    </button>
                    <ul class="dropdown-menu pane" aria-labelledby="workspace_option">
                        <li><a class="dropdown-item "
                                href="{{ route('workspace.setting', ['workspace' => $selectedWorkspace->id]) }}">Setting</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="{{ route('workspace.deleteWorkspace', ['workspace' => $selectedWorkspace->id]) }}">Delete</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="container">
                <div class="col d-flex align-items-center ps-0 py-2">
                    <div class="input-group">
                        <i class="fa fa-search" style="font-size: 16px; margin-top: 3px;"></i>
                        <input class="textfield"
                            style="padding-left: 35px; height:35px; width: 100%; border-radius: 5px; font-size: 14px;"
                            type="search" name="" id="" placeholder="Search collections">
                    </div>
                </div>
                <!-- Collections List -->
                @foreach ($selectedWorkspace->collections as $collection)
                    <div class="row">
                        <div class="col p-0">
                            <button class="btn-collapse dropdown hover-black d-flex align-items-center"
                                style="height: 30px; width: 100%; text-decoration:none;" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collection_{{ $collection->id }}"
                                aria-expanded="false" aria-controls="collection_{{ $collection->id }}">
                                <span class="material-symbols-outlined ms-1 me-2" name="expand"
                                    id="{{ $collection->id }}">chevron_right</span>
                                <span class="fs-6" style="font-weight: 500">{{ $collection->name }}</span>
                            </button>
                            <div class="collapse" id="collection_{{ $collection->id }}"
                                @if (session()->has('collection_' . $collection->id . '_collapse') &&
                                        session('collection_' . $collection->id . '_collapse')) aria-expanded="true" @endif>
                                {{-- Method List --}}
                                @foreach ($collection->methods as $method)
                                    <ul class="navbar-nav">
                                        <li><a
                                                href="{{ route('workspace.editCollection', ['workspace' => $selectedWorkspace->id, 'collection' => $collection->id]) }}"><label
                                                    class="me-2" style="font-size: 14px;  font-weight: 500;"
                                                    for="">{{ $method->type }}</label><label for=""
                                                    style="font-size: 14px; color: #000;">{{ $method->path }}</label></a>
                                        </li>
                                    </ul>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        <!-- Main Content -->
        <div class="" style="width: 100%;">
            <!-- Nav Tabs -->
            <ul class="nav nav-tabs flex-row" role="tablist" style="height: 55px;">
                @php
                    $collection_tabs = session('collection_tabs', []);
                @endphp
                @foreach (array_reverse($collection_tabs) as $collection)
                    <li class="nav-items">
                        <button class="nav-link fst-italic @if (request()->routeIs('workspace.editCollection') && request('collection') == $collection->id) active @endif"
                            onclick="window.location='{{ route('workspace.editCollection', ['workspace' => $selectedWorkspace->id, 'collection' => $collection->id]) }}'"
                            role="tab" id="view_{{ $collection->id }}" data-bs-toggle="tab">
                            {{ $collection->name }}
                            <a class="btn fs-5 p-0 material-symbols-outlined"
                                href='{{ route('delete.collection.tabs', ['workspace' => $selectedWorkspace->id, 'collection' => $collection->id]) }}'">close</a>
                        </button>
                    </li>
                @endforeach
                <a style="text-decoration: none"
                    href="{{ route('workspace.editCollection', ['workspace' => $selectedWorkspace->id, 'collection' => -1]) }}"
                    class="d-flex justify-content-center align-items-center p-2 add-nav-items">
                    <span class="material-symbols-outlined">add</span>
                </a>
            </ul>
            <!-- Tabs Content -->
            <div class="tab-content">
                @yield('collection_template')
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const collapseList = document.querySelectorAll('.collapse');

            collapseList.forEach(function(collapse) {
                const chevron = collapse.previousElementSibling.querySelector(
                    '.material-symbols-outlined[name="expand"]');
                const id = collapse.getAttribute('id');
                const isExpanded = sessionStorage.getItem(id);

                if (isExpanded === 'true') {
                    collapse.classList.add('show');
                    chevron.textContent = 'expand_more';
                }

                collapse.addEventListener('show.bs.collapse', function() {
                    sessionStorage.setItem(id, 'true');
                    chevron.textContent = 'expand_more';
                });

                collapse.addEventListener('hide.bs.collapse', function() {
                    sessionStorage.setItem(id, 'false');
                    chevron.textContent = 'chevron_right';
                });
            });
        });



        document.addEventListener('DOMContentLoaded', function() {
            const labels = document.querySelectorAll('.navbar-nav li label:first-child');

            labels.forEach(function(label) {
                const labelText = label.textContent.trim();
                if (labelText === 'GET') {
                    label.style.color = '#34A853';
                } else if (labelText === 'POST') {
                    label.style.color = '#FF0000';
                }
            });
        });
    </script>
@endsection
