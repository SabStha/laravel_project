@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('オペレーターダッシュボード') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ __('求職者評価') }}</h5>
                                    <p class="card-text">{{ __('求職者の評価を管理します。') }}</p>
                                    <a href="{{ route('operator.viewEvaluations') }}" class="btn btn-primary">{{ __('評価を見る') }}</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ __('求人リスト') }}</h5>
                                    <p class="card-text">{{ __('すべての求人リストを表示します。') }}</p>
                                    <a href="{{ route('operator.viewListings') }}" class="btn btn-primary">{{ __('リストを見る') }}</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ __('プロフィール管理') }}</h5>
                                    <p class="card-text">{{ __('プロフィール情報を管理します。') }}</p>
                                    <a href="{{ route('operator.manageProfile') }}" class="btn btn-primary">{{ __('プロフィールを編集') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
