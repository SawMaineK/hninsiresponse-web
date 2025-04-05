@extends('vendor.apitoolz.app')
@section('meta')
    <meta property="og:title" content="{{ $incident->title }}" />
    <meta property="og:description" content="{{ $incident->description ? Str::limit(strip_tags($incident->description), 150) : $incident->name }}" />
    <meta property="og:image" content="{{ asset('img/' . $incident->photo->url) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary_large_image" />
@endsection
