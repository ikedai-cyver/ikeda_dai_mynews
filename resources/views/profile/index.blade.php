@extends('layouts.admin')
@section('title', 'プロフィールの一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>プロフィール一覧</h2>
        </div>
        <div class="row">
            <div class="admin-profile col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="20%">氏名</th>
                                <th width="10%">性別</th>
                                <th width="30%">趣味</th>
                                <th width="40%">自己紹介</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $profile)
                                <tr>
                                    <th>{{ $profile->name}}</th>
                                    <td>{{ $profile->gender}}</td>
                                    <td>{{ str_limit($profile->hobby, 100) }}</td>
                                    <td>{{ str_limit($profile->introduction, 250) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection