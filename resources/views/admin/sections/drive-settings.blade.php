@extends('admin.layout.app')

@section('content')
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>{{ $page_title }}</h1>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card file-manager-folder">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-fill">
                                        <img src="{{ asset('assets/frontend/images/icons/google_drive.png') }}"
                                            alt="" class="file-manager-folder-icon">
                                        <span class="file-manager-folder-title">Google Drive Setup</span>
                                    </div>
                                </div>
                                <form action="{{ route('admin.drive.update') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12 mt-4">
                                            <label class="form-label">Client ID</label>
                                            <input type="text" class="form-control" name="client_id"
                                                value="{{ $drive_settings->google_client_id ?? '' }}">
                                        </div>
                                        <div class="col-lg-12 mt-4">
                                            <label class="form-label">Client Secret</label>
                                            <input type="text" class="form-control" name="client_secret"
                                                value="{{ $drive_settings->google_client_secret ?? '' }}">
                                        </div>
                                        <div class="col-lg-8 mt-4">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="mt-4">
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-lg-6">
                                            <a href="{{ route('admin.drive.redirect.google') }}">Generate Refresh Token</a>
                                        </div>
                                        <div class="col-lg-6 text-end">
                                            <a href="{{ route('admin.drive.test.connection') }}">Test Connection</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card file-manager-folder">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-fill">
                                        <img src="{{ asset('assets/frontend/images/icons/google_drive.png') }}"
                                            alt="" class="file-manager-folder-icon">
                                        <span class="file-manager-folder-title">Google Drive Setup</span>
                                    </div>
                                </div>
                                <form action="{{ route('admin.drive.upload.file') }}" enctype="multipart/form-data"
                                    method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12 mt-4">
                                            <label class="form-label">File Upload</label>
                                            <input type="file" class="form-control" name="doc_file">
                                        </div>
                                        <div class="col-lg-8 mt-4">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-8">
                            @forelse ($files as $file)
                                <div class="card file-manager-recent-item">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i
                                                class="material-icons-outlined text-danger align-middle m-r-sm">description</i>
                                            <a href="#"
                                                class="file-manager-recent-item-title flex-fill">{{ Str::limit($file->file_name, 20, '...') }}</a>

                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <form action="{{ route('admin.drive.delete.file') }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="file_name"
                                                            value="{{ $file->file_name }}">
                                                        <button type="submit" class="btn btn-danger btn-burger"><i
                                                                class="material-icons">delete_outline</i></button>
                                                    </form>
                                                </div>
                                                <div class="col-lg-4">
                                                    <a href="{{ route('admin.drive.download.file',$file->file_name) }}" class="btn btn-success btn-burger"><i
                                                            class="material-icons">download</i></a>
                                                </div>
                                                <div class="col-lg-4">
                                                    <a href="{{ route('admin.drive.view.file',$file->file_name) }}" class="btn btn-primary btn-burger"><i
                                                            class="material-icons">visibility</i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
