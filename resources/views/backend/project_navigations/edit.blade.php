@extends('motor-backend::layouts.backend')

@section('htmlheader_title')
    {{ trans('motor-backend::backend/global.home') }}
@endsection

@section('contentheader_title')
    {{ trans('backend/project_navigations.edit') }}
    {!! link_to_route('backend.project_navigations.index', trans('motor-backend::backend/global.back'), ['project_navigation' => $root->id], ['class' => 'pull-right float-right btn btn-sm btn-danger']) !!}
@endsection

@section('main-content')
	@include('motor-backend::errors.list')
	@include('backend.project_navigations.form')
@endsection