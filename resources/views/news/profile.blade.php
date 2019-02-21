@extends('layouts.front')
@section('content')

<div class="container">
 <h2>この記事を書いた人</h2>
 <p>{{$profiles[0]->name}}</p>
 <p>{{$profiles[0]->gender}}</p>
 <p>{{$profiles[0]->hobby}}</p>
 <p>{{$profiles[0]->introduction}}</p>
</div>
@endsection
